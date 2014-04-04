<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Acme\StoreBundle\Entity\Author;


class ValidationController extends Controller
{
	public function indexAction()
	{
		$author = new Author();

		$author->setName('');

		$em = $this->getDoctrine()->getManager();
		$em->persist($author);
		$em->flush();

		$validator = $this->get('validator');
		$errors = $validator->validate($author);

		if(count($errors)>0)
		{
			$errorString = (string) $errors;

			return new Response($errorString);
		}

		return new Response('The author is valid! Yay!!!');
	}
}