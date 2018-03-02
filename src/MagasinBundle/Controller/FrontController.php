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
        return $this->render('MagasinBundle:Front:index.html.twig',array('cat'=> $cat));
    }


    public function connexionAction()
    {
        $em= $this->getDoctrine()->getRepository('MagasinBundle\Entity\User') ;
        $cat=$em->findAll();
        return $this->render('MagasinBundle:Front:connexion.html.twig');
    }

}



