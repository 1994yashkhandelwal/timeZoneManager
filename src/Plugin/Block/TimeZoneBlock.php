<?php

namespace Drupal\timeZoneManager\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\timeZoneManager\Services\TimeZoneManagerServices;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 *
 * @Block(
 *   id = "timezone_block",
 *   admin_label = @Translation("World TimeZone Block"),
 * )
 */
class TimeZoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   *
   * @var \Drupal\timeZoneManager\Services\TimeZoneManagerServices
   */
  protected $worldTimeZone;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Class constructor.
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\timezone\Services\TimeZoneServices $worldTimeZone
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   * Configuration factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TimeZoneManagerServices $worldTimeZone , ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->timezone = $worldTimeZone;
    $this->configFactory = $configFactory;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('timeZoneManager.timezone_service'),
      $container->get('config.factory'),
    );
  }

  /**
   * {@inheritdoc} Build block function
   */
  public function build() {
    $config = $this->configFactory->get('timeZoneManager.settings');
    $timeZoneCity = $config->get('city');
    $timeZoneCountry = $config->get('country');
    $date = $this->timeZoneManager->getData();
    return [
      '#theme' => 'timezone_block',
      '#date' => $date,
      '#city' => $timeZoneCity,
      '#country' => $timeZoneCountry,
      '#cache' => ['max-age' => 0],
    ];
  }
}
