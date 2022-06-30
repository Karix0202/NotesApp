<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Form\FolderType;
use App\Repository\FolderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/folder', name: 'folder_')]
class FolderController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FolderRepository $folderRepository): Response
    {
        return $this->render('folder/index.html.twig', [
            'folders' => $folderRepository->findAll()
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, ManagerRegistry $registry): Response
    {
        $folder = new Folder();
        $form = $this->createForm(FolderType::class, $folder);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registry->getManager()->persist($folder);
            $registry->getManager()->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('folder/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
