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

#[Route('/person')]
class PersonController extends AbstractController
{
    /**
     * @var \Doctrine\Persistence\ObjectManager
     */
    private $manager;

    private $repository;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
        $this->repository = $this->doctrine->getRepository(Person::class);
    }

    #[Route('/', name: 'app_person')]
    public function index(): Response
    {
        $persons =  $this->repository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }
    #[Route('/edit/{id?0}', name: 'app_edit_person')]
    public function add(Request $request, Person $person = null): Response
    {
        if(!$person)
            $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($person);
            $this->manager->flush();
            return $this->redirectToRoute('app_person');
        }
        return $this->render('person/add.html.twig', [
            'form' => $form->createView()
        ]);

    }
    #[Route('/remove/{id}', name: 'app_remove_person')]
    public function remove(Person $person = null): Response
    {
        if (!$person)
            throw new NotFoundHttpException('Personne innexistante !!! Yezi mla fazet');

        $this->manager->remove($person);
        $this->manager->flush();
        return $this->forward('App\Controller\PersonController::index');
    }

}
