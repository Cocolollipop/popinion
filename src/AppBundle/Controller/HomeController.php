<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
	/**
     * @Route("/home", name="homepage")
     */
    public function homeAction()
    {
        // replace this example code with whatever you need

        
        return $this->render('accueil/pageAccueil.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/medecins-sans-frontieres", name="medecinsf")
     */
    public function medecinAction()
    {
        // replace this example code with whatever you need
        return $this->render('accueil/medecins-sans-frontieres.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/france-nature-environnement", name="francenature")
     */
    public function francenatureenvironnementAction()
    {
        // replace this example code with whatever you need
        return $this->render('accueil/france-nature-environnement.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

}
