<?php

/*
 * This file is part of Monsieur Biz' Menu plugin for Sylius.
 *
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusMenuPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ImagesAwareInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;

/**
 * @method MenuItemTranslationInterface getTranslation(?string $locale = null)
 */
class MenuItem implements MenuItemInterface, ImagesAwareInterface
{
    use TimestampableTrait;

    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    protected ?int $id = null;

    protected ?MenuInterface $menu = null;

    /**
     * @var Collection<int, MenuItemInterface>|null
     */
    protected ?Collection $items = null;

    protected ?MenuItemInterface $parent = null;

    protected ?int $position = null;
    
    protected ?string $style = null;
    
    protected ?string $imagePath = null;
    
    /**
     * @var Collection|ImageInterface
     */
    protected $images;
    
    public function getImagePath() :string
    {
        return $this->images[0]->getFullPath();
    }
    
    /**
     * MenuItem constructor.
     */
    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->items = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getMenu(): ?MenuInterface
    {
        return $this->menu;
    }

    /**
     * @inheritdoc
     */
    public function setMenu(?MenuInterface $menu): void
    {
        $this->menu = $menu;
        if (null !== $menu) {
            $menu->addItem($this);
        }
    }

    /**
     * @inheritdoc
     */
    public function getParent(): ?MenuItemInterface
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function setParent(?MenuItemInterface $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @inheritdoc
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @inheritdoc
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @inheritdoc
     */
    public function getItems(): ?Collection
    {
        return $this->items;
    }

    /**
     * @inheritdoc
     */
    public function setItems(?Collection $items): void
    {
        $this->items = $items;
    }

    /**
     * @inheritdoc
     */
    public function hasItem(MenuItemInterface $item): bool
    {
        if (null === $this->items) {
            return false;
        }

        return $this->items->contains($item);
    }

    /**
     * @inheritdoc
     */
    public function addItem(MenuItemInterface $item): void
    {
        if (null !== $this->items && !$this->hasItem($item)) {
            $this->items->add($item);
        }
    }

    /**
     * @inheritdoc
     */
    public function removeItem(MenuItemInterface $item): void
    {
        if (null !== $this->items && $this->hasItem($item)) {
            $this->items->removeElement($item);
        }
    }

    /**
     * @inheritdoc
     */
    public function getLabel(): ?string
    {
        return $this->getTranslation()->getLabel();
    }

    /**
     * @inheritdoc
     */
    public function getUrl(): ?string
    {
        return $this->getTranslation()->getUrl();
    }
    
     /**
     * @inheritdoc
     */
    public function getStyle(): ?string
    {
        return $this->style;
    }

    /**
     * @inheritdoc
     */
    public function setStyle($style): void
    {
        $this->style = $style;
    }
    
    /**
     * @inheritdoc
     */
    protected function createTranslation(): MenuItemTranslationInterface
    {
        return new MenuItemTranslation();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * {@inheritdoc}
     */
    public function getImagesByType(string $type): Collection
    {
        return $this->images->filter(function (ImageInterface $image) use ($type) {
            return $type === $image->getType();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function hasImage(ImageInterface $image): bool
    {
        return $this->images->contains($image);
    }

    /**
     * {@inheritdoc}
     */
    public function addImage(ImageInterface $image): void
    {
        $image->setOwner($this);
        $this->images->add($image);
    }

    /**
     * {@inheritdoc}
     */
    public function removeImage(ImageInterface $image): void
    {
        if ($this->hasImage($image)) {
            $image->setOwner(null);
            $this->images->removeElement($image);
        }
    }
}
