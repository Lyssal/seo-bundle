<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The Host form.
 */
class HostType extends AbstractType
{
    /**
     * @var string The Host classname
     */
    protected $hostClassname;


    /**
     * PageType constructor.
     *
     * @param string $hostClassname The Host classname
     */
    public function __construct($hostClassname)
    {
        $this->hostClassname = $hostClassname;
    }


    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domain', null, [
                'label' => 'domain',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('redirectionHost', null, [
                'label' => 'redirection_host',
                'translation_domain' => 'LyssalSeoBundle',
                'required' => false
            ])
            ->add('redirectionCode', ChoiceType::class, [
                'label' => 'redirection_code',
                'translation_domain' => 'LyssalSeoBundle',
                'required' => false,
                'choices' => [
                    'moved_temporarily' => Response::HTTP_FOUND,
                    'moved_permanently' => Response::HTTP_MOVED_PERMANENTLY
                ],
                'choice_translation_domain' => 'LyssalSeoBundle'
            ])
        ;
    }


    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->hostClassname,
            'translation_domain' => 'LyssalSeoBundle'
        ]);
    }
}
