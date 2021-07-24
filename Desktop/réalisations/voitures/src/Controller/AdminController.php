<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Entity\RechercheVoiture;
use App\Form\RechercheVoitureType;
use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(VoitureRepository $repository, PaginatorInterface $PaginatorInterface, Request $Request)
    {
        $rechercheVoiture = new RechercheVoiture();
        $form = $this->createForm(RechercheVoitureType::class,$rechercheVoiture);
        $form->handleRequest($Request);
        $voitures = $PaginatorInterface->paginate(
            $repository->findByPagination($rechercheVoiture),
            $Request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('voiture/Voitures.html.twig', [
            "voitures" => $voitures,
            "form" =>$form->createView(),
            "admin" => true
        ]);
    }

    /**
     * @Route("admin/creaction/", name="CreationVoiture")
     * @Route("/admin/{id}", name="modifVoiture", methods="GET|POST")
     */
    public function modification(Voiture $voiture = null, Request $request)
    {   if(!$voiture)
        {
            $voiture = new Voiture();
        }
        
        $om = $this->getDoctrine()->getManager();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $om ->persist($voiture);
            $om->flush();
            $this->addFlash('success', "L'action a été effectuée");
            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/modification.html.twig', [
            "voiture" => $voiture,
            "form" =>$form->createView(),
            "admin" => true
        ]);

    }

    /**
     * @Route("/admin/{id}", name="supVoiture", methods="SUP")
     */
    public function Suppression(Voiture $voiture , Request $request)
    {
        $om = $this->getDoctrine()->getManager();
        if($this->isCsrfTokenValid("SUP".$voiture->getId(),$request->get("_token"))){
            $om->remove($voiture);
            $om->flush();
            $this->addFlash('success',"L'action a été effectué");
            return $this->redirectToRoute("admin");
        }

    }

}
