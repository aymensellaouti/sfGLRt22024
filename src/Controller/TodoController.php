<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// /todo
#[Route("/todo")]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(): Response
    {
        $todos = [
            ['name' => 'lundi', 'content' =>'sport'],
            ['name' => 'mardi', 'content' =>'Symfony'],
            ['name' => 'mercredi', 'content' =>'Repos'],
        ];
        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }
    #[Route('/list', name: 'app_todolist')]
    public function list(): Response
    {
        $todos = [
            ['name' => 'lundi', 'content' =>'sport'],
            ['name' => 'mardi', 'content' =>'Symfony'],
            ['name' => 'mercredi', 'content' =>'Repos'],
        ];
        return $this->render('fragments/todos.html.twig', [
            'todos' => $todos,
        ]);
    }
    #[Route(
        '/add/{name}/{content?ne rien faire}/{duration<[0-1]?\d{1,2}>?5}',
        name: 'app_todo_add',
    )]
    public function add($name, $content, $duration): Response
    {
        dd($name, $content, $duration);
        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }
    #[Route('/update', name: 'app_todo_update')]
    public function update(): Response
    {
        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }
}
