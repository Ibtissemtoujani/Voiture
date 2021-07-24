<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GolbalController extends AbstractController
{
    /**
     * @Route("/", name="accueil_Voiture")
     */
    public function index()
    {
        return $this->render('golbal/accueil.html.twig');
    }


    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder)
    {   $om = $this->getDoctrine()->getManager();
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $passwordCrypt = $encoder->encodePassword($utilisateur ,$utilisateur->getPassword());
            $utilisateur->setPassword($passwordCrypt);
            $utilisateur->setRoles("ROLE_USER");
            $om->persist($utilisateur);
            $om->flush();
            return $this->redirectToRoute("accueil_Voiture");
        }
        return $this->render('golbal/inscription.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
