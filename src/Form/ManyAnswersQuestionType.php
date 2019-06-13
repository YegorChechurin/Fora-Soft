<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Question;

class ManyAnswersQuestionType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{
		$builder->add('wording', ChoiceType::class, [
			'choices'=>function(Question $q){
				$answers = $q->getAnswers();
				$i = 0;
				foreach ($answers as $a) {
					$choices[$i] = $a->getWording();
					$i++;
				}
				return $choices;
			},
			'expanded'=>true,
			'multiple'=>true]
		);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => Question::class,
	    ]);
	}
}