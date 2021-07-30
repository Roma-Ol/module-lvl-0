<?php

namespace Drupal\romaroma\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a confirmation form to confirm deletion of something by id.
 */
class DeleteGuestForm extends ConfirmFormBase {

  /**
   * ID of the item to delete.
   *
   * @var DeleteGuestForm
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

    $form_state->setRedirect('romaroma.form');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "deleteGuestForm";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('romaroma.form');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Delete this guest?');
  }

}
