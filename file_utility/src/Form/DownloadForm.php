<?php
  /**
   * Download Form.
   *
   * @file
   * contains \Drupal\file_utility\Form\DownloadForm
   */
namespace Drupal\file_utility\Form;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class DownloadForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'download_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('file_utility.downloadform');

    $form['name'] = array(
      '#type' => 'textfield',
      '#name' => 'name',
      '#title' => $this->t('Name'),
      '#default_value' => $config->get('name'),
      '#required' => TRUE,
    );

    $form['email'] = array(
      '#type' => 'textfield',
      '#name' => 'email',
      '#title' => $this->t('Email'),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
    );

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save configuration'),
    ];

    return $form;
  }

  /**
  * {@inheritdoc}
  */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $is_valid_email = \Drupal::service('email.validator')->isValid($email);
    if (empty($is_valid_email)) {
      $form_state->setErrorByName('email', $this->t('Please enter valid email id'));
    }
  }

    /**
   * Submit handler of the config Form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config('file_utility.downloadform');
    $values = $form_state->getValues();
    $config->set('name', $values['name'])
      ->set('email', $values['email'])
      ->save();
    parent::submitForm($form, $form_state);
  }
}