<?php

declare(strict_types=1);

namespace MonsieurBiz\SyliusMenuPlugin\Form\Extension;

use MonsieurBiz\SyliusMenuPlugin\Form\Type\MenuItemImageType;
use MonsieurBiz\SyliusMenuPlugin\Form\Type\MenuItemType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

final class MenuItemTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('images', CollectionType::class, [
            'entry_type' => MenuItemImageType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'entry_options' => ['item' => $options['data']],
            'label' => 'sylius.form.shipping_method.images',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return MenuItemType::class;
    }

    public static function getExtendedTypes(): iterable
    {
        return [MenuItemType::class];
    }

}
