<?php

namespace Acme\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\TaskBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeTaskBundle:Default:index.html.twig', array('name' => $name));
    }

    public function newAction(Request $request)
    {
    	$task = new Task();
    	$task->setTask('Write a blog post');
    	$task->setDueDate(new \DateTime('tomorrow'));

    	$form = $this->createFormBuilder($task)
    			->add('task','text', array('max_length'=>4))
    			->add('dueDate','date', array(
    										  'widget'=>'single_text',
    										  'label'=>'Due Date',

    										  ))
    			->add('save','submit')
    			->add('saveAndAdd','submit')
    			->getForm();

    	$form->handleRequest($request);

    	if($form->isValid())
    	{
    		$nextAction = $form->get('saveAndAdd')->isClicked()
    					? 'acme_task_new'
    					: 'acme_task_success';

    		return $this->redirect($this->generateUrl($nextAction));
    	}

    	return $this->render('AcmeTaskBundle:Default:new.html.twig', array(
    			'form'=>$form->createView()
    		));
    }

    public function successAction()
    {
    	return $this->render('AcmeTaskBundle:Default:success.html.twig');
    }
}
