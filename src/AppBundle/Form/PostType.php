<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label'=>'Titre', 'required'=>true))
            ->add('category', EntityType::class, array(
                'label'=>'Catégorie de publication',
                'class' => 'AppBundle:Category',
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                }))
            ->add('description', 'textarea', array('attr' => array('class' => 'tinymce'), 'required' => false))
            ->add('places', EntityType::class, array(
                'label'=>'Lieu',
                'class' => 'AppBundle:Place',
                'property' => 'compound',
                'multiple'=>false,
                'expanded'=>true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.site', 'ASC');
                },
                  'required'=>false)
            )
            ->add('sites', 'collection', array(
                    'entry_type'   => new PlaceType(),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'options' => array(
                        'label' => false,
                        'required' => $options['file']
                    ),
                'mapped'=>false
                ))
            ->add('files', 'collection', array(
                    'entry_type'   => new FileType(),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'options' => array(
                        'label' => false,
                        'required' => $options['file']
                    )
                )
            )
            ->add('publish', 'checkbox', array(
                'label' => 'Cocher la case pour une publication immédiate',
                'required' => false))
            ->add('save', 'submit', array('attr'=>array('class'=>'btn-warning')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post',
            'file' => true
        ));
    }
}
