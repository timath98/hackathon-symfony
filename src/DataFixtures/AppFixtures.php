<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Utilisateur;
use App\Entity\Categorie;
use App\Repository\VilleRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\DepartementRepository;
use App\Repository\CategorieRepository;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $villeRepository;

    /**
     * AppFixtures constructor.
     */
    public function __construct(UserPasswordEncoderInterface $encoder, VilleRepository $villeRepository, UtilisateurRepository $utilisateurRepository, DepartementRepository $departementRepository, CategorieRepository $categorieRepository)
    {
        $this->encoder=$encoder;
        $this->villeRepository=$villeRepository;
        $this->utilisateurRepository=$utilisateurRepository;
        $this->departementRepository=$departementRepository;
        $this->categorieRepository=$categorieRepository;

    }

    // faire un --append pour le d:f:l pour que les villes existent...
    public function load(ObjectManager $manager)
    {
        // supprime les accents des prénoms pour la construction du username...
        $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
            'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y');
        // $product = new Product();
        // $manager->persist($product);
        /*$faker = Faker\Factory::create('fr_FR');
        for($i=0;$i<40;$i++):
             $user=new Utilisateur();
             $user->setNom($faker->lastName);
             $user->setPrenom($faker->firstName);
             $user->setImage("/public/assets/img/icon.png");
             $user->setAdresse($faker->streetAddress);
             // on répupère les villes du 17 par défaut
             $villes=$this->villeRepository->getCitiesDept();
             // on en prend une au hasard
             $user->setVille($villes[mt_rand(0,count($villes)-1)]);
             $prenom = strtr( $user->getPrenom(), $unwanted_array );
             $username=strtolower(
                 substr($prenom,0,1)
                 .substr($user->getNom(),0,7)
             );
             $user->setUsername($username);
             $user->setActif($faker->randomElement([true,false]));
             $user->setPlainPassword($faker->password);
             $encodedPassword=$this->encoder->encodePassword($user,$user->getPlainPassword());
             $user->setPassword($encodedPassword);
             $manager->persist($user);
         endfor;*/


        $cat1=new Categorie();
        $cat1->setNom("Asiatique");
        $cat1->setImage("/img/asiatique.png");
        $manager->persist($cat1);

        $cat2=new Categorie();
        $cat2->setNom("Italien");
        $cat2->setImage("/img/italien.png");
        $manager->persist($cat2);

        $cat3=new Categorie();
        $cat3->setNom("Indien");
        $cat3->setImage("/img/indien.png");
        $manager->persist($cat3);

        $cat4=new Categorie();
        $cat4->setNom("Francais");
        $cat4->setImage("/img/francais.png");
        $manager->persist($cat4);

        /*$mat=new Utilisateur();
        $mat->setNom("blindron");
        $mat->setPrenom("mathieu");
        $mat->setImage("/public/assets/img/icon.png");
        $mat->setAdresse("27 rues de salles");
        // on répupère les villes du 17 par défaut
        $villess=$this->villeRepository->getCitiesDept();
        // on en prend une au hasard
        $mat->setVille($villess[mt_rand(0,count($villess)-1)]);
        $mat->setUsername("mathieu");
        $mat->setActif($faker->randomElement([true,false]));
        $mat->setPlainPassword("toto");
        $encodedPasswords=$this->encoder->encodePassword($mat,$mat->getPlainPassword());
        $mat->setPassword($encodedPasswords);
        $mat->setRoles(['ROLE_ADMIN']);
        $manager->persist($mat);*/

        $annonce1=new Annonce();
        $annonce1->setIdCreateur($this->utilisateurRepository->find(44));
        $annonce1->setIdDepartement($this->departementRepository->find(5));
        $annonce1->setIdCategorie($this->categorieRepository->find(5));
        $annonce1->setIntitule("Poulet");
        $annonce1->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum");
        $annonce1->setDateCreation(new \DateTime('06/04/2020'));
        $annonce1->setDate(new \DateTime('10/04/2020'));
        $annonce1->setNbMaxParticipants(3);
        $manager->persist($annonce1);

        $tabIntitule = ['Poulet', 'Poulet Braisé', 'Poulet Mafé', 'Poulet Coco', 'Tagliatelles Carbonnara', 'Pates Bolognaises', 'Nems au Poulet', 'Nems aux Crevettes', 'Nouilles - Ramen', 'PastaBox', 'Agneau rissolé et endives rouges', 'Corolles de céleri et langoustines sautées à cru', 'Emincé de veau au Marsala', 'Espadon au fenouil et pommes', 'Fèves et artichauts à la crétoise ', 'Filet de dinde aux trois poivrons', 'Frites à la vanille', 'Frites au curry', 'Frites au mélange Colombo', 'Frites au paprika', 'Frites aux amandes', 'Frites cacahuètes-bacon', 'Frites des îles à la noix de coco', 'Frites Tex-Mex', 'Gambas provençales', 'Jardinière de jeunes légumes', 'Lapin au citron et au thym', 'Les vraies frites', 'Petite friture de poissons à la sauce tartare', 'Pommes grenailles, ail en chemise, tomates et crevettes', 'Pommes - pommes noisettes et pop corn', 'Pommes sarladaises', 'Potatoes aux aromates', 'Sauces et Dips', 'Sauté de porc au chou vert', 'Seiches à la romaine', 'Soupe de pêches, menthe fraîche et grenadine', 'Tempura de poulet et de poivrons'];
            for ($i = 0; $i < 37; $i++) {
                $lannonce = new Annonce();
                $lannonce->setIdCreateur($this->utilisateurRepository->find(mt_rand(44, 80)));
                $lannonce->setIdDepartement($this->departementRepository->find(mt_rand(1, 2)));
                $lannonce->setIdCategorie($this->categorieRepository->find(mt_rand(1, 4)));
                $lannonce->setIntitule($tabIntitule[$i]);
                $lannonce->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum");
                $lannonce->setDateCreation(new \DateTime('06/04/2020'));
                $lannonce->setDate(new \DateTime('10/04/2020'));
                $lannonce->setNbMaxParticipants(3);
                $manager->persist($lannonce);
            }

            $manager->flush();
        }
}
