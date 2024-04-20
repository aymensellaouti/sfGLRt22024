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
    public function __construct(ManagerRegistry $doctrine)
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
        $person->setName('sellaouti')
               ->setFirstname('aymen')
               ->setAge(41);
//        Add in transaction
        $this->manager->persist($person);
        $person2 = new Person();
        $person2->setName('sellaouti')
               ->setFirstname('aymen')
               ->setAge(41);
//        Add in transaction
        $this->manager->persist($person2);
//        Flush the transaction
        $this->manager->flush();
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }
    #[Route('/remove/{id}', name: 'app_remove_person')]
    public function remove(Person $person = null): Response
    {
        if (!$person) {
            throw new NotFoundHttpException('Page Not Found');
        }
        $this->manager->remove($person);
        $this->manager->flush();

        return $this->forward('App\Controller\PersonController::index');
    }
}
