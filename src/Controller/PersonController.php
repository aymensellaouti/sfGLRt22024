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
    #[Route('/add', name: 'app_add_person')]
    public function add(): Response
    {
        $person = new Person();
        $person->setName('sellaouti');
        $person->setFirstname('age');
        $person->setAge(41);

        $this->manager->persist($person);
        $this->manager->flush();
        return $this->redirectToRoute('app_person');
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
