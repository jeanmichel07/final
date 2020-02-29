<?php

namespace App\Controller\api;

use App\Entity\Candidat;
use App\Entity\Candidature;
use App\Entity\OffreEmplois;
use App\Entity\Video;
use App\Repository\CandidatRepository;
use App\Repository\OffreEmploisRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class CandidatController
 * @package App\Controller\api
 * @Route("/api")
 */
class CandidatController extends AbstractController
{
    /**
     * @var VideoRepository
     */
    private $videoRepository;
    /**
     * @var OffreEmploisRepository
     */
    private $offre;


    /**
     * @Rest\Post("/create/candidat")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function inscriptionCandidat(Request $request)
    {
        $candidat=new Candidat();
        if (!empty($request->files->get('photo')) && !empty($request->get('nom')) && !empty($request->get('dateNaissance')) && !empty($request->get('situation')) && !empty($request->get('adresse')) && !empty(($request->get('ville')) && !empty($request->get('pays')) && !empty($request->get('telephone')) && !empty($request->get('sex')) && !empty($request->get('pseudo')) && !empty($request->get('password'))))
        {
            $filePhoto = $request->files->get('photo');
            $filenamePhoto=md5(uniqid()).'.'.$filePhoto->guessExtension();
            $filePhoto->move($this->getParameter('upload_directory'), $filenamePhoto);
            $candidat->setPhoto($filenamePhoto);

            $candidat->setNom($request->get('nom'));
            $candidat->setDateNaissance(new \DateTime($request->get('dateNaissance')));
            $candidat->setSituationFamilier($request->get('situation'));
            $candidat->setAdresse($request->get('adresse'));
            $candidat->setVille($request->get('ville'));
            $candidat->setPays($request->get('pays'));
            $candidat->setEmail($request->get('email'));
            $candidat->setTelephone($request->get('telephone'));
            $candidat->setSex($request->get('sex'));
            $candidat->setPseudo($request->get('pseudo'));
            $candidat->setPassword(sha1($request->get('password')));
            $em=$this->getDoctrine()->getManager();
            $em->persist($candidat);
            $em->flush();
            return new JsonResponse(['message' => 'Inscription réussit'], Response::HTTP_OK);

        }else{
            return new JsonResponse(['message' => 'Veuillez remplir tous les champs','test'=>$request->get('name')], Response::HTTP_OK);
        }
    }

        /**
         * @var CandidatRepository
         */
        private $candidat;

        public function __construct(CandidatRepository $candidat, VideoRepository $videoRepository, OffreEmploisRepository $offre)
    {
        $this->candidat = $candidat;
        $this->videoRepository = $videoRepository;
        $this->offre = $offre;
    }

        /**
         * @param Request $request
         * @return JsonResponse
         * @Rest\Post("/login/candidat")
         */
        public function login(Request $request)
        {
            $candidat = $this->candidat->authentification($request->get('pseudo'), $request->get('password'));

            if (empty($candidat)) {
                return new JsonResponse(['message' => 'Le login et/ou le mot de passe est incorrect', 'status' => 'KO'], Response::HTTP_OK);
            } else {
                $formatted = [];

                foreach ($candidat as $candidat) {
                    $formatted = [
                        'id' => $candidat->getId(),
                        'nom' => $candidat->getNom(),
                        'adresse' => $candidat->getAdresse(),
                        'telephone' => $candidat->getTelephone(),
                        'email' => $candidat->getEmail(),
                        'user' => $candidat->getPseudo(),
                    ];
                }
                return new JsonResponse($formatted, Response::HTTP_OK);
            }
        }

    /**
     * @Rest\Post("/create/cvCandidat/{id}")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function ajoutCVCandidat(Candidat $candidat,Request $request)
    {
        if (!empty($request->files->get('cv')) && !empty($request->get('formation')) && !empty(($request->get('experience')) && !empty($request->get('competence')) && !empty($request->get('langue')) && !empty($request->get('loisir'))))
        {
                $fileCV = $request->files->get('cv');
                $filenameCV=md5(uniqid()).'.'.$fileCV->guessExtension();
                $fileCV->move($this->getParameter('upload_directory'), $filenameCV);
                $candidat->setCv($filenameCV);
                $candidat->setFormation($request->get('formation'));
            $candidat->setExperience($request->get('experience'));
            $candidat->setCompetence($request->get('competence'));
            $candidat->setLangue($request->get('langue'));
            $candidat->setLoisir($request->get('loisir'));

                $em=$this->getDoctrine()->getManager();
                $em->persist($candidat);
                $em->flush();
                return new JsonResponse(['message' => 'Information sauvegardé'], Response::HTTP_OK);

        }else{
            return new JsonResponse(['message' => 'Veuillez remplir tous les champs','test'=>$request->get('name')], Response::HTTP_OK);
        }
    }

    /*************** VIDEO **************/
    #API videoCV
    /**
     * @return JsonResponse
     * @Rest\Route("/video/CV")
     */
    public function videoCV(){
        $video = $this->videoRepository->searchVideoCV();

        if (empty($video)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($video as $video){
                $formatted[] = [
                    'id' => $video->getId(),
                    'type' => $video->getType(),
                    'description' => $video->getDescription(),
                    'video' => $video->getVideo(),
                    'candidat' => $video->getCandidat()->getNom()
                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/video/CV/un/{id}")
     * @param Video $video
     * @return JsonResponse
     */
    public function videoCVOne(Video $video)
    {
        $vid=$this->videoRepository->find($video->getId());
        $formatted=[
            'id' => $vid->getId(),
            'titre' => $vid->getType(),
            'video' => $vid->getVideo(),
            'description' => $vid->getDescription(),
            'candidat'=> $vid->getCandidat()->getNom(),
            'idCandidat'=> $vid->getCandidat()->getId()
        ];
        return new JsonResponse($formatted,Response::HTTP_OK);
    }

    #API videoEntretient
    /**
     * @return JsonResponse
     * @Rest\Route("/video/Entretient")
     */
    public function videoEntretient(){
        $video = $this->videoRepository->searchVideoEntretient();

        if (empty($video)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($video as $video){
                $formatted[] = [
                    'id' => $video->getId(),
                    'type' => $video->getType(),
                    'description' => $video->getDescription(),
                    'video' => $video->getVideo(),
                    'candidat' => $video->getCandidat()->getNom()
                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/video/Entretient/un/{id}")
     * @return JsonResponse
     */
    public function videoEntretientOne(Video $video)
    {
        $tem=$this->videoRepository->find($video->getId());
        $formatted=[
            'id' => $tem->getId(),
            'titre' => $tem->getType(),
            'video' => $tem->getVideo(),
            'description' => $tem->getDescription(),
            'candidat'=> $tem->getCandidat()->getNom(),
            'idCandidat'=> $tem->getCandidat()->getId()
        ];
        return new JsonResponse($formatted,Response::HTTP_OK);
    }


    #API videoCVCandidat
    /**
     * @param Request $request
     * @return JsonResponse
     * @Rest\Route("/video/candidat/CV")
     */
    public function videoCVCandidat(Request $request){
        $video = $this->videoRepository->searchVideoCVCandidat($request->get('candidat'));

        if (empty($video)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($video as $video){
                $formatted[] = [
                    'id' => $video->getId(),
                    'type' => $video->getType(),
                    'description' => $video->getDescription(),
                    'video' => $video->getVideo(),
                    'candidat' => $video->getCandidat()->getNom()
                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }

    #API videoEntretientCandidat
    /**
     * @param Request $request
     * @return JsonResponse
     * @Rest\Route("/video/candidat/Entretient")
     */
    public function videoEntretientCandidat(Request $request){
        $videos = $this->videoRepository->searchVideoEntretientCandidat($request->get('candidat'));

        if (empty($videos)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($videos as $video){
                $formatted[] = [
                    'id' => $video->getId(),
                    'type' => $video->getType(),
                    'description' => $video->getDescription(),
                    'video' => $video->getVideo(),
                    'candidat' => $video->getCandidat()->getNom()
                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/candidature/candidat/{id}")
     * @param Candidat $candidats
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function Candidature(Candidat $candidats,Request $request)
    {
        $id=$request->get('ids');
        $offres=$this->offre->findOnOffre(''.$id);
        if(!empty($request->files->get('cv')) && !empty($request->files->get('lm'))){
            $candidature=new Candidature();
            $candidature->setCandidat($candidats);
            $candidature->setOffreEmplois($offres[0]);
            $candidature->setDate(new \DateTime());

                    $fileCV = $request->files->get('cv');
                    $filenameCV=md5(uniqid()).'.'.$fileCV->guessExtension();
                    $fileCV->move($this->getParameter('upload_directory'), $filenameCV);
                    $candidature->setCv($filenameCV);

                    $fileLm = $request->files->get('lm');
                    $filenameLm=md5(uniqid()).'.'.$fileLm->guessExtension();
                    $fileLm->move($this->getParameter('upload_directory'), $filenameLm);
                    $candidature->setLm($filenameLm);

                    $fileDs = $request->files->get('ds');
                    $filenameDs=md5(uniqid()).'.'.$fileDs->guessExtension();
                    $fileDs->move($this->getParameter('upload_directory'), $filenameDs);
                    $candidature->setDs($filenameDs);

            $em=$this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();
            return new JsonResponse(['message' => 'Information sauvegardé'], Response::HTTP_OK);
        }else{
            return new JsonResponse(['message' => 'Remplir tous les champs'], Response::HTTP_OK);
        }
    }

    /**
     * @param Candidat $candidat
     * @Rest\Get("/candidat/{id}")
     * @return JsonResponse
     */
    public function candit(Candidat $candidat)
    {
        $cand=$this->candidat->findOneCand($candidat->getId());
        $formatted = [];

        foreach ($cand as $candidats) {
            $formatted= [
                'id' => $candidats->getId(),
                'photo' => $candidats->getPhoto(),
                'nom' => $candidats->getNom(),
                'dateNaissance' => $candidats->getDateNaissance()->format('d-m-Y'),
                'situationFamilier' => $candidats->getSituationFamilier(),
                'adresse' => $candidats->getAdresse(),
                'telephone' => $candidats->getTelephone(),
                'email' => $candidats->getEmail(),
                'user' => $candidats->getPseudo(),
            ];
        }
        return new JsonResponse($formatted, Response::HTTP_OK);
    }
}