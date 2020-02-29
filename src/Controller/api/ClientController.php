<?php


namespace App\Controller\api;


use App\Entity\Client;
use App\Entity\Temoignage;
use App\Repository\ClientRepository;
use App\Repository\ResponsableRepository;
use App\Repository\TemoignageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\Collection;

/**
 * Class ClientController
 * @package App\Controller\api
 * @Route("/api")
 */
class ClientController extends AbstractController
{
    /**
     * @var ClientRepository
     */
    private $client;
    private $temoignage;

    /**
     * @var ResponsableRepository
     */
    private $responsableRepository;

    public function __construct(ClientRepository $client, TemoignageRepository $temoignage, ResponsableRepository $responsableRepository)
    {
        $this->client = $client;
        $this->temoignage= $temoignage;
        $this->responsableRepository = $responsableRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Rest\Post("/login/responsable")
     */
    public function login(Request $request)
    {
        $responsable=$this->responsableRepository->authentification($request->get('pseudo'),$request->get('password'));

        if (empty($responsable)) {
            return new JsonResponse(['message' => 'Le login et/ou le mot de passe sont incorrects','status'=>'KO'],Response::HTTP_OK);
        }else{
            $formatted = [];

            foreach ($responsable as $responsable) {
                $formatted = [
                    'id' => $responsable->getId(),
                    'pseudo' => $responsable->getPseudo(),
                    'responsabilite' => $responsable->getResponabilite(),
                    'client' => $responsable->getClient()->getID(),
                ];
            }
            return new JsonResponse($formatted,Response::HTTP_OK);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Rest\Post("/client/user")
     */
    public function userClient(Request $request){
        $oneUser = $this->client->oneUserClient($request->get('user'));
        if (empty($oneUser)) {
            return new JsonResponse(['message' => 'Utilisateur non vérifié','status'=>'KO'],Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Utilisateur vérifié', 'status' => 'OK'],Response::HTTP_OK);
        }
    }


    /**
     * @return JsonResponse
     * @Rest\Get("/lecture/temoignage")
     */
    public function temoignage(){
        $temoignage=$this->temoignage->findTe();
        $formatted=[];

        foreach ($temoignage as $temoignages) {
            $formatted []= [
                'id' => $temoignages->getId(),
                'titre' => $temoignages->getTitre(),
                'video' => $temoignages->getVideo(),
                'client'=> $temoignages->getClient()->getNom(),
                'idClient'=> $temoignages->getClient()->getId()
            ];
        }
        return new JsonResponse($formatted,Response::HTTP_OK);
    }

    /**
     * @param Temoignage $temoignage
     * @Rest\Get("/lecture/un/temoignage/{id}")
     * @return JsonResponse
     */
    public function temoignageone(Temoignage $temoignage)
    {
        $tem=$this->temoignage->find($temoignage->getId());
        $formatted=[
            'id' => $tem->getId(),
            'titre' => $tem->getTitre(),
            'video' => $tem->getVideo(),
            'description' => $tem->getDescription(),
            'client'=> $tem->getClient()->getNom(),
            'idClient'=> $tem->getClient()->getId()
        ];
        return new JsonResponse($formatted,Response::HTTP_OK);
    }
}