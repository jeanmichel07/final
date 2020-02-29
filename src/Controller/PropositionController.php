<?php

namespace App\Controller;

use App\Entity\Acces;
use App\Entity\Candidat;
use App\Entity\LigneProposition;
use App\Entity\OffreEmplois;
use App\Entity\Proposition;
use App\Entity\Responsable;
use App\Repository\CandidatRepository;
use App\Repository\OffreEmploisRepository;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class PropositionController
 * @package App\Controller
 * @Route("/admin")
 */
class PropositionController extends AbstractController
{
    /**
     * @var OffreEmploisRepository
     */
    private $emploisRepository;
    /**
     * @var PropositionRepository
     */
    private $proposition;
    /**
     * @var CandidatRepository
     */
    private $candidta;

    private $client;
    public function __construct(OffreEmploisRepository $emploisRepository,PropositionRepository $proposition,CandidatRepository $candidta)
    {
        $this->emploisRepository = $emploisRepository;
        $this->proposition = $proposition;
        $this->candidta = $candidta;
    }

    /**
     * @Route("/offres", name="offre")
     */
    public function indexOffre()
    {
        $offre=$this->emploisRepository->findOffre();
        return $this->render('admin/proposition/index.html.twig', [
            'offre' => $offre,
            'current_menu'=>'prop'
        ]);
    }

    /**
     * @Route("/proposition/offre/{id}",name="proposition")
     * @param OffreEmplois $offreEmplois
     * @return Response
     */
    public function indexProp(OffreEmplois $offreEmplois)
    {
        $proposition=$this->proposition->findProposition($offreEmplois);
        return $this->render('admin/proposition/proposition.html.twig',[
            'prop'=>$proposition,
            'current_menu'=>'prop',
            'poste'=>$offreEmplois->getTitre(),
            'idOffre'=>$offreEmplois->getId()
        ]);
    }

    /**
     * @Route("/new/proposition/{id}" ,name="new_proposition")
     * @param OffreEmplois $offreEmplois
     * @return RedirectResponse
     * @throws \Exception
     */
    public function newProposition(OffreEmplois $offreEmplois)
    {
        $proposition=new Proposition();
        $em=$this->getDoctrine()->getManager();
        $proposition->setOffreEmplois($offreEmplois);
        $proposition->setDate(new \DateTime());
        $em->persist($proposition);
        $em->flush();
        return $this->redirectToRoute('ligne_proposition',['id'=>$proposition->getId()]);

    }

    /**
     * @Route("/ligne/proposition/{id}/", name="ligne_proposition")
     * @param Proposition $proposition
     * @param Request $request
     * @return Response
     */
    public function ligneProposition(Proposition $proposition,Request $request, EntityManagerInterface $em)
    {
            $candidat=$this->candidta->findCandidat();
            $acces=new Acces();
            $client=$proposition->getOffreEmplois()->getClient();
            $this->client=$proposition->getOffreEmplois()->getClient();

            $form=$this->createFormBuilder($acces)
                ->add('responsable',EntityType::class,[
                    'class'=>Responsable::class,
                    'query_builder'=>function(EntityRepository $er){
                    $er->createQueryBuilder('r')
                        ->where('r.client=:client')
                        ->setParameter('client',$this->client)
                        ->orderBy('r.username','ASC');
                    },
                    'choice_label'=>'responabilite'
                ])->getForm();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $acces->setProposition($proposition);
                $em->persist($acces);
                $em->flush();
                return $this->redirectToRoute('add_ligne',['id'=>$proposition->getId()]);
            }
            return $this->render('admin/proposition/acces.html.twig',[
                'candidat'=>$candidat,
                'current_menu'=>'prop',
                'form'=>$form->createView(),
                'client'=>$client
            ]);
    }

    /**
     * @Route("/add/ligne/{id}", name="add_ligne")
     * @param Proposition $proposition
     * @param Request $request
     * @return Response
     */
    public function ajoutligne(Proposition $proposition, Request $request, EntityManagerInterface $em)
    {
        $ligne=new LigneProposition();
        $form=$this->createFormBuilder($ligne)
            ->add('candidat',EntityType::class,[
                'class'=>Candidat::class,
                'query_builder'=>function(EntityRepository $er){
                $er->createQueryBuilder('c');
                },
                'required'=>false,
                'label'=>'Choisir un cadidat deja inscrit'
            ])
            ->add('CV',FileType::class,[
                'required'=>false
            ])
            ->add('LM',FileType::class,[
                'required'=>false
            ])
            ->add('cls',FileType::class,[
                'required'=>false
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ligne->setProposition($proposition);
            if($ligne->getCv() != null){
                $fileCV = $form->get('CV')->getData();
                $filenamec = md5(uniqid()) . '.' . $fileCV->guessExtension();
                $fileCV->move($this->getParameter('upload_directory'), $filenamec);
                $ligne->setCv($filenamec);
            }

            if($ligne->getLm() != null){
                $fileLM = $form->get('LM')->getData();
                $filenameL = md5(uniqid()) . '.' . $fileLM->guessExtension();
                $fileLM->move($this->getParameter('upload_directory'), $filenameL);
                $ligne->setCv($filenameL);
            }
            if($ligne->getCls() != null){
                $filecls = $form->get('cls')->getData();
                $filenames = md5(uniqid()) . '.' . $filecls->guessExtension();
                $filecls->move($this->getParameter('upload_directory'), $filenames);
                $ligne->setCv($filenames);
            }


            $em->persist($ligne);
            $em->flush();
            return $this->redirectToRoute('add_ligne',['id'=>$proposition->getId()]);
        }
        return $this->render('admin/proposition/ligne.html.twig',[
            'prop'=>$proposition,
            'form'=>$form->createView(),
            'current_menu'=>'prop',
        ]);
    }
}
