<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
  
  public function setUp(){
    $this->bootstrap = new Zend_Application(
      APPLICATION_ENV, 
      APPLICATION_PATH . '/configs/application.ini');
    parent::setUp();
  }
  
  public function testHaveAllFormsAction(){
    $params = Array(
      'action' => 'index', 
      'controller' => 'Index', 
      'module' => 'default');

    $urlParams = $this->urlizeOptions($params);
    $url = $this->url($urlParams);
    $this->dispatch($url);
    
    // assertions
    $this->assertModule($urlParams['module']);
    $this->assertController($urlParams['controller']);
    $this->assertAction($urlParams['action']);
    $this->assertQueryContentContains("div#default-form h2", "Default");
    $this->assertQuery("div#default-form form");

    $this->assertQueryContentContains("div#decorated-form h2", "Decorated Form");
    $this->assertQueryContentContains("div#view-form h2", "View Form");

  }
  
  public function testGoodPostQuery(){

    $params = Array(
      'action' => 'index', 
      'controller' => 'Index', 
      'module' => 'default');

    $this->request->setMethod('POST');
    $this->request->setPost(
      array(
        'firstname'  => 'foo',
        'lastname' => 'bar',
            ));
    
    $urlParams = $this->urlizeOptions($params);
    $url = $this->url($urlParams);
    $this->dispatch($url);
    
    $this->assertQuery("div#default-form input[name='firstname']");
    
  }


  public function testBadPostQuery(){

    $params = Array(
      'action' => 'index', 
      'controller' => 'Index', 
      'module' => 'default');

    $this->request->setMethod('POST');
    $this->request->setPost(
      array(
        'firstname'  => 'foo',
            ));
    
    $urlParams = $this->urlizeOptions($params);
    $url = $this->url($urlParams);
    $this->dispatch($url);
    
    $this->assertQuery("div#default-form input[name='firstname']");
    
  }

}


