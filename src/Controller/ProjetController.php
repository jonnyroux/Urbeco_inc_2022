<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}
    
    #[Route('/', name: 'projet_index', methods: ['GET'])]
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // images transmises
            $images = $form->get('image')->getData();

           
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_dir'),
                    $fichier
                );

                $img =new Image;
                $img-> setNom($fichier);
                $img-> setImageUrl(
                    $this->getParameter('images_dir') . '/' . $fichier
                );
                $projet->addImage($img);

                
            }
            $entityManager =  $this->doctrine->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // images transmises
            $images = $form->get('image')->getData();

           
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_dir'),
                    $fichier
                );

                $img =new Image;
                $img-> setNom($fichier);
                $img-> setImageUrl(
                    $this->getParameter('images_dir') . '/' . $fichier
                );
                $projet->addImage($img);

                
            }
            $this->doctrine->getManager()->flush();

            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $image = $projet->getImage();

                   if($image){
                       foreach($image as $img){
                           $nomImage = $this->getParameter("images_dir") . '/' . $img->getNom();
       
                           if(file_exists($nomImage)){
                               unlink($nomImage);
                           }
                       }
                   }
                
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
