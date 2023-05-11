<?php

declare(strict_types=1);

namespace MonsieurBiz\SyliusMenuPlugin\Form\Type;

use MonsieurBiz\SyliusMenuPlugin\Entity\MenuItemInterface;
use Sylius\Bundle\CoreBundle\Form\Type\ImageType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
final class MenuItemImageType extends ImageType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'monsieurbiz_menu_menu_item_image';
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('type', ChoiceType::class, [
            'label' => 'Type',
            'multiple'=>false,
            'choices' => [
                'Mobile' => 'Mobile',
                'Desktop' => 'Desktop',
            ],
        ]);
    }
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['item'] = $options['item'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefined('item');
        $resolver->setAllowedTypes('item', MenuItemInterface::class);
    }
}
