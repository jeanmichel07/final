<?php


namespace App\Controller\front;


use App\Entity\Commentaires;
use App\Entity\Email;
use App\Entity\WpPosts;
use App\Repository\AccueilRepository;
use App\Repository\AProposRepository;
use App\Repository\CommentairesRepository;
use App\Repository\DocumentRepository;
use App\Repository\TemoignageRepository;
use App\Repository\RessourceRepository;
use App\Repository\RessourceCostimgRepository;
use App\Repository\OffreEmploisRepository;
use App\Repository\VideoRepository;
use App\Repository\WpPostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function news(\Swift_Mailer $mailer, Request $request)
    {
        $email= new Email();
        $form=$this->createFormBuilder($email)->add('adresse')->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $email->setStatu('1');
            $em->persist($email);
            $em->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('tombokely@gmail.com')
                ->setTo($email->getAdresse())
                ->setBody('Felicitation')
            ;
            $mailer->send($message);
        }
        return $this->render('front/news.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/", name="home")
     * @param AccueilRepository $repository
     * @param AProposRepository $AProposRepository
     * @return Response
     */
    public function index(AccueilRepository $repository,Request $request, AProposRepository $AProposRepository, CommentairesRepository $commentairesRepository){

        $com=$commentairesRepository->findAll();
        dump($com);

        $accueil=$repository->findAll();
        $mission=$AProposRepository->searchTypemission();
        return $this->render('front/index.html.twig',[
            'accueil'=>$accueil,
            'mission'=>$mission,
        ]);
    }

    /**
     * @Route("/temoignage", name="temoignage")
     * @param AProposRepository $apropos
     * @param TemoignageRepository $temoignage
     * @return Response
     */
    public function temoignage(AProposRepository $apropos, TemoignageRepository $temoignage,Request $request)
    {

        $res = $apropos->searchTypeCompilation();
        $tem = $temoignage->findTe();

        return $this->render('front/temoignages.html.twig',[
            'apropos'=>$res,
            'temoignages'=>$tem,

        ]);
    }

    /**
     * @Route("/ressource", name="ressource")
     */
    public function ressource(Request $request)
    {

        return $this->render('front/ressource.html.twig',[

        ]);
    }

    /**
     * @Route("/services", name="services")
     */
    public function services(Request $request)
    {

        return $this->render('front/services.html.twig',[

        ]);
    }


    /**
     * @Route("/offre", name="offres")
     * @param OffreEmploisRepository $offre
     * @return Response
     */
    public function offre(OffreEmploisRepository $offre, Request $request)
    {

        $res =$offre->findOffre();
        return $this->render('front/offres.html.twig', [
            'offre'=>$res,

        ]);
    }

    /**
     * @Route("/apropos", name="aPropos")
     * @param AProposRepository $AProposRepository
     * @return Response
     */
    public function about(AProposRepository $AProposRepository, Request $request)
    {

        $mission=$AProposRepository->searchTypemission();
        return $this->render('front/about.html.twig',[
            'mission'=>$mission,

        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request)
    {

        return $this->render('front/contact.html.twig',[

        ]);
    }

    /**
    * @Route("/ressource/vlog", name="vlog")
    *
    */
    public function vlog(RessourceRepository $vlog, Request $request)
    {

        $res = $vlog->searchTypeVL();
          return $this->render('front/vlog.html.twig',[
            'vlog'=>$res,

        ]);

    }

    /**
     * @Route("/ressource/fact", name="fact")
     *
     */
    public function fact(RessourceRepository $fact, Request $request)
    {

        $res = $fact->searchTypeFact();
          return $this->render('front/fact.html.twig',[
            'fact'=>$res,

        ]);
    }

    /**
     * @Route("/ressource/jour", name="jour")
     *
     */
    public function jour(RessourceRepository $jour, Request $request)
    {

        $jo = $jour->searchTypejour();
        return $this->render('front/journee.html.twig',[
            'jour'=>$jo,

        ]);

    }

     /**
     * @Route("/ressource/success", name="success")
     *
     */
    public function success(RessourceRepository $success, Request $request)
    {

        $su = $success->searchTypeSS();
        return $this->render('front/story.html.twig',[
            'success'=>$su,

        ]);

    }

     /**
     * @Route("/ressource/daily", name="daily")
     *
     */
    public function daily(RessourceCostimgRepository $daily, Request $request)
    {

        $res = $daily->searchTypedaily();
        return $this->render('front/daily.html.twig',[
            'daily'=>$res,

        ]);

    }

    /**
     * @Route("/ressource/protip", name="protip")
     *
     */
    public function protip(RessourceCostimgRepository $protip, Request $request)
    {

        $res = $protip->searchTypePro();
        return $this->render('front/protip.html.twig',[
            'protip'=>$res,

        ]);

    }
    /**
     * @Route("/ressource/cvvideo", name="video")
     *
     */
    public function cv (VideoRepository $video, Request $request)
    {

        $res = $video->searchVideoCVF();
        return $this->render('front/cvvideos.html.twig',[
            'video'=>$res,

        ]);

    }

    /**
     * @Route("/ressource/entretient", name="entretient")
     *
     */
    public function entretient (VideoRepository $video, Request $request)
    {

        $res = $video->searchVideoEntretientf();
        return $this->render('front/entretientVideos.html.twig',[
            'entretient'=>$res,

        ]);

    }

    /**
     * @Route("/ressource/ebook", name="ebook")
     */
    public function ebook (DocumentRepository $document, Request $request)
    {

        $res = $document->findbook();
        return $this->render('front/ebook.html.twig',[
            'document' => $res,

        ]);

    }
    /**
     * @Route("/ressource/brochure", name="brochure")
     */
    public function brochure (DocumentRepository $document, Request $request)
    {

        $res = $document->findbrochure();
        return $this->render('front/brochure.html.twig',[
            'brochure' => $res,

        ]);

    }


    /**
     * @Route("/services/cooptation", name="cooptat")
     *
     */
    public function cooptation(Request $request)
    {

        return $this->render('front/cooptation.html.twig',[

        ]);

    }

    /**
     * @Route("/service/inbound", name="inbound")
     *
     */
    public function inbound(Request $request)
    {

        return $this->render('front/inbound.html.twig',[

        ]);

    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/blog", name="blog")
     */
    public function blog(Request $request, WpPostsRepository $wpPostsRepository){
        $post=$wpPostsRepository->finPosts();
        dump($post);

        return $this->render('front/blog.html.twig',[

            'post'=>$post
        ]);
    }

    /**
     * @param Request $request
     * @param WpPosts $posts
     * @return Response
     * @throws \Exception
     * @Route("blog/{id}", name="blog_contenu")
     */
    public function blogContenu(Request $request, WpPosts $posts){
        dump($posts);
        $em=$this->getDoctrine()->getManager();
        $commentaire=new Commentaires();
        $formCommentaire=$this->createFormBuilder($commentaire)
            ->add('contenu',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Votre commentaire...',
                    'rows'=>'5'
                ]
            ])->getForm();
        $formCommentaire->handleRequest($request);
        if($formCommentaire->isSubmitted() && $formCommentaire->isValid()){
            $commentaire->setArticle($posts);
            $user=$this->getUser();
            if($user->getType()->getLabel() == 'responsable'){
                $commentaire->setAuthorClient($user);
            }else{
                $commentaire->setAuthor($user);
            }
            $commentaire->setCreated(new \DateTime());
            $em->persist($commentaire);
            $em->flush();
        }
        return $this->render('front/blogContenu.html.twig',[
            'post'=>$posts,
            'comment'=>$formCommentaire->createView()
        ]);
    }
}