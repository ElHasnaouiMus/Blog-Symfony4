<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Cocur\Slugify\Slugify;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $repo, EntityManagerInterface $em)
    {
        $Posts = $repo->findAll();
        $query = $em->createQueryBuilder();

        $query->select( 'p.Title', 'p.Slug', 'p.CreatedAt' )
        ->from( 'App\Entity\Post', 'p')
        ->setMaxResults(20)
        ->orderBy('p.CreatedAt', 'Desc');

        $Posts_Recents = $query->getQuery()->getResult();


        return $this->render('post/index.html.twig', [
            'posts' => $Posts,
            'Posts_Recents' => $Posts_Recents
        ]);
    }

    /**
     * @Route("/show/{Slug}", name="show")
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/ajouter_post", name="add_post")
     */
    public function add_post(PostType $form, Request $request, EntityManagerInterface $em)
    {

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            
            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitle()));
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('post\add.html.twig', [
            "form"=> $form->createView()
        ]);


    }

}
