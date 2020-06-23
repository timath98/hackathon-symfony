<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;

class UtilisateurType extends AbstractType
{
    private $router;

    public function __construct(RouterInterface $router) {
        $this->router=$router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, ['label'=>"Nom d'utilisateur"])
            ->add('nom')
            ->add('prenom',TextType::class,['label'=>"Prénom"])
            ->add('plainPassword',PasswordType::class, ['label'=>"Mot de passe"])
            ->add('image')
            ->add('adresse')
            // on saisit le code postal et les villes se sélectionnent toutes seules.
            ->add('cp', TextType::class, [
                // false pour dire que ce n'est pas associé à l'entité
                'mapped' => false,
                'constraints' => new Length(['min' => 5,'max'=>5, 'exactMessage'=>'Un code postal doit contenir 5 chiffres']),
                'label'=>"Code postal",
                'attr' => [
                    'placeholder' => 'Code Postal',
                ]
            ])
            // mapped à false car ville contient 35000 entrées...
            ->add('ville', TextType::class, [
                'mapped'=>false,
                'label_attr' => array('id' => 'label_ville'),
                'attr' => [
                    'list'=>'ville-data',
                    'autocomplete'=>'off'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'attr'=> [
                // permet de récupérer facilement la route du contrôleur pour le js
                'data-autocomplete-url'=>$this->router->generate('get_ville',['codePostal'=>"00"])
            ]
        ]);
    }
}
