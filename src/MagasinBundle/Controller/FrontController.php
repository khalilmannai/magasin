<?php

namespace MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MagasinBundle\Entity\Categorie;
use MagasinBundle\Entity\User;
use MagasinBundle\Entity\Article;
use MagasinBundle\Entity\Vendeur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class FrontController extends Controller
{
    public function indexAction()
    {
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        if(isset($_SESSION['login'])){
            return $this->render('MagasinBundle:Front:index.html.twig',array('cat'=> $cat,"name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"type"=>$_SESSION['type']));
        }
        return $this->render('MagasinBundle:Front:index.html.twig',array('cat'=> $cat));
    }


    public function connexionAction()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
        session_destroy();
        if($_POST){
            session_start();
            $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\User');
            $user=$em->findOneBy(array('email'=>$_POST['Email'],'password'=>$_POST['Password']));
            if($user){
                $id=$user->getId();
                $type=$user->getType();
                $login=$user->getLogin();
                $_SESSION['login']=$login;
                $_SESSION['id']=$id;
                $_SESSION['type']=$type;
                return $this->render('MagasinBundle:Front:index.html.twig',array("name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"type"=>$_SESSION['type']));

            }else{
                return $this->render('MagasinBundle:Front:connexion.html.twig',array("error"=>" login Incorrect !"));
            }
        }
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        return $this->render('MagasinBundle:Front:connexion.html.twig',array("cat"=>$cat));

    }



    public function modifierprofileAction($id)
    {
        $ems = $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie');
        $cat = $ems->findAll();
        $emx = $this->getDoctrine()->getRepository('MagasinBundle\Entity\User');
        $us=$emx->findByid($id);
        $type=$us[0]->getType();
        if ($_POST) {
            $em = $this->getDoctrine()->getManager();
            $profile = $em->getRepository('MagasinBundle\Entity\User')->find($id);
            $profile->setNom($_POST['nom']);
            $profile->setPrenom($_POST['prenom']);
            $profile->setEmail($_POST['email']);
            $profile->setTel($_POST['tel']);
            $profile->setAdresse($_POST['adresse']);
            $profile->setLogin($_POST['login']);
            $profile->setPassword($_POST['password']);
            $profile->setType($type);
            if($_POST['oldpassword']==$us[0]->getPassword()){
                $em->flush();
                return $this->render('MagasinBundle:Front:index.html.twig',array("name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"type"=>$_SESSION['type']));
            }
            else{
                return $this->render('MagasinBundle:Front:modifierprofile.html.twig',array("cat"=>$cat,"name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"type"=>$_SESSION['type'],"us"=>$us,"error"=>"Mot de passe incorrect !"));
            }
        }


        return $this->render('MagasinBundle:Front:modifierprofile.html.twig',array("cat"=>$cat,"name"=>$_SESSION['login'],"type"=>$_SESSION['type'],"id"=>$_SESSION['id'],"us"=>$us));

    }


    public function inscriptionAction()
    {
        if($_POST){
            $em=$this->getDoctrine()->getManager();
            $user= new User();
            $user->setNom($_POST['nom']);
            $user->setPrenom($_POST['prenom']);
            $user->setAdresse($_POST['adresse']);
            $user->setTel($_POST['tel']);
            $user->setEmail($_POST['email']);
            $user->setLogin($_POST['login']);
            $user->setPassword($_POST['password']);
            $user->setType("client");
            $ema= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
            $cat=$ema->findAll();
            $ems= $this->getDoctrine()->getRepository('MagasinBundle\Entity\User') ;
            $us= $ems->findOneBy(array('email'=>$_POST['email']));
            if($us){
                return $this->render('MagasinBundle:Front:inscription.html.twig',array('cat'=> $cat,'error'=>"Cette adresse e-mail est déjà utilisé. Essayez un autre adresse.!"));
            }else{
                $em->persist($user);
                $em->flush();
                return $this->render('MagasinBundle:Front:inscription.html.twig',array('cat'=> $cat,'ok'=>"inscription effectuée, vous pouvez se connecter ."));
            }
        }
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        return $this->render('MagasinBundle:Front:inscription.html.twig',array("cat"=>$cat));

    }


    public function ajoutarticleAction()
    {
        if($_POST){
            $em=$this->getDoctrine()->getManager();
            $article= new Article();
            $article->setTitre($_POST['titre']);
            $article->setDescription($_POST['description']);
            $article->setCategorie($_POST['categorie']);
            $article->setQuantite($_POST['quantite']);
            $article->setPrix($_POST['prix']);
            $article->setImage($_POST['image']);
            $article->setIdvendeur($_SESSION['id']);
            $em->persist($article);
            $em->flush();
            $ema= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
            $cat=$ema->findAll();
            return $this->render('MagasinBundle:Front:ajoutarticle.html.twig',array('cat'=> $cat,'ok'=>"Merci! Votre annonce va être vérifiée par nos modérateurs et sera bientôt en ligne.","name"=>$_SESSION['login'],"type"=>$_SESSION['type'],"id"=>$_SESSION['id']));
        }
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        return $this->render('MagasinBundle:Front:ajoutarticle.html.twig',array('cat'=> $cat,"name"=>$_SESSION['login'],"type"=>$_SESSION['type'],"id"=>$_SESSION['id']));

    }
    public function devenirvendeurAction()
    {
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        return $this->render('MagasinBundle:Front:devenirvendeur.html.twig',array('cat'=> $cat));
    }

    public function inscrivendeurAction()
    {
        if($_POST){
            $em=$this->getDoctrine()->getManager();
            $user= new Vendeur();
            $user->setNom($_POST['nom']);
            $user->setPrenom($_POST['prenom']);
            $user->setAdresse($_POST['adresse']);
            $user->setTel($_POST['tel']);
            $user->setEmail($_POST['email']);
            $user->setMagasin($_POST['magasin']);
            $user->setPassword($_POST['password']);
            $user->setType("vendeuratt");
            $ema= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
            $cat=$ema->findAll();
            $ems= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Vendeur') ;
            $us= $ems->findOneBy(array('email'=>$_POST['email']));
            if($us){
                return $this->render('MagasinBundle:Front:inscrivendeur.html.twig',array('cat'=> $cat,'error'=>"Cette adresse e-mail est déjà utilisé. Essayez un autre adresse.!"));
            }else{
                $em->persist($user);
                $em->flush();
                return $this->render('MagasinBundle:Front:inscrivendeur.html.twig',array('cat'=> $cat,'ok'=>"inscription effectuée, vous pouvez se connecter ."));
            }
        }
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        return $this->render('MagasinBundle:Front:inscrivendeur.html.twig',array("cat"=>$cat));
    }

    public function mesarticlesAction()
    {
        $ems = $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie');
        $cat = $ems->findAll();
        $em = $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article');
        $art=$em->findBy(array('idvendeur'=>$_SESSION['id']));
        if($art){
        return $this->render('MagasinBundle:Front:mesarticles.html.twig',array("art"=>$art,"cat"=>$cat,"name"=>$_SESSION['login'],"type"=>$_SESSION['type'],"id"=>$_SESSION['id']));
        }
        else{
            return $this->render('MagasinBundle:Front:mesarticles.html.twig',array("error"=>"Pas d'articles !","cat"=>$cat,"name"=>$_SESSION['login'],"type"=>$_SESSION['type'],"id"=>$_SESSION['id']));
        }
    }


}



