<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cours')]
final class CoursController extends AbstractController
{
    #[Route(path: '/', name: 'app_cours_index', methods: ['GET', 'POST'])]
    public function index(CoursRepository $coursRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $cours = new Cours();
        $cours->setDateCreation(new \DateTime()); // Initialize dateCreation with current date
        $cours->setDate(new \DateTime());
        $cours->setHeureDebut(new \DateTime());
        
        $form = $this->createForm(CoursType::class, $cours);
        $updateForms = array();
        for ($i = 0; $i < count($coursRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(coursType::class, $coursRepository->findAll()[$i])->createView();
        }
        return $this->render('back/tableCours.html.twig', [
            'cours' => $coursRepository->findAll(),
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
    }

    #[Route(path: '/cour', name: 'app_cour_listeCour', methods: ['GET'])]
    public function index1(CoursRepository $coursRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        return $this->render('cours/cours.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CoursRepository $coursRepository): Response
    {
        $cour = new Cours();
        $updateForms = array();
        for ($i = 0; $i < count($coursRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(CoursType::class, $coursRepository->findAll()[$i])->createView();
        }
        $cour->setDateCreation(dateCreation: new \DateTime());
        $cour->setDate(date: new \DateTime());

        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        $hasErrorsCreate = true;
        return $this->render('back/tableCours.html.twig', [
            'cours' => $coursRepository->findAll(),
            'form' => $form->createView(),
            'updateForms' => $updateForms,
            'hasErrorsCreate' => $hasErrorsCreate,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    #[Route('/{id}/edit/{formUpdateNumber}/', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit($formUpdateNumber, Request $request, Cours $cour, EntityManagerInterface $entityManager,CoursRepository $coursRepository): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);
        $updateForms = array();
        for ($i = 0; $i < count($coursRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(CoursType::class, $coursRepository->findAll()[$i])->createView();
        }
        $form = $this->createForm(CoursType::class, new Cours());
        $updateform = $this->createForm(CoursType::class, $cour);        $form->handleRequest($request);
        $updateform->handleRequest($request);
        if ($updateform->isSubmitted() && $updateform->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        $entityManager->refresh($cour);
        return $this->render('back/tableCours.html.twig', [
            'cours' => $coursRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            "formUpdateNumber" => $formUpdateNumber,
            'updateform' => $updateform->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
