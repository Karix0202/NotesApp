<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Form\FolderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/folder', name: 'folder_')]
class FolderController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        $folder = new Folder();
        $form = $this->createForm(FolderType::class, $folder);

        return $this->render('folder/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
