<?php


class Pretty_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract 
{

  public function routeShutdown(Zend_Controller_Request_Abstract $request)
  {

    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();
    $route_name = Zend_Controller_Front::getInstance()
      ->getRouter()
      ->getCurrentRouteName();


    $acl = Zend_Registry::get('acl');
    $role = Zend_Registry::get('session')->role;

    //echo "\n\n$module - $controller - $action - $route_name - $role\n\n";

    if(!$acl->isAllowed($role,$route_name)){
      die("DENY");
    }

  }
  
}
