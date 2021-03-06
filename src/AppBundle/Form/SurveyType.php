<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SurveyType extends AbstractType {

    /**
     * buildForm
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class,[
            'label' => 'Titre : '
        ]);
        $builder->add('Swording', TextType::class, [
            'label' => 'Description : '
        ]);
        $builder->add('questions', CollectionType::class, array(
            'entry_type' => QuestionType::class,
            'allow_add' => true,
            'by_reference' => false
        ));
        $builder->add('save', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Survey',
            'csrf_protection' => false
        ));
    }

    public function getName() {
        return 'appbundle_survey';
    }

}
