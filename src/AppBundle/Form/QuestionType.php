<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class QuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('wording');

		/*$builder->add('answers', EntityType::class, array(
			'class' => 'AppBundle:Answer',
			'choice_label' => 'wording',
			'query_builder' => function (EntityRepository $er) use ($question) {
				return $er->createQueryBuilder('a')
					->where('a.question', '?1')->setParameter(1, $question);
			},
			'expanded' => true,
			'multiple' => true
		));*/
		
		$builder->add('answers', CollectionType::class, array(
            'entry_type' => AnswerType::class
            
        ));
      
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }

         public function getName()
  {
    return 'appbundle_question';
  }
}
