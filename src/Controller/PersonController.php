<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
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

    #[Route('/', name: 'app_person')]
    public function index(): Response
    {
        $persons = $this->repository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }
    #[Route('/add', name: 'app_add_person')]
    public function add(): Response
    {
        $person = new Person();
        $person
            ->setName('Sellaouti')
            ->setFirstname('aymen')
            ->setAge(41);
        $this->manager->persist($person);
        $person2 = new Person();
        $person2
            ->setName('Sellaouti2')
            ->setFirstname('aymen2')
            ->setAge(41);
        $this->manager->persist($person2);
        $this->manager->flush();
        return $this->forward('App\Controller\PersonController::index');
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
