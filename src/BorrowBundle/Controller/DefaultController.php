<?php

namespace BorrowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
    	var_dump('index');
        return $this->render('BorrowBundle:Default:index.html.twig');
    }
}
