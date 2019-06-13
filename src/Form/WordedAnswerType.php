<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Answer;

class WordedAnswerType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{
		$builder->add('wording', TextType::class, ['label'=>'']);
		/*if ((Answer::class)->getType()=='worded') {
			$builder->add('wording', TextType::class, ['label'=>'','class'=>Answer::class]);
		} else {
			$builder->add('wording', ChoiceType::class, ['label'=>'','class'=>Answer::class]);
		}*/
		/*$builder->add('wording', function(Answer $a){
			if ($a->getType()=='worded') {
				TextType::class;
			} else {
				ChoiceType::class;
			}
			
		}, ['label'=>'','class'=>Answer::class]);*/
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => Answer::class,
	    ]);
	}
}