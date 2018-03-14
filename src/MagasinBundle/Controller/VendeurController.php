<?php

namespace MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MagasinBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class VendeurController extends Controller
{



    public function vendeuraccAction(){

        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Vendeur') ;
        $emp=$em->findAll();
        if($emp){
            return $this->render('MagasinBundle:Default:vendeuracc.html.twig',array('emp'=> $emp,"name"=>$_SESSION['login']));
        }else{
            return $this->render('MagasinBundle:Default:vendeuracc.html.twig',array("error"=>"Pas de vendeur accepté!","name"=>$_SESSION['login']));
        }
    }

    public function vendeurattAction(){

        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\Vendeur') ;
        $emp=$em->findAll();
        if($emp){
            return $this->render('MagasinBundle:Default:vendeuratt.html.twig',array('emp'=> $emp,"name"=>$_SESSION['login']));
        }else{
            return $this->render('MagasinBundle:Default:vendeuratt.html.twig',array("error"=>"Pas de vendeur accepté!","name"=>$_SESSION['login']));
        }
    }




    public function supprimervacAction(Vendeur $employe)
    {

        if($_POST){
            $em= $this->getDoctrine()->getManager();
            $em->remove($employe);
            $em->flush();
            return $this->render('MagasinBundle:Default:vendeuracc.html.twig');
        }
        $nom=$employe->getNom();
        return $this->render('MagasinBundle:Default:supprimervac.html.twig',array("name"=>$_SESSION['login'],"nom"=>$nom));
    }


    public function supprimervatAction(Vendeur $employe)
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($employe);
        $em->flush();
        $nom=$employe->getNom();
        return $this->render('MagasinBundle:Default:supprimervat.html.twig',array("name"=>$_SESSION['login'],"nom"=>$nom));
    }

    public function acceptervatAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $employe = $em->getRepository('MagasinBundle\Entity\Vendeur')->find($id);
        $employe->setType("vendeuracc");
        $em->flush();
        $nom=$employe->getNom();
        return $this->render('MagasinBundle:Default:vendeuracc.html.twig',array("name"=>$_SESSION['login'],"nom"=>$nom));
    }




}