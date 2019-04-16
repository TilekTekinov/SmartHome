<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller {
    /**
     * @Route("/base", name="base")
     */

    public function baseAction()
    {
      return $this->render('temp/base.html.twig', array(       
        ));
    }
}