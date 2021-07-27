<?php

namespace Drupal\romaroma\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FirstPageController.
 *
 * Works on specific  class.
 *
 * Contains \Drupal\romaroma\Controller\FirstPageController.
 */
class FirstPageController extends ControllerBase {

  /**
   * Do a specific functional.
   */
  protected $formBuilder;

  /**
   * Creating a container for form rendering.
   */
  public static function create(ContainerInterface $container) {
    $instance              = parent::create($container);
    $instance->formBuilder = $container->get('form_builder');
    return $instance;
  }

  /**
   * Getting the FormMain and render it with FormBuilder.
   */
  public function build() {
    $form = $this->formBuilder->getForm('Drupal\romaroma\Form\FormMain');
    return $form;
  }

  /**
   * Creating a table from DB.
   */
  public function load() {
    $query  = \Drupal::database();
    $result = $query->select('guestbook', 'g')
      ->fields('g', [
        'id',
        'name',
        'mail',
        'phone',
        'feedback',
        'created',
        'profilePic',
        'feedbackPic',
      ])
      ->orderBy('created', 'DESC')
      ->execute()->fetchAll(\PDO::FETCH_OBJ);

    return $result;
  }

  /**
   * Telling what to return.
   */
  public function report() {
    $result = $this->load();

    foreach ($result as $row) {

      // Getting the profile picture info.
      $profilePic = file::load($row->profilePic);
      $profilePicUri = $profilePic->getFileUri();
      $profilePicVariable = [
        '#theme' => 'image',
        '#uri' => $profilePicUri,
        '#alt' => 'Profile picture',
        '#title' => 'Profile picture',
        '#width' => 150,
      ];

      // Getting the profile picture info.
      $feedbackPic = file::load($row->feedbackPic);
      $feedbackPicUri = $feedbackPic->getFileUri();
      $feedbackPicVariable = [
        '#theme' => 'image',
        '#uri' => $feedbackPicUri,
        '#alt' => 'Feedback picture',
        '#title' => 'Feedback picture',
        '#width' => 150,
      ];
    }

    // Putting all the data we need into one variable.
    $data[] = [
      'name' => $row->name,
      'mail' => $row->mail,
      'phone' => $row->phone,
      'feedback' => $row->feedback,
      'created' => $row->created,
      'profilePic' => [
        'data' => $profilePicVariable,
      ],
      'feedbackPic' => [
        'data' => $feedbackPicVariable,
      ],
    ];

    // Building the form.
    $form          = $this->build();
    $build['form'] = $form;

    // Rendering the data we need.
    return [
      'form' => $form,
      'guest_list' => [
        '#theme'   => 'guest_list',
        '#content' => $data,
      ],
    ];
  }

}
