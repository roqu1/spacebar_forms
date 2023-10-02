<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        // in the createForm() method, we give the form of the class that we just created in ArticleFormType.php
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $em->persist($article);
            $em->flush();

            $this->addFlash("success", "Article Created! Knowledge is power!");

            return $this->redirectToRoute("admin_article_list");
        }

        return $this->render("article/new.html.twig", [
            // articleForm is the name of the variable that we will use in the template
            // $form->createView() is a method that will create a view of the form
            "articleForm" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit", name="admin_article_edit")
     * @IsGranted("MANAGE", subject="article")
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ArticleFormType::class, $article, [
            'include_published_at' => true,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            $this->addFlash("success", "Article Updated! Knowledge is power!");

            return $this->redirectToRoute("admin_article_list", [
                "id" => $article->getId(),
            ]);
        }

        return $this->render("article/edit.html.twig", [
            // articleForm is the name of the variable that we will use in the template
            // $form->createView() is a method that will create a view of the form
            "articleForm" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article", name="admin_article_list")
     */
    public function list(ArticleRepository $articleRepo): Response
    {
        $articles = $articleRepo->findAll();

        return $this->render("article/list.html.twig", [
            "articles" => $articles,
        ]);
    }
}
