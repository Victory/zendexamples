<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initAutoload(){
    
    // Use library/Local functions
    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->registerNamespace('Pretty_');
  }


}

