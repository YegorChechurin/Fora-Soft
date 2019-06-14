<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\SubmittedTest;
use App\Entity\SubmittedAnswer;
use App\Entity\Test;
use App\Form\SubmittedAnswerType;

class SubmittedTestType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{//dd($options);
		//$sub_test = $options['data'];
		//$test = $sub_test->getTestId();
		//$test_id = $test->getId();
		//$builder->add('test_id', HiddenType::class,['data'=>$test_id]);
		//$builder->add('test_id', HiddenType::class);
		$builder->add('test_id', EntityType::class,
			['class'=>Test::class,
			'choice_label'=>'name']);
		$builder->add('submittedAnswers', CollectionType::class,[
				'entry_type'=>SubmittedAnswerType::class,
				'label'=>'Please answer the following questions:']);
		$builder->add('Post', SubmitType::class, ['label' => 'Submit your answers']);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => SubmittedTest::class,
	    ]);
	}
}