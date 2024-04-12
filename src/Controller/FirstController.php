<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class FirstController extends AbstractController
{
//    Paramètres nommés

    #[Route('/first', name: "first2")]
    public function first2(Request $request): Response
    {
       return $this->redirectToRoute('second');
       dump($request->query->get('name'));
       return new Response('<html><body><h1>Je suis le First First</h1></body></html> ');
    }

    #[Route('/second', name: "second")]
    public function second(): Response
    {
        return new Response('<html><body><h1>Je suis le First First</h1></body></html>');
    }


    #[Route('/session', name: "session")]
    public function session(SessionInterface $session): Response
    {
        if ($session->has('nbVisite')) {
            $nbVisite = $session->get('nbVisite');
            $nbVisite++;
            $message = "Merci pour votre fidélité c'est votre $nbVisite visites";
            $session->set('nbVisite', $nbVisite);
        } else {
            $this->addFlash('success','Première visite');
            $message = "Bienvenu";
            $session->set('nbVisite', 1);
        }
        return $this->render('first/session.html.twig', ['message' => $message]);
    }

    #[Route('/{first}', name: "first")]
    public function first($first): Response
    {
        return $this->render('first/index.html.twig', [
            'param1' => $first,
            'esm' => 'aymen'
        ]);
    }

}
