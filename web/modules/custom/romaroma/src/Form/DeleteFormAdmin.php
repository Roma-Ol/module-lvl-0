<?php

namespace Drupal\romaroma\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a confirmation form to confirm deletion of something by id.
 */
class DeleteFormAdmin extends ConfirmFormBase {

  /**
   * ID of the item to delete.
   *
   * @var DeleteFormAdmin
   */
  protected $id;

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $id = NULL) {
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * Do something.
   *
   * { @inheritdoc }
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $query = \Drupal::database()->delete('guestbook');
    $query->condition('id', $this->id);
    $query->execute();

    $form_state->setRedirect('romaroma.admin_setting');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "DeleteFormAdmin";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('romaroma.admin_setting');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Do you want to delete this kitty?');
  }

}
