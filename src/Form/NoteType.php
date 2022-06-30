<?php

namespace App\Form;

use App\Entity\Folder;
use App\Entity\Note;
use App\Repository\FolderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('folder', EntityType::class, [
                'class' => Folder::class,
                'query_builder' => function (FolderRepository $folderRepository) {
                    return $folderRepository->createQueryBuilder('f')
                        ->orderBy('f.id', 'DESC')
                    ;
                }
            ])
            ->add('color', ChoiceType::class, [
                'choices' => [
                    'default' => 'default',
                    'yellow' => 'yellow',
                    'green' => 'green',
                    'blue' => 'blue',
                    'red' => 'red'
                ]
            ])
            ->add('add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
            'csrf_protection' => true,
        ]);
    }
}
