<?php


namespace App\Controller\front;


use App\Entity\About;
use App\Entity\Candidat;
use App\Entity\CandidatSexe;
use App\Entity\Candidature;
use App\Entity\Cooptation;
use App\Entity\Coopteur;
use App\Entity\Formatiom;
use App\Entity\Formation;
use App\Entity\OffreEmplois;
use App\Entity\Parcours;
use App\Entity\SituationFamilier;
use App\Repository\UserTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class RegisterController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @param Request $request
     * @param UserTypeRepository $repository
     * @return Response
     * @Route("/inscription/candidat" ,name="inscription_candidat")
     */
    public function inscription(Request $request, UserTypeRepository $repository)
    {
        $candidat=new Candidat();
        $form=$this->createFormBuilder($candidat)
            ->add('photo',FileType::class)
            ->add('nom')
            ->add('dateNaissance',DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('candidatSexe',EntityType::class,[
                'class'=>CandidatSexe::class
            ])
            ->add('situation',EntityType::class,[
                'class'=>SituationFamilier::class
            ])
            ->add('telephone')
            ->add('email')
            ->add('pays')
            ->add('ville')
            ->add('adresse')
            ->add('username',TextType::class,[
                'label'=>'Votre Pseudo'
            ])
            ->add('password',PasswordType::class,[
                'label'=>'Mot de passe'
            ])
            ->add('confirmPassword',PasswordType::class,[
                'label'=>'Confirmer votre mot de passe'
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
//            $userType=$repository->find();
            $hash=$this->encoder->encodePassword($candidat, $candidat->getPassword());

            $candidat->setPassword($hash);


            $filePhoto =  $form->get('photo')->getData();
            $filenamePhoto=md5(uniqid()).'.'.$filePhoto->guessExtension();
            $filePhoto->move($this->getParameter('upload_candidat'), $filenamePhoto);
            $candidat->setPhoto($filenamePhoto);

            $this->em->persist($candidat);
            $this->em->flush();
            return $this->redirectToRoute('connexion');
        }

        return $this->render('formulaire/inscriptionCandidat.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/candidature/{id}", name="candidature")
     * @param OffreEmplois $offreEmplois
     * @param Request $request
     * @return Response
     */
    public function candidature(OffreEmplois $offreEmplois, Request $request, \Swift_Mailer $mailer)
    {
        $user=$this->getUser();
        $candidat=$this->getUser();
        $offre=$offreEmplois;

        $candidature = new Candidature();
        $form=$this->createFormBuilder($candidature)
            ->add('cv', FileType::class)
            ->add('lm',FileType::class)
            ->add('ds',FileType::class , [
                'required' => false,
            ])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $candidature->setDate(new \DateTime());
            $candidature->setCandidat($candidat);
            $candidature->setOffreEmplois($offre);

            $fileCV = $candidature->getCv();
            $filenameCV=md5(uniqid()).'.'.$fileCV->guessExtension();
            $fileCV->move($this->getParameter('upload_directory'), $filenameCV);
            $candidature->setCv($filenameCV);

            $fileLm = $candidature->getLm();
            $filenameLm=md5(uniqid()).'.'.$fileLm->guessExtension();
            $fileLm->move($this->getParameter('upload_directory'), $filenameLm);
            $candidature->setLm($filenameLm);

            $fileDs = $candidature->getDs();

            if(empty($fileDs)){

            }else{
                $fileDs = $candidature->getDs();
                $filenameDs=md5(uniqid()).'.'.$fileDs->guessExtension();
                $fileDs->move($this->getParameter('upload_directory'), $filenameDs);
                $candidature->setDs($filenameDs);

            }
            $this->addFlash('info','votre candidature est enregistré');
            $em=$this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();
            $message = (new \Swift_Message('Candidarure sur '.$offreEmplois->getTitre()))
                ->setFrom('tombokely@gmail.com')
                ->setTo('tombokely@gmail.com')
                ->setBody('test')
                ->attach(\Swift_Attachment::fromPath('http://127.0.0.1:8000/uploads/'.$candidature->getCv()))
            ;
            $mailer->send($message);
        }

        return $this->render('formulaire/candidature.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/cooptation/{id}", name="cooptation")
     * @param OffreEmplois $offreEmplois
     * @param Request $request
     * @return Response
     */
    public function cooptation(OffreEmplois $offreEmplois, Request $request)
    {
        $coopteur=$this->getUser();
        $offre=$offreEmplois;

        $cooptation = new Cooptation();
        $form=$this->createFormBuilder($cooptation)
            ->add('cv', FileType::class)
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cooptation->setDate(new \DateTime());
            $cooptation->setCoopteur($coopteur);
            $cooptation->setOffreEmplois($offre);

            $fileCV = $cooptation->getCv();
            $filenameCV=md5(uniqid()).'.'.$fileCV->guessExtension();
            $fileCV->move($this->getParameter('upload_directory'), $filenameCV);
            $cooptation->setCv($filenameCV);


            $this->addFlash('info','votre cooptation est OK');
            $em=$this->getDoctrine()->getManager();
            $em->persist($cooptation);
            $em->flush();


        }

        return $this->render('formulaire/cooptation.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new/parcour", name="newParcours")
     */
    public function newParcoursCandidat(Request $request, EntityManagerInterface $em)
    {
        $user=$this->getUser();
        if($user == null){return $this->redirectToRoute('connexion');}
        $parcours=new Parcours();
        $form=$this->createFormBuilder($parcours)
        ->add('entreprise')
        ->add('poste')
        ->add('lieu')
        ->add('debut',DateType::class,[
            'widget'=>'single_text'
        ])
        ->add('fin',DateType::class,[
            'widget'=>'single_text'
        ])
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $parcours->setCandidat($user);
            $em->persist($parcours);
            $em->flush();
            return $this->redirectToRoute('profil_candidat');
        }
        return $this->render('formulaire/newParcours.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/about/candidat/", name="new_about")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAbout(Request $request)
    {
        $about=new About();
        $user=$this->getUser();
        $form=$this->createFormBuilder($about)
            ->add('contenu',TextareaType::class,[
                'label'=>'À propos',
                'attr'=>[
                    'placeholder'=>'À propos de vous...',
                    'rows'=> '8'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $about->setUser($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($about);
            $em->flush();
            return $this->redirectToRoute('profil_candidat');
        }
        return $this->render('formulaire/about.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("/new/formation", name="new_formation")
     */
    public function newFormation(Request $request, EntityManagerInterface $em){
        $user=$this->getUser();
        $formation=new Formation();
        $form=$this->createFormBuilder($formation)
            ->add('university')
            ->add('diplome')
            ->add('filier')
            ->add('debut',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('fin',DateType::class,[
                'widget'=>'single_text'
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $formation->setCandidat($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('profil_candidat');
        }
        return $this->render('formulaire/newFormation.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param UserTypeRepository $repository
     * @return Response
     * @Route("/inscription/Coopteur" ,name="inscription_coopteur")
     */
    public function inscriptionCoopteur(Request $request, UserTypeRepository $repository)
    {
        $coopteur=new Coopteur();
        $form=$this->createFormBuilder($coopteur)
            ->add('photo',FileType::class)
            ->add('nom')
            ->add('telephone')
            ->add('entreprise')
            ->add('email')
            ->add('pays')
            ->add('ville')
            ->add('adresse')
            ->add('username',TextType::class,[
                'label'=>'Votre Pseudo'
            ])
            ->add('password',PasswordType::class,[
                'label'=>'Mot de passe'
            ])
            ->add('confirmpassword',PasswordType::class,[
                'label'=>'Confirmer votre mot de passe'
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {


            $hash=$this->encoder->encodePassword($coopteur, $coopteur->getPassword());

            $coopteur->setPassword($hash);
            $filePhoto =  $form->get('photo')->getData();
            $filenamePhoto=md5(uniqid()).'.'.$filePhoto->guessExtension();
            $filePhoto->move($this->getParameter('upload_coopteur'), $filenamePhoto);
            $coopteur->setPhoto($filenamePhoto);


            $this->em->persist($coopteur);
            $this->em->flush();
            return $this->redirectToRoute('connexion');
        }

        return $this->render('formulaire/inscriptionCoopteur.html.twig',[
            'form'=>$form->createView()
        ]);
    }

}