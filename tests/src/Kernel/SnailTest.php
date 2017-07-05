<?php

namespace Drupal\Tests\snail\Kernel;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tests the snail module.
 *
 * @group snail
 */
class SnailTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['test_page_test', 'system'];

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    parent::register($container);

    // Tests have url aliases disabled by default ¯\_(ツ)_/¯, let's add it back.
    if ($container->hasDefinition('path_processor_alias')) {
      $container->getDefinition('path_processor_alias')
        ->addTag('path_processor_inbound', ['priority' => 100])
        ->addTag('path_processor_outbound', ['priority' => 300]); 
    }
  }

  public function testSnail() {
    // Create a URL alias and ensure that its path is resolved.
    /** @var \Drupal\Core\Path\AliasStorageInterface $path_alias_storage */
    $path_alias_storage = \Drupal::service('path.alias_storage');
    $path_alias_storage->save('/test-page', '/test-page-alias');

    /** @var \Symfony\Component\HttpKernel\HttpKernelInterface $http_kernel */
    $http_kernel = \Drupal::service('http_kernel');
    $response = $http_kernel->handle(Request::create('/test-page-alias'));
    $this->assertEquals(200, $response->getStatusCode());

    // Enable the snail module, the url alias should no longer be taken into
    // account for routing.
    \Drupal::service('module_installer')->install(['snail']);
    $http_kernel = \Drupal::service('http_kernel');
    $response = $http_kernel->handle(Request::create('/test-page-alias'));
    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testSnailForAdmin() {
    // Create a URL alias and ensure that its path is resolved.
    /** @var \Drupal\Core\Path\AliasStorageInterface $path_alias_storage */
    $path_alias_storage = \Drupal::service('path.alias_storage');
    $path_alias_storage->save('/test-page', '/admin');

    /** @var \Symfony\Component\HttpKernel\HttpKernelInterface $http_kernel */
    $http_kernel = \Drupal::service('http_kernel');
    $response = $http_kernel->handle(Request::create('/admin'));
    $this->assertEquals(200, $response->getStatusCode());

    // Enable the snail module, the url alias should no longer be taken into
    // account for routing.
    \Drupal::service('module_installer')->install(['snail']);
    $http_kernel = \Drupal::service('http_kernel');
    $response = $http_kernel->handle(Request::create('/admin'));
    $this->assertEquals(403, $response->getStatusCode());
  }

}
