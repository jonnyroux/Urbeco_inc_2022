<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Materiaux;
use App\Form\MateriauxType;
use App\Repository\MateriauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/materiaux')]
class MateriauxController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/', name: 'materiaux_index', methods: ['GET'])]
    public function index(MateriauxRepository $materiauxRepository): Response
    {
        return $this->render('materiaux/index.html.twig', [
            'materiauxes' => $materiauxRepository->findAll(),
        ]);
    }

    #[Route('/admin', name: 'materiaux_indexAdmin', methods: ['GET'])]
    public function indexAmin(MateriauxRepository $materiauxRepository): Response
    {
        return $this->render('materiaux/indexAdmin.html.twig', [
            'materiauxes' => $materiauxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'materiaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $materiaux = new Materiaux();
        $form = $this->createForm(MateriauxType::class, $materiaux);
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
                $materiaux->addImage($img);

                
            }

            $entityManager =  $this->doctrine->getManager();
            $entityManager->persist($materiaux);
            $entityManager->flush();

            return $this->redirectToRoute('materiaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiaux/new.html.twig', [
            'materiaux' => $materiaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'materiaux_show', methods: ['GET'])]
    public function show(Materiaux $materiaux): Response
    {
        return $this->render('materiaux/show.html.twig', [
            'materiaux' => $materiaux,
        ]);
    }

    #[Route('/{id}/edit', name: 'materiaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materiaux $materiaux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MateriauxType::class, $materiaux);
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
                $materiaux->addImage($img);

                
            }
           $this->doctrine->getManager()->flush();
            
            return $this->redirectToRoute('materiaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiaux/edit.html.twig', [
            'materiaux' => $materiaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'materiaux_delete', methods: ['POST'])]
    public function delete(Request $request, Materiaux $materiaux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materiaux->getId(), $request->request->get('_token'))) {
                   //Suppression de l'image du disque dur lorsqu'on supprime un produit.
           
                   $image = $materiaux->getImage();

                   if($image){
                       foreach($image as $img){
                           $nomImage = $this->getParameter("images_dir") . '/' . $img->getNom();
       
                           if(file_exists($nomImage)){
                               unlink($nomImage);
                           }
                       }
                   }
                
            $entityManager->remove($materiaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('materiaux_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/image', name: 'materiaux_image_delete', methods: ['POST'])]
    public function deleteImage(Request $request, Materiaux $materiaux,EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('deleteimage'.$materiaux->getId(), $request->request->get('_token'))) {
                   //Suppression de l'image du disque dur lorsqu'on supprime un produit.
           
                   $image = $materiaux->getImage();

                   if($image){
                       foreach($image as $img){
                           $nomImage = $this->getParameter("images_dir") . '/' . $img->getNom();
       
                           if(file_exists($nomImage)){
                               unlink($nomImage);
                               
                           }
                           $materiaux->removeImage($img);
                       }

                   }
                
                   $entityManager->remove($img);
                   $entityManager->flush();
        }
                 $id=$materiaux->getId();
        return $this->redirectToRoute('materiaux_edit',['id' => $id,], Response::HTTP_SEE_OTHER);
    }
   
     
  /*  #[Route('/supprime/image/{imageId}', name: 'materiaux_delete_image', methods: ['DELETE'])]
    public function deleteImage(Image $image, Request $request){
        $data = json_decode($request->getContent(), true);
        

        if($this->isCsrfTokenValid('delete'. $image->getImageId(), $data['_token'])){
            $nom = $image->getNom();
            unlink($this->getParameter('images_dir').'/'.$nom);

            $entityManager = $this->getDoctrine->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }*/
}
