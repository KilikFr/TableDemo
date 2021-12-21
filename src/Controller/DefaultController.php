<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="tabledemo_index")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', []);
    }
}
