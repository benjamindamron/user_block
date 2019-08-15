<?php

namespace Drupal\user_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\View;
use \Drupal\views\ViewExecutable;

/**
 * Provides a 'WelcomeMessage' block.
 *
 * @Block(
 *  id = "user_welcome",
 *  admin_label = @Translation("User Welcome Message"),
 * )
 */
class WelcomeMessage extends BlockBase {
	/**
	* {@inheritdoc}
	*/
	public function defaultConfiguration() {
	    return array(
	        'message' => FALSE,
	        'hide' => '',
            ) + parent::defaultConfiguration();
	}

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
      $form['message'] = array(
          '#type' => 'textarea',
          '#title' => t('Welcome Message'),
          '#default_value' => $this->configuration['message'],
          '#description' => t('Create a custom welcome message to be displayed under the user welcome block in the sidebar.'),
      );

      $form['hide'] = array(
          '#type' => 'checkbox',
          '#title' => t('Hide welcome message for unauthenticated users.'),
          '#default_value' => $this->configuration['hide'],
          '#description' => t(''),
      );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
      $this->configuration['message'] = $form_state->getValue('message');
      $this->configuration['hide'] = $form_state->getValue('hide');

  }

  /**
   * {@inheritdoc}
   */
  public function build() {
      $path = '/'.drupal_get_path('module', 'manifest_banner') . '/images/';

      $hide = $this->configuration['hide'];

      $build = [];
      if (\Drupal::currentUser()->isAnonymous() && $hide == 1) {
          // Anonymous user...
          return;
      }else{
          $build = [
              '#type' => 'html_tag',
              '#tag' => 'div',
              '#theme' => 'user_block',
              '#user_info' => views_embed_view('user_block'),
              '#message' => $this->configuration['message'],
          ];

      }
      return $build;


  }

}
