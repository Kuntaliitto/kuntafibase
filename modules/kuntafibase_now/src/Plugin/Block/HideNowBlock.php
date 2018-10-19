<?php

namespace Drupal\kuntafibase_now\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBuilder;

/**
 * Provides a 'HideNowBlock' block.
 *
 * @Block(
 *  id = "hide_now_block",
 *  admin_label = @Translation("Hide now block"),
 * )
 */
class HideNowBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Form\FormBuilder definition.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * Constructor of HideNowBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Form\FormBuilder $form_builder
   *   Form builder object.
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        FormBuilder $form_builder
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build[''] = $this->formBuilder->getForm('Drupal\kuntafibase_now\Form\HideNowForm');
    return $build;
  }

}
