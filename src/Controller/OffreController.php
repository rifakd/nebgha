<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/offre')]
class OffreController extends AbstractController
{
    #[Route(name: 'app_offre_index', methods: ['GET'])]
    public function index(OffreRepository $offreRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(offreType::class, new offre());
        $updateForms = array();
        for ($i = 0; $i < count($offreRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(offreType::class, $offreRepository->findAll()[$i])->createView();
        }
        return $this->render('back/tableOffre.html.twig', [
            'offres' => $offreRepository->findAll(),
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
    }

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
    public function new(OffreRepository $offreRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $offre = new Offre();
        $updateForms = array();
        for ($i = 0; $i < count($offreRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(offreType::class, $offreRepository->findAll()[$i])->createView();
        }
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }
        $hasErrorsCreate = true;

        return $this->render('back/tableOffre.html.twig', [
            'offres' => $offreRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            'hasErrorsCreate' => $hasErrorsCreate,
        ]);
    }

    #[Route('/{id}', name: 'app_offre_show', methods: ['GET'])]
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offre_edit', methods: ['GET', 'POST'])]
    public function edit(OffreRepository $offreRepository,Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        $updateForms = array();
        for ($i = 0; $i < count($offreRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(OffreType::class, $offreRepository->findAll()[$i])->createView();
        }
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($offre);

            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }
        $hasErrorsCreate = true;

        return $this->render('back/tableOffre.html.twig', [
            'offres' => $offreRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            'hasErrorsCreate' => $hasErrorsCreate,
        ]);
    }

    #[Route('/{id}', name: 'app_offre_delete', methods: ['POST'])]
    public function delete(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }

}
