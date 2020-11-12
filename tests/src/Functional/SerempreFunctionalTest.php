<?php

namespace Drupal\Tests\serempre_prueba\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Serempre functional test.
 *
 * @group serempre_prueba
 */
class SerempreFunctionalTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['pathauto', 'serempre_prueba'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test that the Serempre role is present.
   */
  public function testRolePresent() {
    $admin = $this->createUser([], NULL, TRUE);
    $this->drupalLogin($admin);

    $this->drupalGet('admin/people/roles');
    $this->assertText('Serempre');
  }

}
