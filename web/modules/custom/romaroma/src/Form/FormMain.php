<?php

namespace Drupal\romaroma\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Class FormMain.
 *
 * Works on specific  class.
 *
 * Contains \Drupal\romaroma\Form\FormMain.
 */
class FormMain extends FormBase {

  /**
   * Class FormMain.
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'ajax_form_submit_example';
  }

  /**
   * Building a form.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['system_messages']       = [
      '#markup' => '<div id="form-system-messages"></div>',
    ];
    $form['system_messages_email'] = [
      '#markup' => '<div id="form-email-system-messages"></div>',
    ];
    $form['system_messages_phone'] = [
      '#markup' => '<div id="form-phone-system-messages"></div>',
    ];
    $form['name']                  = [
      '#type'        => 'textfield',
      '#title'       => t('Name:'),
      '#description' => $this->t('А-Я / A-Z / min-2 / max-100'),
      '#placeholder' => 'Name',
      '#required'    => TRUE,
      '#ajax'        => [
        'callback' => '::validateNameAjax',
        'event'    => 'change',
      ],
      '#suffix'      => '<div class="name-validation-message"></div>',
    ];
    $form['email']                 = [
      '#type'        => 'email',
      '#title'       => t('Email:'),
      '#description' => $this->t('allowed values: Aa-Zz / _ / -'),
      '#placeholder' => 'Email',
      '#required'    => TRUE,
      '#ajax'        => [
        'callback' => '::validateEmailAjax',
        'event'    => 'change',
      ],
    ];
    $form['phone']                 = [
      '#type'        => 'textfield',
      '#title'       => t('Phone number'),
      '#description' => $this->t('+XXX XX XXX XX XX'),
      '#placeholder' => 'Phone number',
      '#required'    => TRUE,
      '#ajax'        => [
        'callback' => '::validatePhoneAjax',
        'event'    => 'change',
      ],
    ];
    $form['feedback']              = [
      '#type'        => 'textarea',
      '#title'       => t('Feedback'),
      '#description' => $this->t('max: 9999'),
      '#placeholder' => t('Tell us what u think'),
      '#required'    => TRUE,
    ];
    $form['profilePic']            = [
      '#type'              => 'managed_file',
      '#title'             => t('Your profile pic'),
      '#description'       => 'jpeg/jpg/png/<2MB',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size'       => [2097152],
      ],
      '#upload_location'   => 'public://romaroma/',
    ];
    $form['feedbackPic']           = [
      '#type'              => 'managed_file',
      '#title'             => t('Any photo to share with us?'),
      '#description'       => 'jpeg/jpg/png/<2MB',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size'       => [5242880],
      ],
      '#upload_location'   => 'public://romaroma/',
    ];
    $form['submit']                = [
      '#type'  => 'submit',
      '#name'  => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * General form validation.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $nameValue  = $form_state->getValue('name');
    $emailValue = $form_state->getValue('email');
    $phoneValue = $form_state->getValue('phone');

    // Name validation.
    if (!preg_match(
        '/^[A-Za-z]*$/', $nameValue) || strlen($nameValue) <= 2 ||
      strlen($nameValue) >= 100 || $nameValue = "") {
      $form_state->setErrorByName('name', t('Name is not valid.'));
    }

    // Email validation.
    if (!filter_var($emailValue, FILTER_VALIDATE_EMAIL) ||
      !preg_match('/^[A-Za-z1-9-_]+[@]+[a-z]+[.]+[a-z]+$/', $emailValue)) {
      $form_state->setErrorByName('email', t('Email is not valid.'));
    }

    // Phone validation.
    if (!preg_match('/[+0-9]{4} [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}/', $phoneValue)) {
      $form_state->setErrorByName('phone', t('Phone is not valid.'));
    }
  }

  /**
   * Additional AJAX validation.
   *
   *   * Validation to display inline errors 4 user.
   */

  /**
   * Name AJAX validation.
   */
  public function validateNameAjax(array &$form, FormStateInterface $form_state) {
    $response  = new AjaxResponse();
    $nameValue = $form_state->getValue('name');
    if (!preg_match('/^[A-Za-z]*$/', $nameValue) || strlen($nameValue) <= 2
      || strlen($nameValue) >= 100 || $nameValue = "") {
      $response->addCommand(new HtmlCommand(
        '#form-system-messages',
        '<p class="email-ajax-validation-alert-text">
                   Budy, ur Name isn`t ok
                </p>'));
    }
    return $response;
  }

  /**
   * Email AJAX validation.
   */
  public function validateEmailAjax(array &$form, FormStateInterface $form_state) {
    $response   = new AjaxResponse();
    $emailValue = $form_state->getValue('email');
    if (!filter_var($emailValue, FILTER_VALIDATE_EMAIL) ||
      !preg_match('/^[A-Za-z1-9-_]+[@]+[a-z]+[.]+[a-z]+$/', $emailValue)) {
      $response->addCommand(new HtmlCommand(
        '#form-email-system-messages',
        '<p class="email-ajax-validation-alert-text">
                    Budy, ur Email isn`t ok
                </p>'));
    }
    return $response;
  }

  /**
   * Email AJAX validation.
   */
  public function validatePhoneAjax(array &$form, FormStateInterface $form_state) {
    $response   = new AjaxResponse();
    $phoneValue = $form_state->getValue('phone');
    if (!preg_match('/[+0-9]{4} [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}/', $phoneValue)) {
      $response->addCommand(new HtmlCommand(
        '#form-phone-system-messages',
        '<p class="email-ajax-validation-alert-text">
                    Budy, ur Phone number isn`t ok
                </p>'));
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Insert data to DB.
    $form_state->setUserInput([]);
    $image       = $form_state->getValue('profilePic');
    $respondPic  = $form_state->getValue('feedbackPic');
    $file        = File::load($image[0]);
    $fileRespond = File::load($respondPic[0]);
    $file->setPermanent();
    $fileRespond->setPermanent();
    $file->save();
    $fileRespond->save();
    $value = $this->getDestinationArray();
    $let   = $value["destination"];

    $data = \Drupal::service('database')->insert('guestbook')
      ->fields([
        'name'       => $form_state->getValue('name'),
        'mail'       => $form_state->getValue('email'),
        'phone'      => $form_state->getValue('phone'),
        'feedback'   => $form_state->getValue('feedback'),
        'profilePic' => $form_state->getValue('profilePic')[0],
        'feedbackPic' => $form_state->getValue('feedbackPic')[0],
        'created'    => date('d - m - Y H:i:s', time()),
      ])
      ->execute();
    // Successful submit message.
    \Drupal::messenger()->addMessage($this->t('Form submitted!Hooray!'),
      'status', TRUE);
  }

}