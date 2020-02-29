<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\OffreEmplois;
use App\Entity\Video;
use App\Form\VideoCandidatType;
use App\Repository\CandidatRepository;
use App\Repository\CandidatureRepository;
use App\Repository\VideoRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController
 * @package App\Controller
 * @Route("/admin")
 */
class CandidatController extends AbstractController
{

    /**
     * @var CandidatRepository
     */
    private $candidat;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var CandidatureRepository
     */
    private $candidature;

    public function __construct(CandidatRepository $candidat, EntityManagerInterface $em,CandidatureRepository $candidature)
    {
        $this->candidat = $candidat;
        $this->em = $em;
        $this->candidature = $candidature;
    }
    /**
     * @return ResponseAlias
     * @Route("/liste/candidat", name="liste_candidat")
     */
    public function read()
    {
        $candidat=$this->candidat->findCandidat();
        $can=$this->candidat->findOneCand('1');
        $cadid=new Candidat();

        return $this->render('admin/candidat/list.html.twig',[
            'candidat'=>$candidat,
            'current_menu' => 'candidat'
        ]);
    }

    /**
     * @param Candidat $candidat
     * @Route("/show/candidat/{id}", name="show_candidat")
     * @return ResponseAlias
     */
    public function show(Candidat $candidat)
    {
        return $this->render('admin/candidat/show.html.twig',[
            'candidat'=>$candidat,
            'current_menu' => 'candidat'
        ]);
    }

    /**
     * @Route("/delete/candidat/{id}", name="delete_candidat")
     * @param Candidat $candidat
     * @param Request $request
     * @return Response|ResponseAlias
     */
    public function delete(Candidat $candidat, Request $request){
        if ($this->isCsrfTokenValid('delete' . $candidat->getId(), $request->get('_token'))){
            $this->em->remove($candidat);
            $this->em->flush();
        }
        return $this->redirectToRoute('liste_candidat');
    }

    /**
     * @Route("/list/temoignage/candidat/{id}", name="list_video_candidat")
     * @param Candidat $candidat
     * @param VideoRepository $video
     * @return Response
     */
    public function temoignage(Candidat $candidat, VideoRepository $video){
        $videos = $video->findTem($candidat);
        return $this->render('admin/candidat/listTemoignage.html.twig', [
            'candidat' => $candidat,
            'current_menu' => 'candidat',
            'temoignage' => $videos
        ]);
    }

    /**
     * @param Candidat $candidat
     * @param Request $request
     * @return Response
     * @Route("/temoignage/{id}", name="add_temoignage_candidat")
     */
    public function addTemoignage(Candidat $candidat, Request $request){
        $temoignageCandidat = new Video();
        $form = $this->createForm(VideoCandidatType::class, $temoignageCandidat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
//            $file = $form->get('video')->getData();
//            $fileName = md5(uniqid()) . '.' .$file->guessExtension();
//            $file->move($this->getParameter('upload_directory'), $fileName);
//            $temoignageCandidat->setVideo($fileName);

            $temoignageCandidat->setCandidat($candidat);
            $this->em->persist($temoignageCandidat);
            $this->em->flush();
            return $this->redirectToRoute('list_video_candidat', ['id' => $candidat->getId()]);
        }

        return $this->render('admin/candidat/addTemoignage.html.twig', [
            'candidat' => $candidat,
            'current_menu' => 'candidat',
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Video $temoignageCandidat
     * @Route("/see/temoignage_candidat/{id}", name="see_video_candidat")
     * @return Response
     */
    public function seeVideo(Video $temoignageCandidat){
        return $this->render('admin/candidat/seeVideo.html.twig', [
            'temoin' => $temoignageCandidat,
            'current_menu' => 'candidat',
        ]);
    }

    /**
     * @param Video $videoCandidat
     * @param Request $request
     * @param Candidat $candidat
     * @return Response
     * @Route("/see/video/delete/{id}", name="delete_video")
     */
    public function deleteVideo(Video $videoCandidat, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$videoCandidat->getId(), $request->get('_token'))){
            $this->em->remove($videoCandidat);
            $this->em->flush();
        }

        return $this->redirectToRoute('list_video_candidat', [
            'id' => $videoCandidat->getCandidat()->getId()
        ]);
    }

    /**
     * @param OffreEmplois $offreEmplois
     * @return Response
     * @Route("/liste/candidature/offre/{id}",name="liste_candidature")
     */
    public function listCandidature(OffreEmplois $offreEmplois)
    {
        $candidature=$this->candidature->findCandidature($offreEmplois->getId());

        return $this->render('admin/candidat/candidature.html.twig',[
            'candidature'=>$candidature,
            'current_menu' => 'offre',
            'offre'=>$offreEmplois
        ]);
    }


}
