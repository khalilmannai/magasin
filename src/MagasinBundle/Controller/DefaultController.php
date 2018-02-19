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
            $user=$em->findOneBy(array('login'=>$_POST['Pseudo'],'password'=>$_POST['Password']));
            if($user){
                $_SESSION['login']=$_POST['Pseudo'];
                return $this->render('MagasinBundle:Default:adminhome.html.twig',array("name"=>$_SESSION['login']));
                
            }else{
                return $this->render('MagasinBundle:Default:admin.html.twig',array("error"=>" login Incorrect !"));
            }
        }else{
            return $this->render('MagasinBundle:Default:admin.html.twig');
        }    }
    public function adminhomeAction()
    {
        return $this->render('MagasinBundle:Default:adminhome.html.twig',array("name"=>$_SESSION['login']));
    }



}
