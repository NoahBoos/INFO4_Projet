<?php

namespace App\Controller;

use App\Entity\MarkedByUser;
use App\Entity\ReadingStatus;
use App\Form\MarkedByUserType;
use App\Repository\BookRepository;
use App\Repository\MarkedByUserRepository;
use App\Repository\ReadingStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/marked/by/user')]
final class MarkedByUserController extends AbstractController
{
    #[Route(name: 'app_marked_by_user_index', methods: ['GET'])]
    public function index(MarkedByUserRepository $markedByUserRepository): Response
    {
        return $this->render('marked_by_user/index.html.twig', [
            'marked_by_users' => $markedByUserRepository->findAll(),
        ]);
    }

//    #[Route('/new', name: 'app_marked_by_user_new', methods: ['GET', 'POST'])]
//    public function new(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $markedByUser = new MarkedByUser();
//        $form = $this->createForm(MarkedByUserType::class, $markedByUser);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($markedByUser);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('app_marked_by_user_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->render('marked_by_user/new.html.twig', [
//            'marked_by_user' => $markedByUser,
//            'form' => $form,
//        ]);
//    }

    #[Route('/new/{idBook}/{idStatus}', name: 'app_marked_by_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, BookRepository $bookRepository, int $idBook, ReadingStatusRepository $readingStatusRepository, int $idStatus): Response {
        $user = $this->getUser();
        $markedByUser = new MarkedByUser();
        $markedByUser->setUser($user);
        $markedByUser->setBook($bookRepository->find($idBook));
        $markedByUser->setReadingStatus($readingStatusRepository->find($idStatus));

        $existing = $entityManager->getRepository(MarkedByUser::class)->findOneBy([
            'user' => $user,
            'book' => $bookRepository->find($idBook)
        ]);

        if ($existing) {
            $entityManager->remove($existing);
            $entityManager->flush();
        }

        $entityManager->persist($markedByUser);
        $entityManager->flush();

        return $this->redirectToRoute('app_book_show', ['id' => $bookRepository->find($idBook)->getId()]);
    }

    #[Route('/{id}', name: 'app_marked_by_user_show', methods: ['GET'])]
    public function show(MarkedByUser $markedByUser): Response
    {
        return $this->render('marked_by_user/show.html.twig', [
            'marked_by_user' => $markedByUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_marked_by_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MarkedByUser $markedByUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarkedByUserType::class, $markedByUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_marked_by_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('marked_by_user/edit.html.twig', [
            'marked_by_user' => $markedByUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marked_by_user_delete', methods: ['POST'])]
    public function delete(Request $request, MarkedByUser $markedByUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$markedByUser->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($markedByUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_marked_by_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
