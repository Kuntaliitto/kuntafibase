<?php

namespace Drupal\kuntafibase_now\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;

/**
 * Class HideNowForm.
 *
 * @package Drupal\kuntafibase_now\Form
 */
class HideNowForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hide_now_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /*$form['#attached']['library'][] = [
      'kuntafibase_now/kuntafibase-now-styles',
    ];*/
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Hide'),
      '#ajax' => [
        'callback' => '::removeCallback',
      ],
    ];

    return $form;
  }

  /**
   * Callback method for form submit.
   *
   * @param array $form
   *   Form representation.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Forms state.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Response object.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $response->addCommand(new InvokeCommand('.view--now', 'addClass', ['is-hidden']));
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $_SESSION['hide_now'] = TRUE;
  }

}
