<?php

namespace Drupal\snail;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceModifierInterface;

class SnailServiceProvider implements ServiceModifierInterface {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Disable path_processor_alias from working.
    $container->getDefinition('path_processor_alias')->clearTags();
  }

}
