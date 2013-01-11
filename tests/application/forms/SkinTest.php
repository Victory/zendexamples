<?php

class Form_SkinTest extends PHPUnit_Framework_TestCase
{
  public function testCanCreateForm(){
    $form = new  Application_Form_Skin();
    $this->assertInstanceOf('Application_Form_Skin',$form);
  }

  public function testHaveElements(){
    $form = new Application_Form_Skin();
    $this->assertInstanceOf(
      'Zend_Form_Element_Text',
      $form->getElement('firstname'));

    $this->assertInstanceOf(
      'Zend_Form_Element_Text',
      $form->getElement('lastname'));


    $this->assertInstanceOf(
      'Zend_Form_Element_Button',
      $form->getElement('submit'));

  }

}