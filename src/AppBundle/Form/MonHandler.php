<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Survey;

class MonHandler

{

protected $em;                        // ici c’est notre entityManager qui gère la persistance de notre objet dans notre base

protected $form;                  // ici c’est notre formulaire qui contient notre objet à hydrater

protected $request;           // ici c’est notre requête qui contient nos données

public function __constructor( Form $form, EntityManager $em, Request $request)

{

$this->form = $form;

$this->em = $em;

$this->request = $request;

}

public function process()

{

if($this->request->getMethod() == ‘POST’)                  // vous pouvez remplacer par le Méthod http GET ^^

{

$this->form->bindRequest($this->request);  // on bind notre requête dans notre formulaire pour « hydrater » notre objet

if($this->form->isValid())                                      // le formulaire est bien valide == true

{

$this->onSuccess($this->form->getData())  // je vais persister l’objet ou effectuer un action sur celui-ci dans la méthode onSuccess()

return true;

}

return false;

}

public function onSuccess(MonEntity $entity)

{

$this->em->persist($entity);                      // ici on va ajouter notre objet à la base de données

$this->em->flush();                                          // ici on va rafraîchir la base ou actualisez pour valider nos ajout et modification;

}

}

?>