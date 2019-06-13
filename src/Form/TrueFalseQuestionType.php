<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Question;

class TrueFalseQuestionType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{
		$builder->add('wording', ChoiceType::class, [
			'choices'=>['True','False'],
			'expanded'=>true,
			'multiple'=>false]
		);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => Question::class,
	    ]);
	}
}