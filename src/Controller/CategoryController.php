<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category_index_user', methods: ['GET'])]
    public function indexForUser(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/professional/category', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository, EditorRepository $editorRepository): Response
    {
        $user = $this->getUser();
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'categoriesByCurrentEditor' => $categoryRepository->findBy(['editor' => $user->getEditor()]),
            'editor' => $editorRepository->find($user->getEditor()),
        ]);
    }

    #[Route('/professional/category/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show', methods: ['GET'])]
    public function showForUser(Category $category, BookRepository $bookRepository): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'books' => $bookRepository->findBy(['category' => $category->getId()]),
        ]);
    }

//    #[Route('/professional/category/{id}', name: 'app_category_show', methods: ['GET'])]
//    public function show(Category $category): Response
//    {
//        return $this->render('category/show.html.twig', [
//            'category' => $category,
//        ]);
//    }

    #[Route('/professional/category/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/professional/category/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
