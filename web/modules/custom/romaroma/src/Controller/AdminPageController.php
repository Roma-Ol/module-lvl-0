<?php

namespace Drupal\romaroma\Controller;

use Drupal\file\Entity\File;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Do smt.
 *
 * Class AdminPageController.
 */
class AdminPageController extends FormBase {

  /**
   * Do smt.
   *
   * @var AdminPageController
   */
  protected $id;

  /**
   * Do smt.
   *
   * @return string
   *
   *   Returning the form ID.
   */
  public function getFormId() {
    return 'formGuestAdmin';
  }

  /**
   * Building the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $query  = \Drupal::database();
    $result = $query->select('guestbook', 'g')
      ->fields('g', [
        'id',
        'profilePic',
        'feedbackPic',
        'name',
        'mail',
        'phone',
        'created',
        'feedback',
      ])
      ->orderBy('created', 'DESC')
      ->execute()->fetchAll(\PDO::FETCH_OBJ);
    $data   = [];
    foreach ($result as $row) {
      // Rendering the profile picture.
      // And checking whether it exists.
      $profilePicValue = $row->profilePic;
      if ($profilePicValue == 0) {
        $profilePic = 'no photo';
      }
      else {
        $profilePicFile = file::load($profilePicValue);
        $profilePic     = [
          'data' => [
            '#theme' => 'image',
            '#alt'   => 'Img',
            '#uri'   => $profilePicFile->getFileUri(),
            '#width' => 100,
          ],
        ];
      }

      // Rendering the feedback picture.
      // And checking whether it exists.
      $feedbackPicValue = $row->feedbackPic;
      if ($feedbackPicValue == 0) {
        $feedbackPic = 'no photo';
      }
      else {
        $feedbackPicFile = file::load($feedbackPicValue);
        $feedbackPic     = [
          'data' => [
            '#theme' => 'image',
            '#alt'   => 'Img',
            '#uri'   => $feedbackPicFile->getFileUri(),
            '#width' => 100,
          ],
        ];
      }
      $data[$row->id] = [
        $profilePic,
        $feedbackPic,
        $row->name,
        $row->mail,
        $row->created,
        $row->feedback,
        t("<a href='editGuest/$row->id' class='db-table-button
        db-table-button-edit use-ajax' data-dialog-type='modal'>Edit</a>"),
        t("<a href='delete-guest/$row->id' class='db-table-button
        db-table-button-delete use-ajax' data-dialog-type='modal'>Delete</a>"),
      ];
    }

    $header = [
      t('Profile pic'),
      t('Feedback pic'),
      t('Name'),
      t('Email'),
      t('Created'),
      $this->t('feedback'),
      t('Edit'),
      t('Delete'),
    ];

    $build['table'] = [
      '#type'    => 'tableselect',
      '#header'  => $header,
      '#options' => $data,
    ];

    $build['submit'] = [
      '#type'       => 'submit',
      '#name'       => 'submit',
      '#value'      => $this->t('Delete'),
      '#attributes' => ['onclick' => 'if(!confirm("Are your sure?")){return false;}'],
    ];

    return [
      $build,
      '#title' => 'List of the guests',
    ];
  }

  /**
   * Submit function event.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue('table');
    $delete = array_filter($values);
    if ($values == NULL) {
      $this->messenger()->addStatus($this->t("Choose something to delete"));
    }
    else {
      \Drupal::database()->delete('guestbook')
        ->condition('id', $delete, 'IN')
        ->execute();
      $this->messenger()->addStatus($this->t("Successfully deleted"));
    }
  }

}
