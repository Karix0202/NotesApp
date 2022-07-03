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
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

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
            $folder->setCreatedAt(new \DateTime());
            $registry->getManager()->persist($folder);
            $registry->getManager()->flush();

            return $this->redirectToRoute('main_index');
        }

        return $this->render('folder/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Request $request, int $id, FolderRepository $folderRepository): Response
    {
        if (!$this->isCsrfTokenValid('delete-folder', $request->request->get('token'))) {
            throw new InvalidCsrfTokenException(
                'Invalid CSRF token!'
            );
        }

        $folder = $folderRepository->find($id);
        if (!$folder) {
            throw $this->createNotFoundException(
                'Folder with id: ' . $id . ' has not been found!'
            );
        }

        $folderRepository->remove($folder, true);

        return $this->redirectToRoute('folder_index');
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, int $id, ManagerRegistry $registry): Response
    {
        $folder = $registry->getRepository(Folder::class)->find($id);
        if (!$folder) {
            throw $this->createNotFoundException(
                'Folder with id: ' . $id . ' has not been found!'
            );
        }

        $form = $this->createForm(FolderType::class, $folder, [
            'submit_button_text' => 'save',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registry->getManager()->flush();

            return $this->redirectToRoute('folder_index');
        }

        return $this->render('folder/edit.html.twig', [
            'form' => $form->createView(),
            'folder' => $folder,
        ]);
    }
}
