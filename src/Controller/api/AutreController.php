<?php


namespace App\Controller\api;


use App\Entity\APropos;
use App\Entity\Document;
use App\Entity\OffreEmplois;
use App\Entity\Ressource;
use App\Entity\RessourceCostimg;
use App\Repository\AProposRepository;
use App\Repository\DocumentRepository;
use App\Repository\OffreEmploisRepository;

use App\Repository\RessourceCostimgRepository;
use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class AutreController
 * @package App\Controller\api
 * @Route("/api")
 */
class AutreController extends AbstractController
{
    private $offre;
    private $resource;
    private $resourceimage;
    private $apropos;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;


    /**
     * AutreController constructor.
     * @param OffreEmploisRepository $offre
     * @param RessourceRepository $resource
     */
    public function __construct(OffreEmploisRepository $offre, RessourceRepository $resource , RessourceCostimgRepository $resourceimage, AProposRepository $apropos,DocumentRepository $documentRepository)
    {
        $this->offre = $offre;
        $this->resource = $resource;
        $this->resourceimage = $resourceimage;
        $this->apropos = $apropos;
        $this->documentRepository = $documentRepository;
    }

    /**
     * @Rest\Get("/read/offre")
     */
    public function offre()
    {
        $offres = $this->offre->findOffre();

        if (empty($offres)) {
            return new JsonResponse(['message' => 'Il n\'y a aucun offre d\'emplies']);
        } else {
            $datas = [];

            foreach ($offres as $offre) {
                $datas[] = [
                    'id' => $offre->getId(),
                    'client' => $offre->getClient()->getNom(),
                    'poste' => $offre->getTitre(),
                    'dateLimite' => $offre->getDateLimite()->format('d-m-Y'),
                    'contrat' => $offre->getContrat(),
                    'activite' => $offre->getActivite(),
                    'mission' => $offre->getMission(),
                    'profile' => $offre->getProfil(),
                    'reference' => $offre->getReference(),
                ];
            }
            return new JsonResponse($datas, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/read/of/{id}")
     */
    public function offreOne(OffreEmplois $emplois)
    {
        $offre = $this->offre->findOffreOne($emplois->getId());

        if (empty($offre)) {
            return new JsonResponse(['message' => 'Il n\'y a aucun offre d\'emplies']);
        } else {
            $datas = [];

            foreach ($offre as $of) {
                $datas = [
                    'id' => $of->getId(),
                    'client' => $of->getClient()->getNom(),
                    'poste' => $of->getTitre(),
                    'dateLimite' => $of->getDateLimite()->format('d-m-Y'),
                    'contrat' => $of->getContrat(),
                    'activite' => $of->getActivite(),
                    'mission' => $of->getMission(),
                    'profile' => $of->getProfil(),
                    'reference' => $of->getReference(),
                ];
            }
            return new JsonResponse($datas, Response::HTTP_OK);
        }
    }
    /*************** Type **************/
    #API
    /**
     * @return JsonResponse
     * @Rest\Route("/ressource/success")
     */
    public function TypeSS(){
        $res = $this->resource->searchTypeSS();

        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'description' => $res->getDescription(),
                    'video' => $res->getVideo(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }
    /**
     * @Rest\Get("/ressource/success/un/{id}")
     *
     * @return JsonResponse
     */
    public function TypeSSOne(Ressource $ressource)
    {
        $res=$this->resource->find($ressource->getId());
        $formatted=[
            'id' => $res->getId(),
            'type' => $res->getType(),
            'titre' => $res->getTitre(),
            'description' => $res->getDescription(),
            'video' => $res->getVideo(),
        ];
        return new JsonResponse($formatted,Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     * @Rest\Route("/ressource/VL")
     */
    public function TypeVL(){
        $res = $this->resource->searchTypeVL();

        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'description' => $res->getDescription(),
                    'video' => $res->getVideo(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }

    /**
     * @return JsonResponse
     * @Rest\Route("/ressource/Fact")
     */
    public function TypeFact(){
        $res = $this->resource->searchTypeFact();

        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'description' => $res->getDescription(),
                    'video' => $res->getVideo(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }


    /**
     * @return JsonResponse
     * @Rest\Route("/ressource/jour")
     */
    public function Typejour(){
        $res = $this->resource->searchTypejour();

        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'description' => $res->getDescription(),
                    'video' => $res->getVideo(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }
    /**
     * @return JsonResponse
     * @Rest\Route("/ressourceimage/daily")
     */
    public function Typedaily(){
        $res = $this->resourceimage->searchTypedaily();
        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'image' => $res->getImage(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }
    /**
     * @return JsonResponse
     * @Rest\Route("/ressourceimage/Pro")
     */
    public function TypePro(){
        $res = $this->resourceimage->searchTypePro();
        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'image' => $res->getImage(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }
    /**
     * @Rest\Get("/ressourceimage/un/{id}")
     *
     * @return JsonResponse
     */
    public function TypeimageOne(RessourceCostimg $ressourceimage)
    {
        $res=$this->resourceimage->find($ressourceimage->getId());
        $formatted=[
            'id' => $res->getId(),
            'type' => $res->getType(),
            'titre' => $res->getTitre(),
            'image' => $res->getImage(),
        ];
        return new JsonResponse($formatted,Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     * @Rest\Route("/apropos/mission")
     */
    public function Typemission(){
        $res = $this->apropos->searchTypemission();
        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'video' => $res->getVideo(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }

    /**
     * @return JsonResponse
     * @Rest\Route("/apropos/Book")
     */
    public function TypeBook(){
        $res = $this->apropos->searchTypeBook();
        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'video' => $res->getVideo(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }
    /**
     * @return JsonResponse
     * @Rest\Route("/apropos/Compilation")
     */
    public function TypeCompilation(){
        $res = $this->apropos->searchTypeCompilation();
        if (empty($res)){
            return new JsonResponse(['message' => 'Id non spécifié', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted = [];
            foreach ($res as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'video' => $res->getVideo(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }
    /**
     * @Rest\Get("/apropos/un/{id}")
     *
     * @return JsonResponse
     */
    public function TypeaproposOne(APropos $propos)
    {
        $res=$this->apropos->find($propos->getId());
        $formatted=[
            'id' => $res->getId(),
            'type' => $res->getType(),
            'video' => $res->getVideo(),
        ];
        return new JsonResponse($formatted,Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     * @Rest\Get("/read/blog")
     */
    public function documentBlog(){
        $blog = $this->documentRepository->findBlog();
        if (empty($blog)){
            return new JsonResponse(['message' => 'Aucun blog', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted =[];
            foreach ($blog as $res){
                $formatted[] = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'description' => $res->getDesciption(),
                    'blog' => $res->getFile(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/read/document/{id}")
     */
    public function oneDocument(Document $document){
        $doc=$this->documentRepository->findOneDoc($document->getId());
        if (empty($doc)){
            return new JsonResponse(['message' => 'Aucun document', 'status' => 'KO'], Response::HTTP_OK);
        } else {
            $formatted =[];
            foreach ($doc as $res){
                $formatted = [
                    'id' => $res->getId(),
                    'type' => $res->getType(),
                    'titre' => $res->getTitre(),
                    'description' => $res->getDesciption(),
                    'blog' => $res->getFile(),

                ];
            }
            return new JsonResponse($formatted, Response::HTTP_OK);
        }

    }

}