<?php

namespace Drupal\movie_directory\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\Messenger;

class MovieApi extends FormBase {

    const Movie_Api_Config = 'movie_api_config_page'; 

    public function getFormId() {
        return 'movie_api_config_page';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $values =\Drupal::state()->get(self::Movie_Api_Config);

        $form =[];
        $form['api_base_url'] = [
            '#type' => 'textfield', 
            '#title' => $this->t('Api Base Url'),
            '#description' => $this->t('This is API base Url'),
            '#required' => TRUE,
            '#default_value' => $values['api_base_url'],
        ];

        $form['api_key'] = [
            '#type' => 'textfield', 
            '#title' => $this->t('Api Key'),
            '#description' => $this->t('This is API Key'),
            '#required' => TRUE,
            '#default_value' => $values['api_key'],
        ];
        $form['actions']['#type']='actions';
        $form['actions']['submit']=[
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type'=> 'primary',

        ];
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $submitted_values = $form_state->cleanValues()->getValues();
    
        \Drupal::state()->set(self::Movie_Api_Config, $submitted_values);
    
        $messenger = \Drupal::service('messenger');
        $messenger->addMessage($this->t('Your new message has been saved.'));
    }
    

}
