<?php

namespace Drupal\form\Controller;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

include_once __DIR__ . '/form.install.php';

class FormController extends FormBase {

  public function getFormId() {
    return 'signup_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $username = $form_state->getValue('username');
    if (strlen($username) < 5) {
      $form_state->setErrorByName('username', $this->t('Username must be at least 5 characters long.'));
    }

    $email = $form_state->getValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Invalid email address.'));
    }

    $password = $form_state->getValue('password');
    if (strlen($password) < 8) {
      $form_state->setErrorByName('password', $this->t('Password must be at least 8 characters long.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    form_install();
    $values = $form_state->getValues();

    $connection = Database::getConnection();
    $connection->insert('information')
      ->fields([
        'username' => $values['username'],
        'email' => $values['email'],
        'password' => $values['password'],
      ])
      ->execute();

    $this->messenger()->addMessage($this->t('Form submission successful.'));
  }

}

