<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]
class NoteController extends AbstractController
{
    #[Route('/add', name: 'note_add')]
    public function add(Request $request, ManagerRegistry $registry): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $note = $form->getData();
            $note->setCreatedAt(new \DateTime());

            $registry->getManager()->persist($note);
            $registry->getManager()->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('note-form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
