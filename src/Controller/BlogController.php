<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/add')]
    public function add(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);

        if ($request->isMethod('POST')) {
            // form validation and so on
            return new Response();
        }

        return $this->render('blog/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
