<?php

namespace App\Controller;

use App\Repository\FolderRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(FolderRepository $folderRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'folders' => $folderRepository->findAll(),
        ]);
    }
}
