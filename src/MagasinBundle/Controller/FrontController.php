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
            $ems= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Vendeur');
            $vendeur=$ems->findOneBy(array('email'=>$_POST['Email'],'password'=>$_POST['Password']));
            $ema= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
            $cat=$ema->findAll();
            if($user){
                $id=$user->getId();
                $type="client";
                $login=$user->getLogin();
                $_SESSION['login']=$login;
                $_SESSION['id']=$id;
                $_SESSION['type']=$type;
                return $this->render('MagasinBundle:Front:index.html.twig',array("cat"=>$cat,"name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"type"=>$_SESSION['type']));

            }
            if($vendeur){
                $id=$vendeur->getId();
                $type=$vendeur->getType();
                $login=$vendeur->getMagasin();
                $_SESSION['login']=$login;
                $_SESSION['id']=$id;
                $_SESSION['type']=$type;
                return $this->render('MagasinBundle:Front:index.html.twig',array("cat"=>$cat,"name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"type"=>$_SESSION['type']));
            }
            else{
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
            $article->setType("articleatt");
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

    public function produitAction()
    {
        $ems = $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie');
        $cat = $ems->findAll();
        if($_GET){

                $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article') ;
            $art=$em->findBy(array('categorie'=>$_GET['cat']));
            if(isset($_SESSION)) {
                if ($art) {
                    return $this->render('MagasinBundle:Front:produit.html.twig', array("ctg" => $_GET['cat'], "art" => $art, "cat" => $cat, "name" => $_SESSION['login'], "type" => $_SESSION['type'], "id" => $_SESSION['id']));
                } else {
                    return $this->render('MagasinBundle:Front:produit.html.twig', array("ctg" => $_GET['cat'], "error" => "Aucun produit pour le categorie", "cat" => $cat, "name" => $_SESSION['login'], "type" => $_SESSION['type'], "id" => $_SESSION['id']));
                }
            }else{
                if ($art) {
                    return $this->render('MagasinBundle:Front:produit.html.twig', array("ctg" => $_GET['cat'], "art" => $art, "cat" => $cat));
                } else {
                    return $this->render('MagasinBundle:Front:produit.html.twig', array("ctg" => $_GET['cat'], "error" => "Aucun produit pour le categorie", "cat" => $cat));
                }
            }
        }

    }

    public function errorAction()
    {
        return $this->render('MagasinBundle:Front:error.html.twig');

    }

    public function suppartAction(Article $article)
    {
        $ems= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$ems->findAll();
            $em= $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
            $nom=$article->getTitre();
            $id=$article->getId();
            return $this->render('MagasinBundle:Front:suppart.html.twig',array("cat"=>$cat,"type"=>$_SESSION['type'],"id"=>$id,"name"=>$_SESSION['login'],"nom"=>$nom));

    }

    public function commandeAction()
    {
        if(isset($_SESSION['type'])){
            $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
            $cat=$em->findAll();
            if($_SESSION['type']=="vendeur"){
                $ems= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Vendeur') ;
            }
            else{$ems= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Vendeur') ;}
            $user=$ems->findByid($_SESSION{'id'});
            if(isset($_POST["w3ls_item_1"])){
                $arts[0]=array('titre'=>$_POST["w3ls_item_1"],'prix'=>$_POST["amount_1"],'qte'=>$_POST["quantity_1"]);
            }
            if(isset($_POST["w3ls_item_2"])){
                $arts[1]=array('titre'=>$_POST["w3ls_item_2"],'prix'=>$_POST["amount_2"],'qte'=>$_POST["quantity_2"]);
            }
            if(isset($_POST["w3ls_item_3"])){
                $arts[2]=array('titre'=>$_POST["w3ls_item_3"],'prix'=>$_POST["amount_3"],'qte'=>$_POST["quantity_3"]);
            }
            if(isset($_POST["w3ls_item_4"])){
                $arts[3]=array('titre'=>$_POST["w3ls_item_4"],'prix'=>$_POST["amount_4"],'qte'=>$_POST["quantity_4"]);
            }
            if(isset($_POST["w3ls_item_5"])){
                $arts[4]=array('titre'=>$_POST["w3ls_item_5"],'prix'=>$_POST["amount_5"],'qte'=>$_POST["quantity_5"]);
            }
            if(isset($_POST["w3ls_item_6"])){
                $arts[5]=array('titre'=>$_POST["w3ls_item_6"],'prix'=>$_POST["amount_6"],'qte'=>$_POST["quantity_6"]);
            }
            if(isset($_POST["w3ls_item_7"])){
                $arts[6]=array('titre'=>$_POST["w3ls_item_7"],'prix'=>$_POST["amount_7"],'qte'=>$_POST["quantity_7"]);
            }
            $_SESSION['arts']=$arts;
            return $this->render('MagasinBundle:Front:commande.html.twig',array('arts'=>$arts,'user'=>$user,'cat'=> $cat,"name"=>$_SESSION['login'],"type"=>$_SESSION['type'],"id"=>$_SESSION['id']));


        }
        else
        {        return $this->render('MagasinBundle:Front:connexion.html.twig');
        }
    }




}



