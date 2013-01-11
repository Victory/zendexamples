<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initAutoload(){
    
    // Use library/Local functions
    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->registerNamespace('Pretty_');
  }

  protected function _initSession(){
     $session = new Zend_Session_Namespace();
     Zend_Registry::set('session',$session);
  }

  protected function _initUser(){

    $session = Zend_Registry::get('session');

    if(!isset($session->role)){
      $session->role = "guest"; 
    }
    
    if(isset($_GET['role'])){
      $role = $_GET['role']; 
      $session->role = $role;
    }

    $user = (object)Array(
      "role"=>$session->role);

    Zend_Registry::set('user',$user);
  }

  protected function _initAcl(){
    $acl = new Zend_Acl();
    $acl->addRole(new Zend_Acl_Role('guest'))
      ->addRole(new Zend_Acl_Role('member'),'guest')
      ->addRole(new Zend_Acl_Role('admin'),'member');
    
    $acl->add(new Zend_Acl_Resource('admin'));
    $acl->deny('member','admin');
    $acl->allow('admin','admin');

    Zend_Registry::set('acl',$acl);
  }

  protected function _initNav(){


    $navArray = array(
      array(
        'controller' => 'index',
        'label' => 'Home',
        'action' => 'index'
            ),
      array(
        'controller' => 'about',
        'label' => 'About',
        'pages' => array(
          array(
            'controller' => 'about',
            'action' => 'contact',
            'label' => 'Contact',
                ),
          array(
            'controller' => 'about',
            'action' => 'tos',
            'label' => 'Terms of Service',
                ),
                         ),
            ),
      array(
        'controller' => 'tools',
        'label' => 'Tools',
        'pages' => array(
          array(
            'controller' => 'tools',
            'action' => 'free',
            'label' => 'Free Tools',
                ),
          array(
            'controller' => 'tools',
            'action' => 'licenses',
            'label' => 'New Licenses',
                ),
          array(
            'controller' => 'tools',
            'action' => 'products',
            'label' => 'Products',
                ),
                         ),
            ),
      array(
        'module' => 'admin',
        'label' => 'Administration',
        'resource' => 'admin',
        'privilege' => 'index',
        'pages' => array(
          array(
            'module' => 'admin',
            'controller' => 'adduser',
            'label' => 'Add User',
            'resource' => 'admin',
            'privilege' => 'adduser',
                ),
          array(
            'module' => 'admin',
            'controller' => 'addpage',
            'label' => 'Add Page',
            'resource' => 'admin',
            'privilege' => 'addpage',
                ),
                         ),
            )
                      );
    
    $config = new Zend_Config($navArray);
    $nav = new Zend_Navigation();
    $nav->addPages($config);
    $acl = Zend_Registry::get('acl');

    $view = Zend_Layout::startMvc()->getView();
    $view->navigation()
      ->setAcl($acl)
      ->setRole(Zend_Registry::get('user')->role);
    $view->navigation($nav); 
  }

}

