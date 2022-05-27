<?php

namespace Drupal\timeZoneManager\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class TimeZoneManagerService
 * @package Drupal\timeZoneManager\Services
 */
class TimeZoneManagerServices {

  /**
   * Config factory.
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Date formatter service.
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Class constructor.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   * configuration factory.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   * Date formatter service.
   */
  public function __construct(ConfigFactoryInterface $configFactory , DateFormatterInterface $dateFormatter){
    $this->configFactory = $configFactory;
    $this->dateFormatter = $dateFormatter;
  }
  
  /**
   * {@inheritdoc} function getData
   */
  public function getData() {
    $config = $this->configFactory->get('timeZoneManager.settings');
    $timezone = $config->get('timezone');
    $date = $this->dateFormatter->format(strtotime('now'), 'custom' , 'jS M Y - h:i A' , $timezone);
    return $date;
  }
}
