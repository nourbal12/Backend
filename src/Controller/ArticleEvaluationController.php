<?php

declare(strict_types=1);

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ArticleEvaluation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;




class ArticleEvaluationController extends AbstractApiController {

    public function createAction(Request $request): Response {
        $evaluation = new ArticleEvaluation;
        $req = json_decode($request->getContent());

        $evaluation->setEvaluation($req->evaluation);
        $evaluation->setUserId($req->userId);
        $evaluation->setArticleId($req->articleId);

        $this->getDoctrine()->getManager()->persist($evaluation);
        $this->getDoctrine()->getManager()->flush();
 
        return new Response($request->getContent());
    }

    public function getEvaluationAction(int $userId, int $articleId): Response {

        $articles_evaluation = $this->getDoctrine()->getRepository(ArticleEvaluation::class)->findBy(['userId' => $userId, 'articleId' => $articleId]);
        return $this->json($articles_evaluation);
    }

    public function getEvaluationByArticleIdAndEvaluationValueAction(int $articleId, int $eval): Response {
        $articles_evaluation = $this->getDoctrine()->getRepository(ArticleEvaluation::class)->findBy(['evaluation' => $eval, 'articleId' => $articleId]);
        return $this->json($articles_evaluation);
    }
}