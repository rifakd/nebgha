<?php

namespace App\Controller;

use App\Entity\Devoir;
use App\Form\DevoirType;
use App\Repository\DevoirRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/devoir')]
final class DevoirController extends AbstractController
{
    #[Route(path: '/', name: 'app_devoir_index', methods: ['GET', 'POST'])]
    public function index(DevoirRepository $devoirRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevoirType::class, new Devoir());
        $updateForms = array();
        for ($i = 0; $i < count($devoirRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(devoirType::class, $devoirRepository->findAll()[$i])->createView();
        }
        return $this->render('back/tableDevoir.html.twig', [
            'devoirs' => $devoirRepository->findAll(),
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
    }

    #[Route(path: '/D', name: 'app_devoir_list', methods: ['GET'])]
    public function index1(DevoirRepository $devoirRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('devoir/devoirs.html.twig', [
            'devoirs' => $devoirRepository->findAll(),
        ]);
    }

    #[Route('/devoir/{id}', name: 'devoir_show', methods: ['GET'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function showDevoir(Devoir $devoir): Response
    {
        $questions = $devoir->getQuestions();

        return $this->render('devoir/devoir.html.twig', [
            'devoir' => $devoir,
            'questions' => $questions,
        ]);
    }

    #[Route('/new', name: 'app_devoir_new', methods: ['GET', 'POST'])]
    public function new(DevoirRepository $devoirRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $devoir = new Devoir();
        $form = $this->createForm(DevoirType::class, $devoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($devoir->getQuestions() as $question) {
                $question->setDevoir($devoir);
            }
            $entityManager->persist($devoir);
            $entityManager->flush();

            return $this->redirectToRoute('app_devoir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/tableDevoir.html.twig', [
            'devoir' => $devoir,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_devoir_show', methods: ['GET'])]
    public function show(Devoir $devoir): Response
    {
        return $this->render('devoir/show.html.twig', [
            'devoir' => $devoir,
        ]);
    }

    #[Route('/{id}/edit/{formUpdateNumber}/', name: 'app_devoir_edit', methods: ['GET', 'POST'])]
    public function edit($formUpdateNumber, DevoirRepository $devoirRepository, Request $request, Devoir $devoir, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevoirType::class, $devoir);
        $form->handleRequest($request);
        $updateForms = array();
        for ($i = 0; $i < count($devoirRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(DevoirType::class, $devoirRepository->findAll()[$i])->createView();
        }
        $form = $this->createForm(DevoirType::class, new Devoir());
        $updateform = $this->createForm(DevoirType::class, $devoir);
        $form->handleRequest($request);
        $updateform->handleRequest($request);

        if ($updateform->isSubmitted() && $updateform->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_devoir_index', [], Response::HTTP_SEE_OTHER);
        }
        $entityManager->refresh($devoir);

        return $this->render('back/tableDevoir.html.twig', [
            'devoirs' => $devoirRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            'formUpdateNumber' => $formUpdateNumber,
            'updateform' => $updateform->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_devoir_delete', methods: ['POST'])]
    public function delete(Request $request, Devoir $devoir, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devoir->getId(), $request->get('_token'))) {
            $entityManager->remove($devoir);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_devoir_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/devoir/{id}/submit', name: 'devoir_submit', methods: ['POST'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function submitDevoir(Request $request, Devoir $devoir, EntityManagerInterface $entityManager): RedirectResponse
    {
        $questions = $devoir->getQuestions();
        foreach ($questions as $question) {
            $submittedAnswer = $request->request->get('question_' . $question->getId());
            // Process the submitted answer (e.g., save to database, calculate score, etc.)
        }
        return $this->redirectToRoute('devoir_show', ['id' => $devoir->getId()]);
    }
}
