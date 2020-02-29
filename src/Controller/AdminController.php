<?php

namespace App\Controller;

use App\Entity\APropos;
use App\Entity\Document;
use App\Entity\OffreEmplois;
use App\Entity\Ressource;
use App\Entity\RessourceCostimg;
use App\Form\OffreEmploisType;
use App\Form\RessourceType;
use App\Repository\AdminRepository;
use App\Repository\AProposRepository;
use App\Repository\DocumentRepository;
use App\Repository\OffreEmploisRepository;

use App\Repository\RessourceCostimgRepository;
use App\Repository\RessourceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @var AdminRepository
     */
    private $repository;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var OffreEmploisRepository
     */
    private $emploisRepository;

    var $ressource;
    var $ressourceImg;
    var $apropos;





    /**
     * AdminController constructor.
     * @param AdminRepository $repository
     * @param SessionInterface $session
     * @param ObjectManager $em
     * @param OffreEmploisRepository $emploisRepository

     */
    public function __construct(
        AdminRepository $repository,
        SessionInterface $session,
        EntityManagerInterface $em,
        OffreEmploisRepository $emploisRepository,
        RessourceRepository $ressource,
        RessourceCostimgRepository $ressourceImg,
        AProposRepository $apropos
    )
    {
        $this->repository = $repository;
        $this->session = $session;
        $this->em = $em;
        $this->emploisRepository = $emploisRepository;

        $this->ressource = $ressource;
        $this->ressourceImg = $ressourceImg;
        $this->apropos = $apropos;
    }

    /**
     * @Route("", name="login_admin")
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $form=$this->createFormBuilder()
            ->add('username',TextType::class,[
                'label'=> "Nom d'utilisateur",
                'attr'=>[
                    'placeholder'=>"Nom d'utilisateur",
                    'class'=>'form-control'
                ]
            ])
            ->add('password',PasswordType::class,[
                'label'=> "Mot de passe",
                'attr'=>[
                    'placeholder'=>"Mot de passe",
                    'class'=>'form-control'
                ]
            ])->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $username=$request->request->get("form")['username'];
            $password=$request->request->get("form")['password'];
            $admin=$this->repository->findAdmin($username,$password);
            if(count($admin)==1){
                $session=$this->session;
                $session->set('user_admin',$username);
                $sessionUsernameAdmin=$session->get('username');

                return $this->redirectToRoute('accueil');
            }else{
                $err="Nom d'utilisateur ou Mot de passe incorrecte";
                return $this->render('admin/login.html.twig',[
                    'form'=>$form->createView(),
                    'erreur'=>$err
                ]);
            }
        }
        return $this->render('admin/login.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function homeAdmin(){
        return $this->render('admin/home.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        $this->session->clear();
        return $this->redirectToRoute('login_admin');
    }

    /**
     * @return Response
     * @Route("/service", name="service_admin")
     */
    public function service(): Response
    {
        return $this->render('service.html.twig');
    }

    /**
     * @return Response
     * @Route("/offreEmplois/index", name="offre_emplois_index")
     */
    public function offreEmplois(): Response
    {
        $offreEmplois = $this->emploisRepository->findOffre();
        return $this->render('admin/offreEmplois/index.html.twig', [
            'current_menu' => 'offre',
            'offreEmplois' => $offreEmplois
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/offreEmplois/new", name="offre_emplois_new")
     */
    public function newEmpois(Request $request): Response
    {
        $empois = new OffreEmplois();
        $form = $this->createForm(OffreEmploisType::class, $empois);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $fileImage =  $form->get('image')->getData();
            $filenameImage=md5(uniqid()).'.'.$fileImage->guessExtension();
            $fileImage->move($this->getParameter('upload_offre'), $filenameImage);
            $empois->setImage($filenameImage);
            $this->em->persist($empois);
            $this->em->flush();
            return $this->redirectToRoute('offre_emplois_index');
        }


        return $this->render('admin/offreEmplois/new.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'offre'
        ]);
    }

    /**
     * @param OffreEmplois $offre
     * @return RedirectResponse|Response
     * @Route("/offreEmplois/edit/{id}", name="offre_emplois_edit")
     */
    public function editOffre(Request $request,OffreEmplois $offre)
    {
        $form = $this->createForm(OffreEmploisType::class, $offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($offre);
            $this->em->flush();
            return $this->redirectToRoute('offre_emplois_index');
        }



        return $this->render('admin/offreEmplois/edit.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'offre'
        ]);
    }

    /**
     * @param OffreEmplois $offreEmplois
     * @return Response
     * @Route("/offreEmplois/show/{id}", name="offre_emplois_show")
     */
    public function showEmpois(OffreEmplois $offreEmplois): Response
    {
        return $this->render('admin/offreEmplois/show.html.twig', [
            'offre' => $offreEmplois,
            'current_menu' => 'offre'
        ]);
    }

    /**
     * @param OffreEmplois $offre
     * @return RedirectResponse
     * @Route("/delete/offre/{id}")
     */
    public function deleteOffre(OffreEmplois $offre)
    {
        $this->em->remove($offre);
        $this->em->flush();
        return $this->redirectToRoute('offre_emplois_index');
    }

    /**
     * @Route("/ressource" , name="res_index")
     */
    public function ressource()
    {
        $res= $this->ressource->findRessource();
        return $this->render('admin/ressource/index.html.twig', [
            'current_menu' => 'ressource',
            'ressource' => $res
        ]);
    }

    /**
     * @Route("/new/ressource" , name="res_new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newRessource(Request $request)
    {
        $ressource= new Ressource();
        $form=$this->createFormBuilder($ressource)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "VLOG"=>"VLOG",
                    "FACT & FUEL"=>"FACT",
                    "LA JOURNEE D'UN"=>"LA JOURNEE D'UN",
                    "SUCCESS STORY"=>"SUCCESS STORY"
                ]
            ])
            ->add('titre',TextType::class,[
                'label'=>'Titre',
                'attr'=>[
                    'placeholder'=>'Titre...'
                ]
            ])

            -> add ( 'description' , CKEditorType :: class , array (
                'config' => array (


                ),

            ))
            ->add('video',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Lien du video'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {


            $this->em->persist($ressource);
            $this->em->flush();
            return $this->redirectToRoute('res_index');
        }
        return $this->render('admin/ressource/new.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'ressource'
        ]);
    }
    /**
     * @Route("/ressource/{id}", name="ShowResource")
     */
    public function showRessource(Ressource $ressource)
    {
        return $this->render('admin/ressource/show.html.twig', [
            'ressource' => $ressource,
            'current_menu' => 'Story'
        ]);
    }

    /**
     * @Route("/update/ressource/{id}", name="UpdateResource")
     * @param Ressource $ressource
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updateRessource(Ressource $ressource, Request $request)
    {
        $form=$this->createFormBuilder($ressource)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "VLOG"=>"VLOG",
                    "FACT & FUEL"=>"FACT",
                    "LA JOURNEE D'UN"=>"LA JOURNEE D'UN",
                    "SUCCESS STORY"=>"SUCCESS STORY"
                ]
            ])
            ->add('titre',TextType::class,[
                'label'=>'Titre',
                'attr'=>[
                    'placeholder'=>'Titre...'
                ]
            ])
            -> add ( 'description' , CKEditorType :: class , array (
                'config' => array (


                ),

            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em= $this->getDoctrine()->getManager();
            $em->persist($ressource);
            $em->flush();
            return $this->redirectToRoute('res_index');
        }

        return $this->render('admin/ressource/update.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @param Ressource $ressource
     * @return RedirectResponseAlias
     * @Route("/delete/post/{id}", name="deletevideo")
     */
    public function removeBlog(Ressource $ressource)
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($ressource);
        $em->flush();
        return $this->redirectToRoute('res_index');
    }
    /**
     * @Route("/ressourceimage" , name="image_index")
     */
    public function ressourceimg()
    {
        $res= $this->ressourceImg->findRessourceimg();
        return $this->render('admin/ressourceimage/index.html.twig', [
            'current_menu' => 'image',
            'ressourceImg' => $res
        ]);
    }

    /**
     * @Route("new/ressourceimage" , name="image_new")
     */
    public function newRessourcephoto(Request $request)
    {
        $ressourceImg= new RessourceCostimg();

        $form=$this->createFormBuilder($ressourceImg)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "Daily quotes"=>"daily quotes",
                    "Pro tips"=>"Pro tips",

                ]
            ])
            ->add('titre',TextType::class,[
                'label'=>'Titre',
                'attr'=>[
                    'placeholder'=>'Titre...'
                ]
            ])

            ->add('image',FileType::class,[
                'attr'=>[
                    'placeholder'=>'Choisissez votre image'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $filePhoto =$ressourceImg->getImage();
            $filenamePhoto=md5(uniqid()).'.'.$filePhoto->guessExtension();
            $filePhoto->move($this->getParameter('upload_directory'), $filenamePhoto);
            $ressourceImg->setImage($filenamePhoto);
            $this->em->persist($ressourceImg);
            $this->em->flush();
            return $this->redirectToRoute('image_index');
        }
        return $this->render('admin/ressourceimage/new.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'image'
        ]);
    }

    /**
     * @Route("/ressourceimage/{id}", name="ShowResourceimage")
     */
    public function showRessourceimage(RessourceCostimg $ressourceImg)
    {
        return $this->render('admin/ressourceimage/show.html.twig', [
            'ressourceImg' => $ressourceImg,
            'current_menu' => 'image'
        ]);
    }
    /**
     * @Route("/update/ressourceimage/{id}", name="UpdateResourceimage")
     */
    public function updateRessourceimage(RessourceCostimg $ressourceImg, Request $request)
    {
        $form=$this->createFormBuilder($ressourceImg)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "Daily quotes"=>"Daily quotes",
                    "Pro tips"=>"Pro tips",
                ]
            ])
            ->add('titre',TextType::class,[
                'label'=>'Titre',
                'attr'=>[
                    'placeholder'=>'Titre...'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em= $this->getDoctrine()->getManager();
            $em->persist($ressourceImg);
            $em->flush();
            return $this->redirectToRoute('image_index');
        }

        return $this->render('admin/ressourceimage/update.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @param RessourceCostimg $ressourceImg
     * @return RedirectResponseAlias
     * @Route("/delete/ressourceimage/{id}", name="delete")
     */
    public function removeImage(RessourceCostimg $ressourceImg)
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($ressourceImg);
        $em->flush();
        return $this->redirectToRoute('image_index');
    }
    /**
     * @Route("/apropos" , name="apropos_index")
     */
    public function apropos()
    {
        $res= $this->apropos->findApropos();
        return $this->render('admin/apropos/index.html.twig', [
            'current_menu' => 'apropos',
            'apropos' => $res
        ]);
    }
    /**
     * @Route("new/apropos" , name="apropos_new")
     */
    public function newapropos(Request $request)
    {
        $apropos= new APropos();

        $form=$this->createFormBuilder($apropos)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "Notre mission"=>"Notre mission",
                    "Book Club "=>"Book Club ",
                    "Compilation Temoignage "=>"Compilation Temoignage",

                ]
            ])

            ->add('video',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Lien youtube'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

//            $file = $apropos->getVideo();
//            $filename = md5(uniqid()) . '.' . $file->guessExtension();
//            $file->move($this->getParameter('upload_directory'), $filename);
//            $apropos->setVideo($filename);

            $this->em->persist($apropos);
            $this->em->flush();
            return $this->redirectToRoute('apropos_index');
        }
        return $this->render('admin/apropos/new.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'apropos'
        ]);
    }

    /**
     * @Route("/apropos/{id}", name="ShowApropos")
     */
    public function showApropos(APropos $propos)
    {
        return $this->render('admin/apropos/show.html.twig', [
            'apropos' => $propos,
            'current_menu' => 'Apropos'
        ]);
    }
    /**
     * @Route("/update/apropos/{id}", name="UpdateApropos")
     */
    public function updateRApropos(APropos $propos, Request $request)
    {
        $form=$this->createFormBuilder($propos)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "Notre mission"=>"Notre mission",
                    "Book Club"=>"Book Club",
                    "Compilation Temoignage "=>"Compilation Temoignage",

                ]
            ])

            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em= $this->getDoctrine()->getManager();
            $em->persist($propos);
            $em->flush();
            return $this->redirectToRoute('apropos_index');
        }

        return $this->render('admin/apropos/update.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param APropos $propos
     * @return RedirectResponse
     * @Route("/delete/apropos/{id}", name="DeleteApropos")
     */
    public function removeapropos(APropos $propos)
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($propos);
        $em->flush();
        return $this->redirectToRoute('apropos_index');
    }

    /**
     * @Route("/index/document", name="index_document")
     */
    public function indexDocument(DocumentRepository $repository)
    {
        $document=$repository->findDoc();
        return $this->render("admin/document/index.html.twig",[
            'document'=>$document,
            'current_menu' => 'document'
        ]);
    }

    /**
     * @Route("/create/document" ,name="new_doc")
     */
    public function createDoc(Request $request)
    {
        $document=new Document();
        $form=$this->createFormBuilder($document)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "Ebook"=>"Ebook",
                    "Brochure"=>"Brochure",

                ]
            ])
            ->add('titre')

            -> add ( 'desciption' , CKEditorType :: class , array (

            ))
            ->add('file',FileType::class,[
                'attr'=>[
                    'placeholder'=>'Choisissez votre fichier'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $file = $document->getFile();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $document->setFile($filename);

            $this->em->persist($document);
            $this->em->flush();
            return $this->redirectToRoute('index_document');
        }
        return $this->render('admin/document/create.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'document'
        ]);
    }

    /**
     * @param Request $request
     * @param Document $document
     * @Route("/update/document/{id}" , name="update_document")
     * @return RedirectResponse|Response
     */
    public function updateDoc(Request $request, Document $document)
    {
        $form=$this->createFormBuilder($document)
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    "Blog"=>"blog",

                ]
            ])
            ->add('titre')
            -> add ( 'desciption' , CKEditorType :: class , array (

            ))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($document);
            $this->em->flush();
            return $this->redirectToRoute('index_document');
        }
        return $this->render('admin/document/update.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'document'
        ]);
    }

    /**
     * @param Document $document
     * @Route("/delete/document/{id}")
     * @return RedirectResponse
     */
    public function deleteDoc(Document $document)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($document);
        $em->flush();
        return $this->redirectToRoute('index_document');
    }


}
