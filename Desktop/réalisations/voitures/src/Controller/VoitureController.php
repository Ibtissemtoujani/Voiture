<?php

namespace App\Controller;

use App\Entity\RechercheVoiture;
use App\Form\RechercheVoitureType;
use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    /**
     * @Route("/client/voitures", name="voitures")
     */
    public function index(VoitureRepository $repository, PaginatorInterface $PaginatorInterface, Request $Request)
    {
        $rechercheVoiture = new rechercheVoiture();
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
            "admin" => false
        ]);
    }
}
