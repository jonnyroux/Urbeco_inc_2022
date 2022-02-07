<?php

namespace App\Controller;

use App\Entity\Materiaux;
use App\Form\MateriauxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/materiaux')]
class MateriauxController extends AbstractController
{
    #[Route('/', name: 'materiaux_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $materiauxes = $entityManager
            ->getRepository(Materiaux::class)
            ->findAll();

        return $this->render('materiaux/index.html.twig', [
            'materiauxes' => $materiauxes,
        ]);
    }

    #[Route('/new', name: 'materiaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $materiaux = new Materiaux();
        $form = $this->createForm(MateriauxType::class, $materiaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($materiaux);
            $entityManager->flush();

            return $this->redirectToRoute('materiaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiaux/new.html.twig', [
            'materiaux' => $materiaux,
            'form' => $form,
        ]);
    }

    #[Route('/{materiauxId}', name: 'materiaux_show', methods: ['GET'])]
    public function show(Materiaux $materiaux): Response
    {
        return $this->render('materiaux/show.html.twig', [
            'materiaux' => $materiaux,
        ]);
    }

    #[Route('/{materiauxId}/edit', name: 'materiaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materiaux $materiaux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MateriauxType::class, $materiaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('materiaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiaux/edit.html.twig', [
            'materiaux' => $materiaux,
            'form' => $form,
        ]);
    }

    #[Route('/{materiauxId}', name: 'materiaux_delete', methods: ['POST'])]
    public function delete(Request $request, Materiaux $materiaux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materiaux->getMateriauxId(), $request->request->get('_token'))) {
            $entityManager->remove($materiaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('materiaux_index', [], Response::HTTP_SEE_OTHER);
    }
}
