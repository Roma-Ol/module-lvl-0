<?php

namespace Drupal\romaroma\Controller;

use Drupal\Core\Controller\ControllerBase;

class FirstPageController extends ControllerBase{

  protected $formBuilder;

  public function build() {
    $form = $this->formBuilder->getForm('Drupal\romaroma\Form\FormCats');
    return $form;
  }
}