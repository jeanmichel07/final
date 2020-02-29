<?php

namespace App\Controller;

use App\Entity\Coopteur;
use App\Entity\OffreEmplois;
use App\Repository\CooptationRepository;
use App\Repository\CoopteurRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CoopteurController extends AbstractController
{

    /**
     * @var CoopteurRepository
     */
    private $coopteur;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var CooptationRepository
     */
    private $cooptation;

    public function __construct(CoopteurRepository $coopteur, EntityManagerInterface $em,CooptationRepository $cooptation)
    {

        $this->coopteur = $coopteur;
        $this->cooptation = $cooptation;
        $this->em = $em;
    }

    /**
     * @return ResponseAlias
     * @Route("/liste/coopteur", name="liste_coopteur")
     */
    public function read()
    {
        $coopteur=$this->coopteur->findCoopteur();
        return $this->render('admin/coopteur/list.html.twig',[
            'coopteur'=>$coopteur,
            'current_menu' => 'coopteur'
        ]);
    }

    /**
     * @param Coopteur $coopteur
     * @Route("/show/coopteur/{id}", name="show_coopteur")
     * @return ResponseAlias
     */
    public function show(Coopteur $coopteur)
    {
        return $this->render('admin/coopteur/show.html.twig',[
            'coopteur'=>$coopteur,
            'current_menu' => 'coopteur'
        ]);
    }

    /**
     * @param OffreEmplois $offreEmplois
     * @return Response
     * @Route("/liste/cooptation/offre/{id}",name="liste_cooptation")
     */
    public function listeCooptation(OffreEmplois $offreEmplois)
    {
        $cooptation=$this->cooptation->findCooptation($offreEmplois->getId());

        return $this->render('admin/coopteur/cooptation.html.twig',[
            'cooptation'=>$cooptation,
            'current_menu' => 'offre',
            'offre'=>$offreEmplois
        ]);
    }
}
