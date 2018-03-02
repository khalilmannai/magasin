<?php

namespace MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MagasinBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class FrontController extends Controller
{
    public function indexAction()
    {
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        if(isset($_SESSION['login'])){
            return $this->render('MagasinBundle:Front:index.html.twig',array('cat'=> $cat,"name"=>$_SESSION['login']));
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
                $login=$user->getLogin();
                $_SESSION['login']=$login;
                return $this->render('MagasinBundle:Front:index.html.twig',array("name"=>$_SESSION['login']));

            }else{
                return $this->render('MagasinBundle:Front:connexion.html.twig',array("error"=>" login Incorrect !"));
            }
        }
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        return $this->render('MagasinBundle:Front:connexion.html.twig',array("cat"=>$cat));

    }

}



