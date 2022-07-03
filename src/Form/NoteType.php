<?php

namespace App\Form;

use App\Config\NoteColor;
use App\Entity\Folder;
use App\Entity\Note;
use App\Repository\FolderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
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
            ->add('color', EnumType::class, [
                'class' => NoteColor::class,
            ])
            ->add($options['submit_button_text'], SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
            'csrf_protection' => true,
            'submit_button_text' => 'add',
            'attr' => [
                'class' => 'note-form',
            ]
        ]);
    }
}
