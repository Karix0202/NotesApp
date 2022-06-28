<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

#[Route('/note')]
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
            $note->setCreatedAt(new DateTime());

            $registry->getManager()->persist($note);
            $registry->getManager()->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('note/note_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'note_edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, int $id, ManagerRegistry $registry): Response
    {
        $note = $registry->getRepository(Note::class)->find($id);
        if (!$note) {
            throw $this->createNotFoundException(
                'Note with id: ' . $id . ' has not  been found'
            );
        }

        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registry->getManager()->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('note/note_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'note_delete', requirements: ['id' => '\d+'])]
    public function delete(Request $request, int $id, ManagerRegistry $registry): Response
    {
        if (!$this->isCsrfTokenValid('delete-note', $request->request->get('token'))) {
            throw new InvalidCsrfTokenException('Invalid CSRF token!');
        }

        $note = $registry->getRepository(Note::class)->find($id);
        if (!$note) {
            throw $this->createNotFoundException(
                'Note with id: ' . $id . ' has not  been found'
            );
        }

        $registry->getManager()->remove($note);
        $registry->getManager()->flush();

        if ($request->request->get('redirect_to')) {
            return $this->redirect($request->request->get('redirect_to'));
        }

        return $this->redirectToRoute('main_index');
    }

    #[Route('/search', name: 'note_search')]
    public function search(Request $request, NoteRepository $noteRepository): Response
    {
        return $this->render('note/search_result.html.twig', [
            'notes' => $noteRepository->searchByPhrase($request->query->get('phrase', ''), false),
            'error' => $request->query->get('phrase') === null ? 1 : 0,
        ]);
    }
}
