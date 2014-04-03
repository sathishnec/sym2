<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => $name));
    }

    public function createAction()
    {
    	$product = new Product();
    	$product->setName('A Foo Bar');
    	$product->setPrice('19.99');
    	$product->setDescription('Lorem ipsum dolor');

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($product);
    	$em->flush();

    	return new Response('Created product id '.$product->getId());
    }

    public function showAction($id)
    {
    	
    	$product = $this->getDoctrine()
    					->getRepository('AcmeStoreBundle:Product')
    					->find($id);		
    	/*
    	$repository = $this->getDoctrine()
    					->getRepository('AcmeStoreBundle:Product');

		// query by the primary key (usually "id")
		$product = $repository->find($id);

		// dynamic method names to find based on a column value
		$product = $repository->findOneById($id);
		$product = $repository->findOneByName('foo');

		// find *all* products
		$products = $repository->findAll();

		// find a group of products based on an arbitrary column value
		$products = $repository->findByPrice(19.99);
		*/
    	if(!$product)
    	{
    		throw $this->createNotFoundException('No product found for id '.$id);
    	}

    	return $this->render('AcmeStoreBundle:Default:show.html.twig', array('product' => $product));
    }

    public function updateAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$product = $em->getRepository('AcmeStoreBundle:Product')->find($id);

    	if(!$product)
    	{
    		throw $this->createNotFoundException('No product found for id '.$id);
    	}

    	$product->setName('New Product name!');
    	$em->flush();

    	return $this->render('AcmeStoreBundle:Default:update.html.twig');
    }

    public function deleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$product = $em->getRepository('AcmeStoreBundle:Product')->find($id);

    	if(!$product)
    	{
    		throw $this->createNotFoundException('No product found for id '.$id);
    	}

    	$em->remove($product);
    	$em->flush();

    	return $this->render('AcmeStoreBundle:Default:delete.html.twig');
    }

    public function queryAction()
    {
    	/* 
    		//Querying for Objects Using Doctrine's Query Builder
    	$repository = $this->getDoctrine()->getRepository('AcmeStoreBundle:Product');
    	
    	$query = $repository->createQueryBuilder('p')
    			->where('p.price > :price')
    			->setParameter('price','19.99')
    			->orderBy('p.price','ASC')
    			->getQuery();
		*/

    	/*
    	$em = $this->getDoctrine()->getManager();

    	$query = $em->createQuery(
						    		'SELECT p
						    		FROM AcmeStoreBundle:Product p
						    		WHERE p.price > :price
						    		ORDER BY p.price ASC'
						    		)->setParameter('price','19.99');

    	$products = $query->getResult();

    	*/

    	$em = $this->getDoctrine()->getManager();
    	$products = $em->getRepository('AcmeStoreBundle:Product')
    				   ->findAllOrderedByName();



    	return $this->render('AcmeStoreBundle:Default:query.html.twig', array('products' => $products));
    }
}
