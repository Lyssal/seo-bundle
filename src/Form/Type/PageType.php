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
 * The Page form.
 */
class PageType extends AbstractType
{
    /**
     * @var string The Page classname
     */
    protected $pageClassname;

    /**
     * @var string The locale
     */
    protected $locale;


    /**
     * PageType constructor.
     *
     * @param string $pageClassname The Page classname
     * @param string $locale        The locale
     */
    public function __construct($pageClassname, $locale)
    {
        $this->pageClassname = $pageClassname;
        $this->locale = $locale;
    }


    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $localeOptions = [
            'label' => 'locale',
            'translation_domain' => 'LyssalSeoBundle'
        ];
        $indexedOptions = [
            'label' => 'indexed',
            'translation_domain' => 'LyssalSeoBundle'
        ];
        $followedOptions = [
            'label' => 'followed',
            'translation_domain' => 'LyssalSeoBundle'
        ];

        if (null === $builder->getData()) {
            $localeOptions['data'] = $this->locale;
            $indexedOptions['data'] = true;
            $followedOptions['data'] = true;
        }

        $builder
            ->add('website', null, [
                'label' => 'website',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('online', null, [
                'label' => 'online',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('title', null, [
                'label' => 'title',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('slug', null, [
                'label' => 'slug',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('description', null, [
                'label' => 'description',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('locale', null, $localeOptions)
            ->add('indexed', null, $indexedOptions)
            ->add('followed', null, $followedOptions)
            ->add('modificationFrequency', ChoiceType::class, [
                'label' => 'modification_frequency',
                'required' => false,
                'translation_domain' => 'LyssalSeoBundle',
                'choices' => $this->getFrequencyChoices(),
                'choice_translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('priority', null, [
                'label' => 'priority',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('category', null, [
                'label' => 'category',
                'translation_domain' => 'LyssalSeoBundle'
            ])
            ->add('author', null, [
                'label' => 'author',
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
            'data_class' => $this->pageClassname,
            'translation_domain' => 'LyssalSeoBundle'
        ]);
    }
}
