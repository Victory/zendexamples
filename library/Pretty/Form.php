<?php

class Pretty_Form extends Zend_Form {


  protected $_hiddenElementDecorator = Array(
    'ViewHelper',
    Array("Errors",
          Array("placement"=>'prepend')));
  
  protected $_viewErrorsDec = Array(
    'ViewHelper','Errors'
                                    );
  
  protected $_formViewScriptDec = Array(
    Array(
      'ViewScript', 
      Array(
        'viewScript' => 'forms/',
        'viewModule'=>'frontend'),
      'Form'));
  
  function __construct($options = null){
    parent::__construct($options);
  }
  
  function init($options = null){
    parent::init($options);
  }

  function smartSetDecorators($form=False,$module="default"){
    $cls = get_class($this);
    $bits = explode("_",$cls);
    $phtml_name = "_" . array_pop($bits) . ".phtml";
    $this->_formViewScriptDec[0][1]['viewScript'] .= $phtml_name;
    $this->_formViewScriptDec[0][1]['viewModule'] = $module;

    $this->setDecorators($this->_formViewScriptDec);
  }

}