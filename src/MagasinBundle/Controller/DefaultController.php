<?php

namespace MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MagasinBundle:Default:index.html.twig');
    }
    public function adminAction(){
        return $this->render('MagasinBundle:Default:admin.html.twig');
    }
}
