<?php

namespace Drupal\romaroma\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
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
   * Do some func.
   *
   * @var \Drupal\romaroma\Controller\FirstPageController
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
    \Drupal::service('page_cache_kill_switch')->trigger();
    // Building the form.
    $form = $this->build();

    $result = $this->load();
    foreach ($result as $row) {
      // Getting the profile picture info.
      $profilePic         = file::load($row->profilePic);
      $profilePicVariable = [];
      $profilePicUrl      = '';
      if (!($profilePic == NULL)) {
        $profilePicUri      = $profilePic->getFileUri();
        $profilePicVariable = [
          '#theme' => 'image',
          '#uri'   => $profilePicUri,
          '#alt'   => 'Profile picture',
          '#title' => 'Profile picture',
        ];
        $profilePicUrl      = file_url_transform_relative(Url::fromUri(file_create_url($profilePicUri))
          ->toString());
      }

      // Getting the feedback picture info.
      $feedbackPic         = file::load($row->feedbackPic);
      $feedbackPicVariable = [];
      $feedbackPicUrl      = '';
      if (!($feedbackPic == NULL)) {
        $feedbackPicUri      = $feedbackPic->getFileUri();
        $feedbackPicVariable = [
          '#theme' => 'image',
          '#uri'   => $feedbackPicUri,
          '#alt'   => 'Feedback picture',
          '#title' => 'Feedback picture',
        ];
        $feedbackPicUrl      = file_url_transform_relative(Url::fromUri(file_create_url($feedbackPicUri))
          ->toString());
      }

      // Putting all the data we need into one variable.
      $data[] = [
        'id'          => $row->id,
        'name'        => $row->name,
        'mail'        => $row->mail,
        'phone'       => $row->phone,
        'feedback'    => $row->feedback,
        'created'     => $row->created,
        'profilePic'  => [
          'data' => $profilePicVariable,
          'url'  => $profilePicUrl,
        ],
        'feedbackPic' => [
          'data' => $feedbackPicVariable,
          'url'  => $feedbackPicUrl,
        ],
      ];
    }

    $value = $this->getDestinationArray();
    $let   = $value["destination"];

    // Rendering the data we need.
    return [
      '#theme'   => 'guest_list',
      '#form'    => $form,
      '#content' => empty($data) ? '' : $data,
      '#getDest' => $let,
    ];

  }

}
