<?php


namespace App\Controller\front;


use App\Entity\Candidat;
use App\Entity\LigneProposition;
use App\Entity\OffreEmplois;
use App\Entity\Responsable;
use App\Entity\Video;
use App\Repository\AboutRepository;
use App\Repository\AProposRepository;
use App\Repository\OffreEmploisRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profil/responsale", name="profil_client")
     */
    public function profil_responsable()
    {
        return $this->render('profile/responsable.html.twig');
    }

    /**
     * @Route("/profil/responsable/cvvideos", name="cvvideo")
     */

    public function video(VideoRepository $repository)
    {


        $res = $repository->searchVideoCVT();
        return $this->render('profile/cvvideo.html.twig',[
            'cv'=>$res
        ]);

    }

    /**
     * @Route("/profil/responsable/entretien", name="entretien")
     */
    public function entretien(VideoRepository $entretien)
    {
        $res= $entretien->searchVideoEntretientt();
        return $this->render('profile/entretien.html.twig',[
            'entretien'=> $res
        ]);
    }


    /**
     * @Route("/edit/resp/client/{id}", name="edit_profile_client")
     * @param Responsable $responsable
     */
    public function EditResponsable(Responsable $responsable)
    {

    }

    /**
     * @Route("/profil/candidat", name="profil_candidat")
     * @param AboutRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profil_candidat(AboutRepository $repository, VideoRepository $videoRepository)
    {
        $user=$this->getUser();
        $about=$repository->findOne($user);
        $video=$videoRepository->findOne($user);
        dump($video);
        return $this->render('profile/candidat.html.twig',[
            'about'=>$about==[]? null: $about[0],
            'video'=>$video==[]? null: $video,
        ]);
    }
    /**
     * @Route("/projet/encour/", name="en_cours")
     */
    public function projetEnCours(OffreEmploisRepository $repository)
    {
        $user=$this->getUser();
        $offres=$repository->findOffres($user);
        $nbrRec = count($offres);
        return $this->render('profile/encours.html.twig',[
            'offre'=>$offres,
            'nbr'=>$nbrRec
        ]);
    }

    /**
     * @Route("/projet/encour/detail/{id}", name="detail_cours")
     * @param OffreEmploisRepository $repository
     * @param OffreEmplois $offreEmplois
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projetEnCoursDetails(OffreEmploisRepository $repository, OffreEmplois $offreEmplois)
    {
        $user=$this->getUser();
        $offre=$repository->findAcces($user, $offreEmplois);
        $offres=$repository->findOffres($user);
        dump($offre[0]->getLignePropositions());
        return $this->render('profile/encoursDetails.html.twig',[
            'offre'=>$offres,
            'prop'=>$offre
        ]);
    }

    /**
     * @Route("/select/candidat/{id}", name="select")
     * @param LigneProposition $ligneProposition
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function selectCandidat(LigneProposition $ligneProposition, EntityManagerInterface $em)
    {
        $ligneProposition->setStatus(true);
        $em->persist($ligneProposition);
        $em->flush();
        $idOffre=$ligneProposition->getProposition()->getOffreEmplois()->getId();
        return $this->redirectToRoute('detail_cours',['id'=>$idOffre]);
    }

    /**
     * @Route("/deselect/candidat/{id}", name="deselect")
     * @param LigneProposition $ligneProposition
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deselectCandidat(LigneProposition $ligneProposition, EntityManagerInterface $em)
    {
        $ligneProposition->setStatus(false);
        $em->persist($ligneProposition);
        $em->flush();
        $idOffre=$ligneProposition->getProposition()->getOffreEmplois()->getId();
        return $this->redirectToRoute('detail_cours',['id'=>$idOffre]);
    }

    /**
     * @Route("/voir/candidat/{id}", name="voir_candidat")
     */
    public function voirCandiat(Candidat $candidat, AboutRepository $repository)
    {
        $apropos=$repository->findOne($candidat);

        return $this->render('profile/candiatPropose.html.twig',[
            'candidat'=>$candidat,
            'about'=>$apropos[0]->getContenu()
        ]);
    }
}