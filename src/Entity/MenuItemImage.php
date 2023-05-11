<?php

declare(strict_types=1);

namespace MonsieurBiz\SyliusMenuPlugin\Entity;

use Sylius\Component\Core\Model\Image;

class MenuItemImage extends Image
{
    protected string $fullPath;
 public function getFullPath(): ?string
   {
       return '/media/image/'.$this->path;
   } 
}
