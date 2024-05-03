<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/person')]
class PersonController extends AbstractController
{
    private $manager;
    private $repository;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
        $this->repository = $doctrine->getRepository(Person::class);
    }

    #[
        Route('/', name: 'app_person'),
        IsGranted('ROLE_USER')
    ]
    public function index(): Response
    {
        $persons = $this->repository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }
    #[Route('/edit/{id?0}', name: 'app_edit_person')]
    public function add(Request $request, Person $person = null): Response
    {
        if (!$person)
            $person = new Person();
        // Elle crée un formulaire qui l'image de l'objet person
        $form = $this->createForm(PersonType::class, $person);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($person);
            $this->manager->flush();
            return $this->forward('App\Controller\PersonController::index');
        }
        return $this->render('person/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/delete/{id}', name: 'app_delete_person')]
    public function delete(Person $person= null): Response
    {
        if (!$person) {
            throw new NotFoundHttpException('Personne innexistante');
        }
        $this->manager->remove($person);
        $this->manager->flush();
        return $this->forward('App\Controller\PersonController::index');
    }
}
