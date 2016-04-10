<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SurveyController extends Controller
{
	
     public function addAction(Request $request)
  {
    $advert = new Advert();
    $form = $this->get('form.factory')->create(new AdvertType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
    }

    return $this->render('AppBundle:Survey:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }
   

}
