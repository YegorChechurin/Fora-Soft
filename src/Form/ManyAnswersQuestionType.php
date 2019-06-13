<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Question;
use App\Entity\Answer;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityRepository;

class ManyAnswersQuestionType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{
		$q = $options['data'];

		$answers = $q->getAnswers();
		$i = 0;
		foreach ($answers as $a) {
			$choices[$i] = $a->getWording();
			$a_IDs[$i] = $a->getId();
			$i++;
		}

		//$q = $options['q'];
		/*$answers = $q->getAnswers();
		$i = 0;
		foreach ($answers as $a) {
			$choices[$i] = $a->getWording();
			$i++;
		}*/

		$builder->add('answers', ChoiceType::class, [
			'choices'=>[
				$choices[0],
				$choices[1],
				$choices[2],
				$choices[3],
				$choices[4]
			],
			'expanded'=>true,
			'multiple'=>true]
		);

		/*$builder->add('wording', ChoiceType::class, [
			'choices'=>[
				'1',
				'2',
				'3',
				'4',
				'5'
			],
			'expanded'=>true,
			'multiple'=>true]
		);*/
		
		/*$builder->add('question', EntityType::class, [
			'class'=>Question::class,
			'expanded'=>true,
			'multiple'=>true]
		);*/

		/*$builder->add('answers', EntityType::class, [
			'class'=>Answer::class,
			'choices'=>$q->getAnswers(),
			'query_builder' => function (EntityRepository $er) use ($a_IDs,$i) {
		        return $er->createQueryBuilder('a')
		            ->where('a.id BETWEEN :id1 AND :id2')
		            ->setParameter('id1', $a_IDs[0])
   					->setParameter('id2', $a_IDs[$i-1]);
		    },
			'label'=>$q->getWording(),
			'expanded'=>true,
			'multiple'=>true]
		);*/
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => Question::class,
	    ]);
	}
}