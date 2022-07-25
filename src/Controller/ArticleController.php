<?php

declare(strict_types=1);

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Form\Type\ArticleType;
use Doctrine\ORM\EntityManagerInterface;


use Symfony\Component\HttpFoundation\Response;




class ArticleController extends AbstractApiController {


    public function indexAction(Request $request):Response {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->json($articles);
    }

    public function createAction(Request $request): Response
    {
        $article = new Article;
        $req = json_decode($request->getContent());

        $article->setTitle($req->title);
        $article->setContent($req->content);
        $article->setAuthor($req->author);
        $article->setAuthorId($req->author_id);
        $article->setUpvote($req->upvote);
        $article->setDownvote($req->downvote);

        $this->getDoctrine()->getManager()->persist($article);
        $this->getDoctrine()->getManager()->flush();
 
        return new Response($request->getContent());
    }

    public function updateAction(Request $request, int $id): Response {

        $req = json_decode($request->getContent());

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $article->setTitle($req->title);
        $article->setContent($req->content);
        $article->setAuthor($req->author);
        $article->setAuthorId($req->authorId);
        $article->setUpvote($req->upvote);
        $article->setDownvote($req->downvote);
        $this->getDoctrine()->getManager()->flush();

        return new Response($request->getContent());

    }

    public function deleteAction(int $id): Response {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $this->getDoctrine()->getManager()->remove($article);
        $this->getDoctrine()->getManager()->flush();

        return new Response("article deleted successfully");
    }

    public function getarticleAction(int $id): Response {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->json($article);
    }
}