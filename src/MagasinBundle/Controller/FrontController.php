<?php

namespace MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MagasinBundle\Entity\Categorie;
use MagasinBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class FrontController extends Controller
{
    public function indexAction()
    {
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        if(isset($_SESSION['login'])){
            return $this->render('MagasinBundle:Front:index.html.twig',array('cat'=> $cat,"name"=>$_SESSION['login'],"id"=>$_SESSION['id']));
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
                $login=$user->getLogin();
                $_SESSION['login']=$login;
                $_SESSION['id']=$id;
                return $this->render('MagasinBundle:Front:index.html.twig',array("name"=>$_SESSION['login'],"id"=>$_SESSION['id']));

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
                return $this->render('MagasinBundle:Front:index.html.twig',array("name"=>$_SESSION['login'],"id"=>$_SESSION['id']));
            }
            else{
                return $this->render('MagasinBundle:Front:modifierprofile.html.twig',array("cat"=>$cat,"name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"us"=>$us,"error"=>"Mot de passe incorrect !"));
            }
        }


        return $this->render('MagasinBundle:Front:modifierprofile.html.twig',array("cat"=>$cat,"name"=>$_SESSION['login'],"id"=>$_SESSION['id'],"us"=>$us));

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
            $user->setType($_POST['type']);
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

}



