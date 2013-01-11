<?php

class IndexController extends Zend_Controller_Action
{

    public function init(){
      parent::init();
    }

    public function indexAction(){

      $post = $_POST;

      $default_form = new Application_Form_Skin();
      $this->view->default_form = $default_form;

      $decorated_form = new Application_Form_Skin('decorated_form');
      $this->view->decorated_form = $decorated_form;

      $view_form = new Application_Form_Skin('view_form');
      $this->view->view_form = $view_form;

      if(!$post){
        return;
      }
      
      // strange construct because we want to avoid lazy if
      // evaluations and run isValid for all 3 versions of the form
      $have_errors = !$default_form->isValid($post);
      $have_errors = !$decorated_form->isValid($post) and $have_errors;
      $have_errors = !$view_form->isValid($post) and $have_errors;

      if($have_errors){
        return;
      }
      
      // Do Something With the Data Here ...
      $values = $decorated_form->getValues();
    }


}

