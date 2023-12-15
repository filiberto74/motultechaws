<?php

namespace Drupal\Tests\country_path\Functional;

use Drupal\Tests\system\Functional\Cache\AssertPageCacheContextsAndTagsTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Country path base browser test class.
 *
 * @group country_path
 */
class CountryPathTest extends BrowserTestBase {

  use AssertPageCacheContextsAndTagsTrait;

  const DEFAULT_COUNTRIES = ['', 'usa', 'france'];

  /**
   * Sets a base hostname for running tests.
   *
   * @var string
   */
  public $baseHostname;

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['domain', 'country_path'];

  /**
   * We use the standard profile for testing.
   *
   * @var string
   */
  protected $profile = 'standard';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Set the base hostname for domains.
    $this->baseHostname = \Drupal::entityTypeManager()->getStorage('domain')->createHostName();
    $this->domainCreateTestDomains();
  }

  /**
   * Test basic routes with country paths.
   */
  public function testBasicRouting() {
    foreach (self::DEFAULT_COUNTRIES as $value) {
      $this->drupalGet("$value/user");
      $this->assertSession()->statusCodeEquals(200);
      $this->assertSession()->linkByHrefExists("$value/", 0, "Link not found $value/");
      $this->drupalGet("$value/node");
      $this->assertSession()->statusCodeEquals(200);
      $this->assertSession()->linkByHrefExists("$value/", 0, "Link not found $value/");
    }
  }

  /**
   * Test cache context.
   */
  public function testCacheContext() {
    foreach (self::DEFAULT_COUNTRIES as $value) {
      $this->drupalGet("$value/node");
      $this->assertSession()->statusCodeEquals(200);
      $this->assertCacheContext('url.country');
    }
  }

  /**
   * Generates a list of domains with country paths for testing.
   *
   * Default countries are USA and FRANCE.
   *
   * @param array $countries
   *   List of countries.
   * @param string|null $base_hostname
   *   The root domain to use for domain creation (e.g. example.com).
   */
  public function domainCreateTestDomains(array $countries = [], $base_hostname = NULL) {
    $domain_storage = \Drupal::entityTypeManager()->getStorage('domain');
    $domain_storage->resetCache();
    $original_domains = $domain_storage->loadMultiple(NULL);

    if (empty($base_hostname)) {
      $base_hostname = $this->baseHostname;
    }

    if (empty($countries)) {
      $countries = self::DEFAULT_COUNTRIES;
    }
    $count = count($countries);
    for ($i = 0; $i < $count; $i++) {
      if ($i === 0) {
        $hostname = $base_hostname;
        $machine_name = 'example.com';
        $name = 'Example';
      }
      else {
        $hostname = $base_hostname;
        $machine_name = 'example.com/' . $countries[$i];
        $name = 'Test_' . ucfirst($countries[$i]);
        $domain_path = $countries[$i];
      }
      // Create a new domain programmatically.
      $values = [
        'hostname' => $hostname,
        'name' => $name,
        'id' => $domain_storage->createMachineName($machine_name),
      ];
      $domain = $domain_storage->create($values);
      if (!empty($domain_path)) {
        $domain->setThirdPartySetting('country_path', 'domain_path', $domain_path);
      }
      $domain->save();
    }
    $domain_storage->resetCache();
    $domains = $domain_storage->loadMultiple(NULL);
    $this->assertTrue(
      (count($domains) - count($original_domains)) == $count,
      "Failed to create $count new domains"
    );
  }

}
