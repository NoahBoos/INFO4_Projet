<?php

namespace App\Controller;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EditorController extends AbstractController
{
    #[Route('/editor', name: 'app_editor_index_user', methods: ['GET'])]
    public function indexForUser(EditorRepository $editorRepository): Response
    {
        return $this->render('editor/index.html.twig', [
            'editors' => $editorRepository->findAll(),
        ]);
    }

    #[Route('/professional/editor', name: 'app_editor_index', methods: ['GET'])]
    public function index(EditorRepository $editorRepository): Response
    {
        return $this->render('editor/index.html.twig', [
            'editors' => $editorRepository->findAll(),
        ]);
    }

    #[Route('/professional/editor/new', name: 'app_editor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($editor);
            $entityManager->flush();

            return $this->redirectToRoute('app_editor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('editor/new.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    #[Route('/editor/{id}', name: 'app_editor_show', methods: ['GET'])]
    public function show(Editor $editor, CategoryRepository $categoryRepository, BookRepository $bookRepository): Response
    {
        return $this->render('editor/show.html.twig', [
            'editor' => $editor,
            'categories' => $categoryRepository->findBy(['editor' => $editor->getId()]),
            'books' => $bookRepository->findBy(['bookEditor' => $editor->getId()]),
        ]);
    }

//    #[Route('/professional/editor/{id}', name: 'app_editor_show', methods: ['GET'])]
//    public function show(Editor $editor): Response
//    {
//        return $this->render('editor/show.html.twig', [
//            'editor' => $editor,
//        ]);
//    }

    #[Route('/professional/editor/{id}/edit', name: 'app_editor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Editor $editor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_editor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('editor/edit.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    #[Route('/professional/editor/{id}', name: 'app_editor_delete', methods: ['POST'])]
    public function delete(Request $request, Editor $editor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($editor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_editor_index', [], Response::HTTP_SEE_OTHER);
    }
}
