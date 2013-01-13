<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initAutoload(){
    
    // Use library/Local functions
    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->registerNamespace('Pretty_');
    new Zend_Application_Module_Autoloader(
      array(
        'namespace' => 'admin',
        'basePath'  => APPLICATION_PATH . '/modules/admin'
            ));
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


  protected function _initRoute(){

    $front = Zend_Controller_Front::getInstance();
    $router = $front->getRouter();
    $router->addRoute(
      'home',
      new Zend_Controller_Router_Route(
        '/',
        Array(
          'module' => "default",
          'controller' => 'index',
          'action' => 'index'))
                      );

    $router->addRoute(
      'about',
      new Zend_Controller_Router_Route(
        '/about',
        Array(
          'module' => "default",
          'controller' => 'about',
          'action' => 'index'))
                      );


    $router->addRoute(
      'contact',
      new Zend_Controller_Router_Route(
        '/contact',
        Array(
          'module' => "default",
          'controller' => 'about',
          'action' => 'contact'))
                      );

    $router->addRoute(
      'tos',
      new Zend_Controller_Router_Route(
        '/tos',
        Array(
          'module' => "default",
          'controller' => 'about',
          'action' => 'tos'))
                      );


    $router->addRoute(
      'tools',
      new Zend_Controller_Router_Route(
        '/tools',
        Array(
          'module' => "default",
          'controller' => 'tools',
          'action' => 'index'))
                      );

    $router->addRoute(
      'free-tools',
      new Zend_Controller_Router_Route(
        '/tools/free',
        Array(
          'module' => "default",
          'controller' => 'tools',
          'action' => 'free'))
                      );

    $router->addRoute(
      'new-licenses',
      new Zend_Controller_Router_Route(
        '/tools/licenses',
        Array(
          'module' => "default",
          'controller' => 'tools',
          'action' => 'new-licenses'))
                      );


    $router->addRoute(
      'admin-home',
      new Zend_Controller_Router_Route(
        '/admin/home',
        Array(
          'module' => "admincp",
          'controller' => "home",
          'action' => 'index'))
                      );

    $router->addRoute(
      'adduser',
      new Zend_Controller_Router_Route(
        '/admin/adduser',
        Array(
          'module' => "admincp",
          'controller' => "home",
          'action' => 'add-user'))
                      );

    $router->addRoute(
      'addpage',
      new Zend_Controller_Router_Route(
        '/admin/addpage',
        Array(
          'module' => "admincp",
          'controller' => "home",
          'action' => 'add-page'))
                      );


    $front->getRouter()->addDefaultRoutes();

  }



  protected function _initAcl(){
    $acl = new Zend_Acl();
    $acl->addRole(new Zend_Acl_Role('guest'))
      ->addRole(new Zend_Acl_Role('member'),'guest')
      ->addRole(new Zend_Acl_Role('admin'),'member');

    
    $acl->add(new Zend_Acl_Resource('home'));
    $acl->allow('guest','home');

    $acl->add(new Zend_Acl_Resource('about'));
    $acl->allow('guest','about');

    $acl->add(new Zend_Acl_Resource('contact'));
    $acl->allow('guest','contact');

    $acl->add(new Zend_Acl_Resource('tos'));
    $acl->allow('guest','tos');


    $acl->add(new Zend_Acl_Resource('tools'));
    $acl->allow('guest','tools');

    $acl->add(new Zend_Acl_Resource('new-licenses'));
    $acl->allow('guest','new-licenses');


    $acl->add(new Zend_Acl_Resource('free-tools'));
    $acl->allow('member','free-tools');
    
    $acl->add(new Zend_Acl_Resource('admin'));
    $acl->deny('member','admin');
    $acl->allow('admin','admin');

    $acl->add(new Zend_Acl_Resource('admin-home'));
    $acl->deny('member','admin-home');
    $acl->allow('admin','admin-home');

    $acl->add(new Zend_Acl_Resource('adduser'));
    $acl->deny('member','adduser');
    $acl->allow('admin','adduser');

    $acl->add(new Zend_Acl_Resource('addpage'));
    $acl->deny('member','addpage');
    $acl->allow('admin','addpage');


    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Pretty_Controller_Plugin_Acl());    

    Zend_Registry::set('acl',$acl);

  }


  protected function _initNav(){
    $router = Zend_Controller_Front::getInstance()->getRouter();

    $navArray = array(
      array(
        'route'=>'home',
        'label' => 'Home',
            ),
      array(
        'label' => 'About',
        'resource' => 'about',
        'route' => 'about',
        'pages' => array(
          array(
            'route' => 'contact',
            'label' => 'Contact',
                ),
          array(
            'route' => 'tos',
            'label' => 'Terms of Service',
                ),
                         ),
            ),
      array(
        'route' => 'tools',
        'label' => 'Tools',
        'resource'=>'tools',
        'pages' => array(
          array(
            'route' => 'free-tools',
            'resource'=>'free-tools',
            'label' => 'Free Tools',
                ),
          array(
            'route' => 'new-licenses',
            'label' => 'New Licenses',
                ),
                         ),
            ),
      array(
        'module' => 'default',
        'label' => 'Administration',
        'route' => 'admin-home',
        'resource' => 'admin-home',
        'privilege' => 'index',
        'pages' => array(
          array(
            'route' => 'adduser',
            'label' => 'Add User',
            'resource' => 'admin',
            'privilege' => 'adduser',
                ),
          array(
            'route' => 'addpage',
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

