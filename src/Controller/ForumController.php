<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Forum')]
final class ForumController extends AbstractController
{
    #[Route('/', name: 'app_Forum_index', methods: ['GET', 'POST'])]
    public function index(ForumRepository $ForumRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $forum = new Forum();

        $form = $this->createForm(ForumType::class, new Forum());
        $updateForms = array();
        for ($i = 0; $i < count($ForumRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(ForumType::class, $ForumRepository->findAll()[$i])->createView();
        }
        return $this->render('back/tableForum.html.twig', [
            'Forums' => $ForumRepository->findAll(),
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
    }

    #[Route('/new', name: 'app_Forum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ForumRepository $forumRepository): Response
    {

        $forum = new Forum();
        $updateForms = array();
        for ($i = 0; $i < count($forumRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(ForumType::class, $forumRepository->findAll()[$i])->createView();
        }

        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($forum);
            $entityManager->flush();

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($forum);
                $entityManager->flush();

                return $this->redirectToRoute('app_Forum_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->redirectToRoute('app_Forum_index', [], Response::HTTP_SEE_OTHER);
        }
        $hasErrorsCreate = true;

        return $this->render('back/tableForum.html.twig', [
            'Forums' => $forumRepository->findAll(),
            'form' => $form->createView(),
            'updateForms' => $updateForms,
            'hasErrorsCreate' => $hasErrorsCreate,
        ]);
    }
    #[Route('/{id}', name: 'app_Forum_show', methods: ['GET'])]
    public function show(Forum $forum): Response
    {
        return $this->render('Forum/show.html.twig', [
            'forum' => $forum,
        ]);
    }

    #[Route('/{id}/edit/{formUpdateNumber}/', name: 'app_Forum_edit', methods: ['GET', 'POST'])]
    public function edit($formUpdateNumber,Request $request, Forum $forum, EntityManagerInterface $entityManager,ForumRepository $forumRepository): Response
    {
       
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
        $updateForms = array();
        for ($i = 0; $i < count($forumRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(ForumType::class, $forumRepository->findAll()[$i])->createView();
        }
        $form = $this->createForm(ForumType::class, new Forum());
        $updateform = $this->createForm(ForumType::class, $forum);        $form->handleRequest($request);
        $updateform->handleRequest($request);
        if ($updateform->isSubmitted() && $updateform->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_Forum_index', [], Response::HTTP_SEE_OTHER);
        }

        $entityManager->refresh($forum);
        return $this->render('back/tableForum.html.twig', [
            'Forums' => $forumRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            "formUpdateNumber" => $formUpdateNumber,
            'updateform' => $updateform->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_Forum_delete', methods: ['POST'])]
    public function delete(Request $request, Forum $forum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $forum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($forum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_Forum_index', [], Response::HTTP_SEE_OTHER);
    }
}

