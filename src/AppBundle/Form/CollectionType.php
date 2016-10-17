<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Form\TagType;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                }))
            ->add('excerpt')
            ->add('description', 'textarea', array('attr' => array('class' => 'tinymce'), 'required' => false))
            ->add('tags', 'collection', array(
                    'entry_type'   => new TagType(),
                    'allow_add'    => true,
                    'options' => array(
                        'label' => false
                    )
                )
            )
            ->add('files', 'collection', array(
                    'entry_type'   => new FileType(),
                    'allow_add'    => true,
                    'options' => array(
                        'label' => false,
                        'required' => $options['file']
                    )
                )
            )//entity
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
