<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Cassandra\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonce")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonce_index", methods={"GET"})
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
            'annonces_user' => $this->getUser()->getAnnoncesCreees(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/new", name="annonce_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        $annonce->setIdCreateur($this->getUser());
        $annonce->setDateCreation(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonce_show", methods={"GET"})
     */
    public function show(Annonce $annonce, $id): Response
    {
        $max = $annonce->getNbMaxParticipants();
        $partActu = sizeof($annonce->getParticipants());
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'max' => $max,
            'partActu' => $partActu
        ]);
    }

    /**
     * @Route("/detail/{id}", name="annonce_showPerso", methods={"GET"})
     */
    public function showPerso(Annonce $annonce): Response
    {
        $max = $annonce->getNbMaxParticipants();
        $partActu = sizeof($annonce->getParticipants());
        return $this->render('annonce/showPerso.html.twig', [
            'annonce' => $annonce,
            'max' => $max,
            'partActu' => $partActu
        ]);
    }

    /**
     * @Route("/add/{id}", name="add_participant", methods={"GET","POST"})
     */
    public function addParticipant(Annonce $annonce): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $lannonce = $entityManager->getRepository(Annonce::class)->find($annonce->getId());
        $lannonce->addParticipant($this->getUser());
        $entityManager->flush();

        $participants = $lannonce->getParticipants();
        return $this->redirectToRoute('annonce_showPerso',['id' => $annonce->getId()]);

    }

    /**
     * @Route("/{id}/edit", name="annonce_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonce_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_index');
    }
}
