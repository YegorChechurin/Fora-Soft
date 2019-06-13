<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Question;
use App\Form\OneAnswerType;
use App\Form\ManyAnswerType;

class QuestionType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{
		$builder->add('wording');
		if ($options['data'] && $options['data']->getType()=='one_answer') {
			$builder->add('answers',CollectionType::class,[
				'entry_type'=>OneAnswerType::class,
				'label'=>$options['data']->getWording()]);
		} elseif ($options['data'] && ($options['data']->getType()=='many_answers' || $options['data']->getType()=='true/false')) {
			$builder->add('answers',CollectionType::class,[
				'entry_type'=>ManyAnswerType::class,
				'label'=>$options['data']->getWording()]);
		}
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => Question::class,
	    ]);
	}
}