<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class CollectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea', array('attr' => array('class' => 'tinymce'), 'required' => false))
            ->add('coltags', 'collection', array(
                    'entry_type'   => new TagType(),
                    'allow_add'    => true,
                    'options' => array(
                        'label' => false
                    )
                )
            )
            ->add('posts', EntityType::class, array(
                'class' => 'AppBundle:Post',
                'property' => 'title',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.title', 'ASC');
                }))
            ->add('save', 'submit', array('attr'=>array('class'=>'btn-warning')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Collection'
        ));
    }
}
