<?php

namespace MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MagasinBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



class ArticleController extends Controller
{



    public function articleAction(){

            $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article') ;
            $art=$em->findAll();
            if($art){
                return $this->render('MagasinBundle:Default:article.html.twig',array('art'=> $art,"name"=>$_SESSION['login']));
            }else{
                return $this->render('MagasinBundle:Default:article.html.twig',array("error"=>"Pas d'article!","name"=>$_SESSION['login']));
            }

        return $this->render('MagasinBundle:Default:article.html.twig',array("name"=>$_SESSION['login']));


    }

    public function modifierartAction($id)
    {

        if ($_POST) {
            $em = $this->getDoctrine()->getManager();
            $article = $em->getRepository('MagasinBundle\Entity\Article')->find($id);
            $article->setTitre($_POST['titre']);
            $article->setCategorie($_POST['categorie']);
            $article->setPrix($_POST['prix']);
            $article->setQuantite($_POST['quantite']);
            $article->setDescription($_POST['description']);
            $article->setImage($_POST['image']);
            $em->flush();

        }

        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article') ;
        $ems= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cats=$ems->findAll();
        $art=$em->findByid($id);
        $nom=$art[0]->getTitre();
        $desc=$art[0]->getDescription();
        $prix=$art[0]->getPrix();
        $img=$art[0]->getImage();
        $qt=$art[0]->getQuantite();
        $cat=$art[0]->getCategorie();



        return $this->render('MagasinBundle:Default:modifierart.html.twig',array("cat"=>$cats,"name"=>$_SESSION['login'],"nom"=>$nom,"desc"=>$desc,"prix"=>$prix,"img"=>$img,"cats"=>$cat,"qt"=>$qt));


    }

    public function supprimerartAction(Article $article)
    {


        $em= $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        $nom=$article->getTitre();
        $id=$article->getId();
        return $this->render('MagasinBundle:Default:supprimerart.html.twig',array("id"=>$id,"name"=>$_SESSION['login'],"nom"=>$nom));
    }



}