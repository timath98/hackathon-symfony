<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Ville;
use App\Form\SelectAnnonceType;
use App\Form\UtilisateurType;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\DepartementRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user=new Utilisateur();
        $form=$this->createForm(UtilisateurType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user,$user->getPlainPassword()));
            $ville=$this->getDoctrine()->getRepository(Ville::class)->findOneBy(['nom'=>$form->get('ville')->getData(),'zipCode'=>$form->get('cp')->getData()]);
            $user->setVille($ville);
            $user->setActif(true);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('default/register.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function index(DepartementRepository $departementRepository, CategorieRepository $categorieRepository, Request $request)
    {
        $categories=$categorieRepository->findAll();
        $req="";
        $formDept=$this->createForm(SelectAnnonceType::class);
        $allannonces=$this->getDoctrine()->getManager()->getRepository(Annonce::class)->findAll();

        $formDept->handleRequest($request);
        if($formDept->isSubmitted() && $formDept->isValid()) {
            $data = $formDept->getData();
            $dep = $data['departement'];
            $cat = $data['categorie'];
            $catlist=$this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
            $req=$this->getDoctrine()->getManager()->getRepository(Annonce::class)->findByDepCat($dep, $cat);
            $taille = sizeof($req);
            return $this->render('default/annonces.html.twig', [
                'formDept' => $formDept->createView(),
                'categories' => $categories,
                'annonces' => $req,
                'taille' => $taille,
                'catlist' => $catlist,
                'categ' => $cat,
                ]);
        }

        return $this->render('default/index.html.twig', [
            'formDept' => $formDept->createView(),
            'categories' => $categories,
            'annonces' => $req,
            'allannonce' => $allannonces,
        ]);
    }


}
