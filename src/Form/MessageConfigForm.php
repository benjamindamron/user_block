<?php
/**
 * @file
 * Contains \Drupal\cdw_google_ads\Form\GaForm.
 */
namespace Drupal\user_block\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MessageConfigForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'message_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

      $form['message'] = array(
          '#type' => 'textarea',
          '#title' => t('Welcome Message'),
          '#default_value' => \Drupal::config('user_block.settings')->get('message')?:'',
          '#description' => t('Create a custom welcome message to be displayed under the user welcome block in the sidebar.'),
      );

      $form['hide'] = array(
          '#type' => 'checkbox',
          '#title' => t('Hide welcome message for unauthenticated users.'),
          '#default_value' => \Drupal::config('user_block.settings')->get('hide')?:'',
          '#description' => t(''),
      );

      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    foreach ($form_state->getValues() as $key => $value) {
        \Drupal::configFactory()->getEditable('user_block.settings')->set($key, $value)->save();
    }

   }
}
