<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $repo)
    {
        $Posts = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'posts' => $Posts,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Post $post)
    {
        return $this->render('blog/show.html.twig', [
            'post' => $post,
        ]);
    }
}
