<?php

namespace Drupal\timeZoneManager\Form\Config;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TimeZoneManagerConfig.
 *
 * @package Drupal\timeZoneManager\Form\Config
 */
class TimeZoneManagerConfig extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'timeZoneManager.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'timeZoneManager_config_form';
  }

  /**
   * {@inheritdoc} Build Form
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $timezoneConfig = $this->config('timeZoneManager.settings');

    $list = [
      'America/Chicago' => 'Chicago',
      'America/New_York' => 'New York',
      'Asia/Tokyo' => 'Tokyo',
      'Asia/Dubai' => 'Dubai',
      'Asia/Kolkata' => 'Kolkata',
      'Europe/Amsterdam' => 'Amsterdam',
      'Europe/Oslo' => 'Oslo',
      'Europe/London' => 'London',
    ]; 

    $form['timezone'] = [
      '#type' => 'select',
      '#options' => $list,
      '#title' => $this->t('World TimeZone'),
      '#required' => TRUE,
      '#default_value' => $timezoneConfig->get('timezone'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#default_value' => $timezoneConfig->get('city'),
    ];

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#default_value' => $timezoneConfig->get('country'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc} Submit Form
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('timeZoneManager.settings')
      ->set('timezone', $form_state->getValue('timezone'))
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
