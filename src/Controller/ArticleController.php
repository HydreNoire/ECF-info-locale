<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private ArticleRepository $repo;
    public function __construct(ArticleRepository $repo)
    {
        $this->repo = $repo;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $articles = $this->repo->findAll();
        return $this->render('home/index.html.twig', ['articles' => $articles]);
    }

    #[Route('/article/{{id}}', name: 'show_article')]
    public function show($id): Response
    {
        $article = $this->repo->find($id);

        return $this->renderForm('article/show.html.twig', ['article' => $article]);
    }
}
