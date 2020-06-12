<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegistrationType;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function register(EntityManagerInterface $em, Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        dump($request);

        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');

        }
        return $this->render('registration/index.html.twig', [
            "form"=>$form->createView()
        ]);
    }
}
