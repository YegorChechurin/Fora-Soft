<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\SubmittedTest;
use App\Entity\SubmittedAnswer;

class SubmittedAnswerType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{
		//$q =$options['data']->getQuestionId()->getWording();
		//$builder->add('submitted_test_id', HiddenType::class);
		//$builder->add('question_id', HiddenType::class);
		$builder->add('answer', TextType::class,
			['label'=>'q']
	);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => SubmittedAnswer::class,
	    ]);
	}
}