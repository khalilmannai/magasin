<?php

namespace MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MagasinBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MagasinBundle:Default:index.html.twig');
    }
    public function adminAction(){
        if (!isset($_SESSION))
        {
            session_start();
        }
        session_destroy();
        if($_POST){
            session_start();
            $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Admin');
            $ems=$this->getDoctrine()->getRepository('MagasinBundle\Entity\User');
            $user=$em->findOneBy(array('login'=>$_POST['Pseudo'],'password'=>$_POST['Password']));
            $logi=$ems->findOneBy(array('login'=>$_POST['Pseudo'],'password'=>$_POST['Password']));
            if($user){
                $_SESSION['login']=$_POST['Pseudo'];
                $_SESSION['type']="admin";
                return $this->render('MagasinBundle:Default:adminhome.html.twig',array("name"=>$_SESSION['login']));
                
            }elseif ($logi){
                $_SESSION['login']=$_POST['Pseudo'];
                $_SESSION['type']="logisticien";
                $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article') ;
                $art=$em->findAll();
                return $this->render('MagasinBundle:Default:article.html.twig',array("art"=>$art,"name"=>$_SESSION['login']));
            }
            else{
                return $this->render('MagasinBundle:Default:admin.html.twig',array("error"=>" login Incorrect !"));
            }
        }else{
            return $this->render('MagasinBundle:Default:admin.html.twig');
        }    }
    public function adminhomeAction()
    {
        if(isset($_SESSION)){
        if($_SESSION['type']=="admin" ){
        return $this->render('MagasinBundle:Default:adminhome.html.twig',array("name"=>$_SESSION['login']));
        }
        else
        {return $this->render('MagasinBundle:Front:error.html.twig');}
        }
        else{return $this->render('MagasinBundle:Front:error.html.twig');}
    }



}
