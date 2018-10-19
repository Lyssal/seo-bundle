<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Form\Type;

use Lyssal\Seo\Model\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The Website form.
 */
class WebsiteType extends AbstractType
{
    /**
     * @var string The Website classname
     */
    protected $websiteClassname;


    /**
     * PageType constructor.
     *
     * @param string $websiteClassname The Website classname
     */
    public function __construct($websiteClassname)
    {
        $this->websiteClassname = $websiteClassname;
    }


    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('website', null, [
                'label' => 'website',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('title', null, [
                'label' => 'title',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('domain', null, [
                'label' => 'domain',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('author', null, [
                'label' => 'author',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('publisher', null, [
                'label' => 'publisher',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('copyright', null, [
                'label' => 'copyright',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('generator', null, [
                'label' => 'generator',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('replyTo', null, [
                'label' => 'reply_to',
                'translation_domain' => 'LyssalSeoBundle'
            ])
        ;
    }

    /**
     * Get the frequency choices.
     *
     * @return array
     */
    protected function getFrequencyChoices()
    {
        $frequencies = [];

        foreach (Page::getAvailableFrequencies() as $frequency) {
            $frequencies['frequency.'.$frequency] = $frequency;
        }

        return $frequencies;
    }


    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->websiteClassname,
            'translation_domain' => 'LyssalSeoBundle'
        ]);
    }
}
