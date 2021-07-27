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
      ->fields('g', ['id', 'name', 'mail', 'phone', 'feedback', 'created', 'profilePic', 'feedbackPic'])
      ->orderBy('created', 'DESC')
      ->execute()->fetchAll(\PDO::FETCH_OBJ);
    $data   = [];

    return $result;
  }

  /**
   * Telling what to return.
   */
  public function report() {
    $result = $this->load();
    // Creating a rows, where every row is a seperate feeback.

    $data = [];
    foreach ($result as $row) {
      $data[$row->id] = [
        //        $row->id,
        $row->name,
        $row->mail,
        $row->feedback,
        $row->created,
        [
          'data' => [
            '#theme'      => 'image',
            '#alt'        => 'catImg',
            '#uri'        => File::load($row->profilePic)->getFileUri(),
            '#width'      => 100,
          ],
        ],
        [
          'data' => [
            '#theme'      => 'image',
            '#alt'        => 'catImg',
            '#uri'        => File::load($row->feedbackPic)->getFileUri(),
            '#width'      => 100,
          ],
        ],
      ];
    }

    // Creating headings for our table.
    $header = [
      t('name'), t('email'), t('feedback'), t('created'),
    ];

    // Building the form.
    $form = $this->build();
    $build['form'] = $form;

    // Building the table from DB.
    $build['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $data,
    ];

    // Rendering the above things.
    return $build;
  }

}