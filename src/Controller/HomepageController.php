<?php

namespace App\Controller;

use App\Entity\Homepage;
use App\Form\HomepageType;
use App\Repository\HomepageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomepageController extends AbstractController
{
    /**
     * @Route("/admin/homepage", name="homepage_index", methods={"GET"})
     */
    public function index(HomepageRepository $homepageRepository): Response
    {
        return $this->render('homepage/index.html.twig', [
            'homepages' => $homepageRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/homepage/new", name="homepage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $homepage = new Homepage();
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($homepage);
            $entityManager->flush();

            return $this->redirectToRoute('homepage_index');
        }

        return $this->render('homepage/new.html.twig', [
            'homepage' => $homepage,
            'form' => $form->createView(),
        ]);
    }


    public function show(HomepageRepository $homepageRepository): Response
    {
        return $this->render('homepage/show.html.twig', [
            'homepage' => $homepageRepository->findAll()[0],
        ]);
    }


    /**
     * @Route("admin/homepage/{id}/edit", name="homepage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Homepage $homepage): Response
    {
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage_index');
        }

        return $this->render('homepage/edit.html.twig', [
            'homepage' => $homepage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/homepage/{id}", name="homepage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Homepage $homepage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homepage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($homepage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage_index');
    }
}
