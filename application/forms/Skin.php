<?php

class Application_Form_Skin extends Pretty_Form
{
  var $options;
  var $render_type;

  public function __construct($render_type='default',$options = null){
    $this->options = $options;
    $this->render_type = $render_type;
    parent::__construct($this->options);

  }
  public function init(){


    parent::init($this->options);

    $this->setAction("/");
    $this->setMethod("POST");

    $this->addPrefixPath(
      'Pretty_Form_Decorator', 'Local/Form/Decorator/', 'decorator');

    // firstname
    $element = new Zend_Form_Element_Text('firstname');
    $element->setLabel('First Name');
    $element->setRequired(True);
    $element->getDecorator('Label')->setOption('requiredPrefix', ' * ');

    $this->addElement($element);

    // lastname
    $element = new Zend_Form_Element_Text('lastname');
    $element->setLabel('Last Name');
    $element->getDecorator('Label')->setOption('requiredPrefix', ' * ');
    $element->setRequired(True);
    $this->addElement($element);

    // submit
    $element = new Zend_Form_Element_Button('submit');
    $element->setAttrib('type','submit');
    $this->addElement($element);


    switch ($this->render_type){
      case "view_form":
        $this->set_view_form_decorations();
        break;
      case "decorated_form":
        $this->set_custom_decorations();
        break;
      default:
        break;
    }
  }

    
  function set_custom_decorations(){

    $input_decorators = Array(
      'ViewHelper',
      'Errors',
      Array('Label',Array('requiredPrefix'=>' * ')),
      Array(
        'HtmlTag',
        Array('tag'=>'div','class'=>"text-input")
            ));
    
    $this->getElement('firstname')->setDecorators($input_decorators);
    $this->getElement('lastname')->setDecorators($input_decorators);
    $this->getElement('submit')->setDecorators(Array('ViewHelper'));
    $this->setDecorators(
      Array(
        'FormElements',
        Array('HtmlTag',Array('tag'=>'div','class'=>'form')),
        'Form'
            ));
  }


  function set_view_form_decorations(){




    $this->getElement('firstname')->setDecorators($this->_viewErrorsDec);

    $this->getElement('lastname')->setDecorators($this->_viewErrorsDec);
    $this->getElement('submit')->setDecorators(Array('ViewHelper'));

    $this->smartSetDecorators();
  }
  


}
