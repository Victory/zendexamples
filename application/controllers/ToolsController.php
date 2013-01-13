<?php

class ToolsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function newLicensesAction(){
      $this->_helper->json("NOT IMPLEMENTED");
    }

    public function freeAction(){
      $this->_helper->json("NOT IMPLEMENTED");
    }


}

