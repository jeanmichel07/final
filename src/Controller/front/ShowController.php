<?php


namespace App\Controller\front;

use App\Entity\Document;
use App\Entity\Temoignage;
use App\Entity\RessourceCostimg;
use App\Entity\OffreEmplois;
use App\Entity\Video;
use App\Repository\DocumentRepository;
use App\Repository\OffreEmploisRepository;
use App\Repository\TemoignageRepository;
use App\Entity\Ressource;
use App\Repository\RessourceRepository;
use App\Repository\RessourceCostimgRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("ressource/show/temoignage/{id}", name="show_temoignage")
     * @param Temoignage $temoignage
     * @param TemoignageRepository $repository
     * @return Response
     */
    public function showTemoignage(Temoignage $temoignage, TemoignageRepository $repository)
    {
        $tem = $repository->findTe();
        return $this->render('front/showTemoignage.html.twig',[
            'temoignage'=>$temoignage,
            'temoignages'=>$tem
        ]);
    }

     /**
     * @Route("ressource/show/vlog/{id}", name="show_vlog")
     * @param Ressource $vlog
     * @param RessourceRepository $repository
     * @return Response
     */
    public function showVlog(Ressource $vlog, RessourceRepository $repository)
    {
        $res = $repository->searchTypeVL();
         return $this->render('front/vlogs.html.twig',[
            'vlog'=>$vlog,
            'vlogs'=>$res
        ]);
    }
    /**
     * @Route("ressource/show/fact/{id}", name="show_fact")
     * @param Ressource $fact
     * @param RessourceRepository $repository
     * @return Response
     */
    public function showFact(Ressource $fact, RessourceRepository $repository)
    {
      
        $res = $repository->searchTypeFact();
         return $this->render('front/factf.html.twig',[
            'fact'=>$fact,
            'facts'=>$res
        ]);
    }

    /**
     * @Route("ressource/show/jour/{id}", name="show_jour")
     * @param Ressource $jour
     * @param RessourceRepository $repository
     * @return Response
     */
    public function showJour(Ressource $jour, RessourceRepository $repository)
    {
      
        $res = $repository->searchTypejour();
         return $this->render('front/journees.html.twig',[
            'jour'=>$jour,
            'jours'=>$res
        ]);
    }

    /**
     * @Route("ressource/show/success/{id}", name="show_success")
     * @param Ressource $success
     * @param RessourceRepository $repository
     * @return Response
     */
    public function showSuccess(Ressource $success, RessourceRepository $repository)
    {
      
        $res = $repository->searchTypeSS();
         return $this->render('front/storys.html.twig',[
            'success'=>$success,
            'succes'=>$res
        ]);
    }

    /**
     * @Route("ressource/show/daily/{id}", name="show_daily")
     * @param RessourceCostimg $daily
     * @param RessourceCostimgRepository $repository
     * @return Response
     */
    public function showDaily(RessourceCostimg $daily, RessourceCostimgRepository $repository)
    {
      
        $res = $repository->searchTypedaily();
         return $this->render('front/dailyq.html.twig',[
            'daily'=>$daily,
            'dailys'=>$res
        ]);
    }

    /**
     * @Route("ressource/show/protip/{id}", name="show_protip")
     * @param RessourceCostimg $protip
     * @param RessourceCostimgRepository $repository
     * @return Response
     */
    public function showProtip(RessourceCostimg $protip, RessourceCostimgRepository $repository)
    {
      
        $res = $repository->searchTypePro();
         return $this->render('front/protips.html.twig',[
            'protip'=>$protip,
            'protips'=>$res
        ]);
    }


     /**
     * @Route("offre/show/emploie/{id}", name="show_offre")
     * @param OffreEmplois $offre
     * @param OffreEmploisRepository $repository
     * @return Response
     */
    public function showOffre( OffreEmplois $offre, OffreEmploisRepository $repository)
    {

        $res = $repository->findOffre();
         return $this->render('front/detailsoffre.html.twig',[
            'offre'=>$offre,
            'offres'=>$res
        ]);
    }
    /**
     * @Route("ressource/show/cv/{id}", name="show_video")
     * @param Video $video
     * @param VideoRepository $repository
     * @return Response
     */
    public function showVideo( Video $video,VideoRepository $repository)
    {

        $res = $repository->searchVideoCVF();
        return $this->render('front/cvvideo.html.twig',[
            'cv'=>$video,
            'cvs'=>$res
        ]);
    }
    /**
     * @Route("/profil/responsable/show/cv/{id}", name="show")
     * @param Video $video
     * @param VideoRepository $repository
     * @return Response
     */
    public function show( Video $video,VideoRepository $repository)
    {

        $res = $repository->searchVideoCVT();
        return $this->render('profile/cvvideos.html.twig',[
            'cv'=>$video,
            'cvs'=>$res
        ]);
    }

    /**
     * @Route("ressource/show/entretient/{id}", name="show_entretient")
     * @param Video $video
     * @param VideoRepository $repository
     * @return Response
     */
    public function showEntretient( Video $video,VideoRepository $repository)
    {

        $res = $repository->searchVideoEntretientt();
        return $this->render('front/entretientvideo.html.twig',[
            'entretient'=>$video,
            'entretients'=>$res
        ]);
    }

    /**
     * @Route("ressource/show/ebook/{id}", name="show_ebook")
     * @param Document $document
     * @param DocumentRepository $repository
     * @return Response
     */
    public function showEbook(Document $document, DocumentRepository $repository)
    {
        $res= $repository->findbook();
        return $this->render('front/ebookid.html.twig',[
            'document'=>$document,
            'documents'=>$res
        ]);
    }
    /**
     * @Route("ressource/show/brochure/{id}", name="show_brochure")
     * @param Document $document
     * @param DocumentRepository $repository
     * @return Response
     */
    public function showBrochure(Document $document, DocumentRepository $repository)
    {
        $res= $repository->findbrochure();
        return $this->render('front/brochurei.html.twig',[
            'brochure'=>$document,
            'brochures'=>$res
        ]);
    }

    /**
     * @Route("/profil/responsable/show/entretient/{id}", name="show_tient")
     * @param Video $video
     * @param VideoRepository $repository
     * @return Response
     */
    public function showtient( Video $video,VideoRepository $repository)
    {

        $res = $repository->searchVideoEntretientt();
        return $this->render('profile/entretienvideo.html.twig',[
            'entretient'=>$video,
            'entretients'=>$res
        ]);
    }
}