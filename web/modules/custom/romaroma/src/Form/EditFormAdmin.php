<?php

namespace Drupal\romaroma\Form;

use Drupal\file\Entity\File;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FormMain.
 *
 * Works on specific  class.
 *
 * Contains \Drupal\romaroma\Form\FormMain.
 */
class EditFormAdmin extends FormBase {

  /**
   * ID of the item to edit.
   *
   * @var EditFormAdmin
   */

  protected $id;

  /**
   * Class FormMain.
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'EditGuestForm';
  }

  /**
   * Building a form.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $id = NULL) {
    $this->id = $id;
    $query    = \Drupal::database();
    $data     = $query->select('guestbook', 'g')
      ->fields('g', [
        'id',
        'name',
        'mail',
        'phone',
        'feedback',
        'profilePic',
        'feedbackPic',
      ])
      ->condition('g.id', $id, '=')
      ->execute()->fetchAll(\PDO::FETCH_OBJ);

    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $form['system_messages']        = [
      '#markup' => '<div id="form-system-messages"></div>',
    ];
    $form['system_messages_email']  = [
      '#markup' => '<div id="form-email-system-messages"></div>',
    ];
    $form['system_messages_phone']  = [
      '#markup' => '<div id="form-phone-system-messages"></div>',
    ];
    $form['name']                   = [
      '#type'          => 'textfield',
      '#title'         => t('Name:'),
      '#description'   => $this->t('А-Я / A-Z / min-2 / max-100'),
      '#placeholder'   => 'Name',
      '#required'      => TRUE,
      '#default_value' => $data[0]->name,
      '#ajax'          => [
        'callback' => '::validateNameAjax',
        'event'    => 'onkeyup',
      ],
      '#suffix'        => '<div class="name-validation-message"></div>',
    ];
    $form['email']                  = [
      '#type'          => 'email',
      '#title'         => t('Email:'),
      '#description'   => $this->t('allowed values: Aa-Zz / _ / -'),
      '#placeholder'   => 'Email',
      '#required'      => TRUE,
      '#default_value' => $data[0]->mail,
      '#ajax'          => [
        'callback' => '::validateEmailAjax',
        'event'    => 'keyup',
      ],
    ];
    $form['phone']                  = [
      '#type'          => 'textfield',
      '#title'         => t('Phone number:'),
      '#description'   => $this->t('+XXX XX XXX XX XX'),
      '#placeholder'   => 'Phone number',
      '#required'      => TRUE,
      '#default_value' => $data[0]->phone,
      '#ajax'          => [
        'callback' => '::validatePhoneAjax',
        'event'    => 'keyup',
      ],
    ];
    $form['feedback']               = [
      '#type'          => 'textarea',
      '#title'         => t('Feedback:'),
      '#description'   => $this->t('max: 9999'),
      '#placeholder'   => t('Tell us what u think'),
      '#required'      => TRUE,
      '#default_value' => $data[0]->feedback,
    ];
    $form['profilePic']             = [
      '#type'              => 'managed_file',
      '#title'             => t('Your profile pic:'),
      '#description'       => 'jpeg/jpg/png/<2MB',
      '#default_value'     => [$data[0]->profilePic],
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size'       => [2097152],
      ],
      '#upload_location'   => 'public://romaroma/',
    ];
    $form['feedbackPic']            = [
      '#type'              => 'managed_file',
      '#title'             => t('Any photo to share with us?'),
      '#description'       => 'jpeg/jpg/png/<2MB',
      '#default_value'     => [$data[0]->feedbackPic],
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size'       => [5242880],
      ],
      '#upload_location'   => 'public://romaroma/',
    ];
    $form['submit']                 = [
      '#type'  => 'submit',
      '#name'  => 'submit',
      '#value' => $this->t('Update'),
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
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setUserInput([]);
    // Inserting the profile picture into DB.
    $profilePic = $form_state->getValue('profilePic');

    if (!($profilePic == NULL)) {
      $profilePic = File::load($profilePic[0]);
      $profilePic->setPermanent();
      $profilePic->save();
    }
    else {
      $form_state->setValue('profilePic', ['0']);
    }

    // Inserting the feedback picture into DB.
    $feedbackPic = $form_state->getValue('feedbackPic');

    if (!($feedbackPic == NULL)) {
      $feedbackPic = File::load($feedbackPic[0]);
      $feedbackPic->setPermanent();
      $feedbackPic->save();
    }
    else {
      $form_state->setValue('feedbackPic', [0]);
    }

    $value = $this->getDestinationArray();
    $let   = $value["destination"];

    \Drupal::database()->update('guestbook')
      ->condition('id', $this->id)
      ->fields([
        'name'        => $form_state->getValue('name'),
        'mail'        => $form_state->getValue('email'),
        'phone'       => $form_state->getValue('phone'),
        'feedback'    => $form_state->getValue('feedback'),
        'profilePic'  => $form_state->getValue('profilePic')[0],
        'feedbackPic' => $form_state->getValue('feedbackPic')[0],
      ])
      ->execute();

    // Successful submit message.
    \Drupal::messenger()->addMessage($this->t('Form updated'),
      'status', TRUE);

    $form_state->setRedirect('romaroma.admin_setting');
  }

}
