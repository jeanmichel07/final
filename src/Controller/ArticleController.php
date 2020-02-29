<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RessourceCostimgRepository;
use App\Repository\RessourceRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("/admin")
 */
class ArticleController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/article", name="article")
     */
    public function index() {
        $em = $this->getDoctrine()->getRepository(Article::class);
        $articles = $em->findAll();
        return $this->render('article/index.html.twig', [
                    'articles' => $articles,
                    'current_menu' => 'articolos'
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function showArticle(Request $request, $id) {
        $em = $this->getDoctrine()->getRepository(Article::class);
        $article = $em->findById($id);
        return $this->render('article/show.html.twig', [
                    'article' => $article,
                    'current_menu' => 'articolos'
        ]);
    }
    
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/show_ajax/{id}", name="article_showing")
     */
    public function findByArticleAjax(Request $request, $id) {
        $em = $this->getDoctrine()->getRepository(Article::class);
        $article = $em->findById($id);
        return $this->render('article/findarticle.html.twig', [
                    'article' => $article
        ]);
    }

    /**
     * @Route("new/article" , name="article_new")
     */
    public function article_new(Request $request) {
        $artcile = new Article();
        $form = $this->createFormBuilder($artcile)
                ->add('titre', TextType::class, [
                    'label' => 'Titre',
                    'attr' => [
                        'placeholder' => 'Titre...'
                    ]
                ])
                ->add('image', FileType::class, [
                    'label' => 'Ajouter un image',
                    'attr' => [
                        'placeholder' => 'Ajouter un image'
                    ]
                ])
                -> add ( 'contenu' , CKEditorType :: class , array (
                    'label' => 'contenue de l\'article',
                    'attr' => [
                        'placeholder' => 'Ajouter les contenue de l\'article'
                    ]

                ))

                ->add('lien', TextType::class, [
                    'label' => 'Ajouter un lien (image ou vidéo)',
                    'attr' => [
                        'placeholder' => 'url (exemple : https://www.monsite.com/image.png)'
                    ]
                ])
                ->add('save', SubmitType::class, array(
                    'label' => 'Ajouter l\'article'))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fileArticle = $form->get('image')->getData();
            $filename = md5(uniqid()) . '.' . $fileArticle->guessExtension();
            $fileArticle->move($this->getParameter('upload_directory'), $filename);
            $artcile->setImage($filename);
            $artcile->setCreatedAt(new \Datetime());
            $artcile->setStatus("en cours de validation");
            $this->em->persist($artcile);
            $this->em->flush();
            return $this->redirectToRoute('article');
        }
        return $this->render('article/new.html.twig', [
                    'form' => $form->createView(),
                    'current_menu' => 'articolos'
        ]);
    }

    /**
     * @Route("/update/article/{id}", name="update_article")
     */
    public function updateArticle(Article $article, Request $request) {
        $form = $this->createFormBuilder($article)
                ->add('titre', TextType::class, [
                    'label' => 'Titre',
                    'attr' => [
                        'placeholder' => 'Titre...'
                    ]
                ])
                ->add('image', FileType::class, array('data_class' => null), [
                    'label' => 'Ajouter un image',
                    'attr' => [
                        'placeholder' => 'Ajouter un image'
                    ]
                ])
                -> add ( 'contenu' , CKEditorType :: class , array (
                    'label' => 'contenue de l\'article',
                    'attr' => [
                        'placeholder' => 'Ajouter les contenue de l\'article'
                    ]

                ))
                ->add('lien', TextType::class, [
                    'label' => 'Ajouter un lien (image ou vidéo)',
                    'attr' => [
                        'placeholder' => 'url (exemple : https://www.monsite.com/image.png)'
                    ]
                ])
                ->add('save', SubmitType::class, array(
                    'label' => 'Modifier cet article'))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fileArticle = $form->get('image')->getData();
            $filename = md5(uniqid()) . '.' . $fileArticle->guessExtension();
            $fileArticle->move($this->getParameter('upload_directory'), $filename);
            $article->setImage($filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article');
        }
        return $this->render('article/update.html.twig', [
                    'form' => $form->createView(),
                    'article' => $article,
                    'current_menu' => 'articolos'
        ]);
    }

    /**
     * @param Article $article
     * @Route("/delete/article/{id}")
     * @return RedirectResponse
     */
    public function deleteArticle(Article $article) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('article');
    }

}
