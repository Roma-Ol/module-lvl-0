<?php

namespace Drupal\romaroma\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FormMain.
 *
 * Works w/ this specific class.
 *
 * @package Drupal\romaroma\Form
 */

class FormMain extends FormBase{
  /**
   * Does a specific functional.
   *
   * @return string.
   */
  public function getFormId() {
    return 'FormMain';
  }

  /**
  * @inheritdoc.
   * name \ email \ phone \ feedback \ avatar \ image \ send
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => t('Name:'),
      '#description' => $this->t('А-Я / A-Z / min-2 / max-100'),
      '#placeholder' => 'Name',
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateNameAjax',
        'event' => 'change',
      ],
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => t('Email:'),
      '#description' => $this->t('allowed values: Aa-Zz / _ / -'),
      '#placeholder' => 'Email',
      '#ajax' => [
        'callback' => '::validateEmailAjax',
        'event' => 'change',
      ],
    ];
    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => t('Phone number'),
      '#description' => $this->t('Enter ur valid phone number'),
      '#placeholder' => 'Phone nuber',
    ];
    $form['feedback'] = [
      '#type' => 'textfield',
      '#title' => t('Feedback'),
      '#placeholder' => t('Tell us what u think'),
    ];
    $form['profilePic'] = [
      '#type' => 'managed_file',
      '#title' => t('Your photo'),
      '#description' => 'jpeg/jpg/png/<2MB',
      '#placeholder' => 'Image',
      '#required' => 'FALSE',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [2097152],
      ],
      '#upload_location' => 'public://romaroma/',
    ];
    $form['respondPic'] = [
      '#type' => 'managed_file',
      '#title' => t('Any photo to share with us?'),
      '#description' => 'jpeg/jpg/png/<2MB',
      '#placeholder' => 'Image',
      '#required' => 'FALSE',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [2097152],
      ],
      '#upload_location' => 'public://romaroma/',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#name' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmitCallback',
        'event' => 'click',
      ],
    ];
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t("At least, it works.."));
  }

}
