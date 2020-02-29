<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Responsable;
use App\Entity\Temoignage;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Repository\ResponsableRepository;
use App\Repository\TemoignageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ClientController
 * @package App\Controller
 * @Route("/admin")
 */
class ClientController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var TemoignageRepository
     */
    private $temoignageRepository;
    /**
     * @var ResponsableRepository
     */
    private $responsable;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $em, ClientRepository $clientRepository,TemoignageRepository $temoignageRepository, ResponsableRepository $responsable, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->clientRepository = $clientRepository;
        $this->temoignageRepository = $temoignageRepository;
        $this->responsable = $responsable;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/client", name="client_index")
     * @return Response
     */
    public function index(): Response
    {
        $clients = $this->clientRepository->findAll();
        return $this->render('admin/client/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clients,
            'current_menu' => 'client'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/client/new", name="client_new")
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
//            $client->setPassword(sha1($client->getPassword()));
            $this->em->persist($client);
            $this->em->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('admin/client/new.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'client'
        ]);
    }

    /**
     * @param Client $client
     * @param Request $request
     * @return Response
     * @Route("/client/{id}", name="client_edit", methods="POST|GET")
     */
    public function edit(Client $client, Request $request): Response
    {
        $form = $this->createFormBuilder($client)
            ->add('nom')
            ->add('adresse')
            ->add('telephone')
            ->add('email')
            ->add('web')
            ->add('secteur')->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('client_index');
        }

        return $this->render('admin/client/edit.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'client'
        ]);
    }

    /**
     * @param Client $client
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Route("/delete/client/{id}", name="client_delete")
     */
    public function delete(Client $client): Response
    {
        $row = $this->temoignageRepository->findRowTemoignage($client->getId());
        if ($row == 0) {
            $this->em->remove($client);
            $this->em->flush();
            return $this->redirectToRoute('client_index', [
                'clients' => $client,
                'current_menu' => 'client'
            ]);
        } else {
            return new Response('Ce client ne peut pas etre supprimer');
        }
    }

    /**
     * @param Client $client
     * @return Response
     * @Route("/option/client/{id}", name="options")
     */
    public function options(Client $client)
    {
        return $this->render('admin/client/option.html.twig',[
            'client'=>$client,
            'current_menu' => 'client'
        ]);
    }

    /**
     * @Route("/liste/responsable/client/{id}" ,name="responsable")
     * @param Client $client
     * @return Response
     */
    public function responsable(Client $client)
    {
        $responsable=$this->responsable->findResponsable($client->getId());
        return $this->render('admin/client/responsable.html.twig',[
            'c'=>$client,
            'responsable'=>$responsable,
            'current_menu' => 'client'
        ]);
    }

    /**
     * @Route("/create/responsable/client/{id}", name="new_responsable")
     * @param Client $client
     * @return Response
     */
    public function createResponsable(Client $client,Request $request)
    {
        $responsable=$this->responsable->findResponsable($client->getId());
        $respo=new Responsable();
        $form=$this->createFormBuilder($respo)
            ->add('responabilite')
            ->add('username')
            ->add('password',PasswordType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $respo->setClient($client);
            $hash=$this->encoder->encodePassword($respo, $respo->getPassword());
            $respo->setPassword($hash);
            $em=$this->getDoctrine()->getManager();
            $em->persist($respo);
            $em->flush();
            return $this->redirectToRoute('responsable',['id'=>$client->getId()]);
        }
        return $this->render('admin/client/creatResponsable.html.twig',[
            'form'=>$form->createView(),
            'client'=>$client
        ]);
    }

    /**
     * @param Client $client
     * @param Request $request
     * @return Response
     * @Route("/ajout/temoignage/{id}", name="ajout_temoin")
     */
    public function addTemoignage(Client $client,Request $request)
    {
        $temoingnage=new Temoignage();
        $form=$this->createFormBuilder($temoingnage)
            ->add('titre',TextType::class,[
                'label'=>'Titre',
                'attr'=>[
                    'placeholder'=>'Titre...'
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Description...'
                ]
            ])
            ->add('video',TextType::class,[
                'attr'=>[
                    'placeholder'=>'lien du video'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            $temoingnage->setClient($client);
            $this->em->persist($temoingnage);
            $this->em->flush();
            return $this->redirectToRoute('list_temoignage',['id'=>$client->getId()]);
        }

        return $this->render('admin/client/addTemoingnage.html.twig',[
            'current_menu' => 'client',
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/list/temoignage/client/{id}", name="list_temoignage")
     * @param Client $client
     * @return Response
     */
    public function temoignage(Client $client, Request $request)
    {
        $temo=$this->temoignageRepository->findtem($client);
        $idCl=$client->getId();
        return $this->render('admin/client/list.html.twig',[
            'client'=>$client,
            'current_menu' => 'client',
            'tem'=>$temo,
            'id'=>$idCl
        ]);
    }

    /**
     * @param Temoignage $temoignage
     * @return Response
     * @Route("/delete/temoignage/{id}", name="delete_temoignage")
     */
    public function deleteTem(Temoignage $temoignage){
            $this->em->remove($temoignage);
            $this->em->flush();

        return $this->redirectToRoute('client_index');
    }

    /**
     * @param Temoignage $temoignage
     * @Route("/lire/temoignage/{id}", name="lire_temoignage")
     * @return Response
     */
    public function lireTem(Temoignage $temoignage)
    {
        return $this->render('admin/client/readTem.html.twig',[
            'current_menu' => 'client',
            'temoin'=>$temoignage
        ]);
    }
}
