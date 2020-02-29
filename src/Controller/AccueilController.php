<?php

namespace App\Controller;

use App\Entity\Accueil;
use App\Form\AccueilType;
use App\Repository\AccueilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/accueil")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil_index", methods={"GET"})
     * @param AccueilRepository $accueilRepository
     * @return Response
     */
    public function index(AccueilRepository $accueilRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'accueils' => $accueilRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="accueil_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $accueil = new Accueil();
        $form = $this->createForm(AccueilType::class, $accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $filePhoto =  $form->get('image')->getData();
            $filenamePhoto=md5(uniqid()).'.'.$filePhoto->guessExtension();
            $filePhoto->move($this->getParameter('upload_accueil'), $filenamePhoto);
            $accueil->setImage($filenamePhoto);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($accueil);
            $entityManager->flush();

            return $this->redirectToRoute('accueil_index');
        }

        return $this->render('accueil/new.html.twig', [
            'accueil' => $accueil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="accueil_show", methods={"GET"})
     * @param Accueil $accueil
     * @return Response
     */
    public function show(Accueil $accueil): Response
    {
        return $this->render('accueil/show.html.twig', [
            'accueil' => $accueil,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="accueil_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Accueil $accueil
     * @return Response
     */
    public function edit(Request $request, Accueil $accueil): Response
    {
        $form = $this->createForm(AccueilType::class, $accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $filePhoto =  $form->get('image')->getData();
        $filenamePhoto=md5(uniqid()).'.'.$filePhoto->guessExtension();
        $filePhoto->move($this->getParameter('upload_accueil'), $filenamePhoto);
        $accueil->setImage($filenamePhoto);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('accueil_index');
        }

        return $this->render('accueil/edit.html.twig', [
            'accueil' => $accueil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="accueil_delete", methods={"DELETE"})
     * @param Request $request
     * @param Accueil $accueil
     * @return Response
     */
    public function delete(Request $request, Accueil $accueil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accueil->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($accueil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accueil_index');
    }
}
