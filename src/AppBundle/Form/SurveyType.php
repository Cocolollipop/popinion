<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SurveyType extends AbstractType
{
    /**
	 * buildForm
	 * @param FormBuilderInterface $builder
     * @param array $options
	 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
		$builder->add('wording');

        $builder->add('questions', CollectionType::class, array(
            'entry_type' => QuestionType::class
        ));
		$builder->add('send', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Survey'
        ));
    }

         public function getName()
  {
    return 'pop_appbundle_survey';
  }
}
