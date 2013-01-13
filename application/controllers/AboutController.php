<?php

class AboutController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function contactAction(){
      $this->_helper->json("NOT IMPLEMENTED");
    }

    public function tosAction(){
      $this->_helper->json("NOT IMPLEMENTED");
    }


}

