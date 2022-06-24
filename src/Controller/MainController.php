<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\SearchNoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class MainController extends AbstractController
{
    #[Route('/', name: 'main_index', methods: ['GET'])]
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'notes' => $noteRepository->findAll()
        ]);
    }

    public function header(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(SearchNoteType::class, new Note(), [
            'action' => $this->generateUrl('note_search')
        ]);
        return $this->render('header.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
