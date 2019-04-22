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
        $emm= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Mail');
        $msg=$emm->findAll();
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
            $emk= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article');
            $arts=$emk->findAll();
            $x=0;
            foreach ($arts as $c){
                $x=$x+1;
            }
            $x=($x*100)/1000;
            if($user){
                $_SESSION['login']=$_POST['Pseudo'];
                $_SESSION['type']="admin";
                return $this->render('MagasinBundle:Default:adminhome.html.twig',array("nb"=>$x,"msg"=>$msg,"name"=>$_SESSION['login']));
                
            }elseif ($logi){
                $_SESSION['login']=$_POST['Pseudo'];
                $_SESSION['type']="logisticien";
                $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article') ;
                $art=$em->findAll();
                return $this->render('MagasinBundle:Default:articleatt.html.twig',array("nb"=>$x,"art"=>$art,"name"=>$_SESSION['login']));
            }
            else{
                return $this->render('MagasinBundle:Default:admin.html.twig',array("error"=>" login Incorrect !"));
            }
        }else{
            return $this->render('MagasinBundle:Default:admin.html.twig');
        }    }
    public function adminhomeAction()
    {
        $emm= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Mail');
        $msg=$emm->findAll();
        $emk= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Article');
        $arts=$emk->findAll();
        $x=0;
        foreach ($arts as $c){
            $x=$x+1;
        }
        $x=($x*100)/1000;
        if(isset($_SESSION)){
        if($_SESSION['type']=="admin" ){
        return $this->render('MagasinBundle:Default:adminhome.html.twig',array("nb"=>$x,"msg"=>$msg,"name"=>$_SESSION['login']));
        }
        else
        {return $this->render('MagasinBundle:Front:error.html.twig');}
        }
        else{return $this->render('MagasinBundle:Front:error.html.twig');}
    }
    public function mailAction()
    {
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Categorie') ;
        $cat=$em->findAll();
        if($_GET){
            $emm= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Mail');
            $msg=$emm->find($_GET['x']);
            return $this->render('MagasinBundle:Default:mail.html.twig',array('message'=>$msg,'cat'=> $cat,"name"=>$_SESSION['login']));

        }
        return $this->render('MagasinBundle:front:error.html.twig');
    }



}
