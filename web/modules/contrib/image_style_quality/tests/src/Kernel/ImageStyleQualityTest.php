<?php

namespace Drupal\Tests\image_style_quality\Kernel;

use Drupal\image\Entity\ImageStyle;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test the image styles.
 *
 * @group image_style_quality
 */
class ImageStyleQualityTest extends KernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'image_style_quality',
    'image',
    'system',
  ];
  protected string $styleName = 'test_style';
  protected int $testQuality = 5;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('image_style');
    $this->installConfig('system');

    $style = ImageStyle::create([
      'name' => $this->styleName,
    ]);
    $style->addImageEffect([
      'id' => 'image_style_quality',
      'data' => [
        'quality' => $this->testQuality,
      ],
    ]);
    $style->save();
  }

  /**
   * Test the image quality is reduced using the plugin.
   *
   * @dataProvider imageQualityTestCases
   */
  public function testImageQuality($toolkit): void {
    $this
      ->config('system.image')
      ->set('toolkit', $toolkit)
      ->save();

    $style = ImageStyle::load($this->styleName);

    $original_uri = __DIR__ . '/../../fixtures/original.jpg';
    $derivative_uri = 'public://test-image.jpg';
    $style->createDerivative($original_uri, $derivative_uri);

    // Ensure the generated image is at least half the size of the original.
    $this->assertTrue(filesize($original_uri) > filesize($derivative_uri) * 2);
  }

  /**
   * Test cases for ::testImageQuality.
   */
  public function imageQualityTestCases(): array {
    return [
      'GD' => [
        'gd',
      ],
      'Imagemagick' => [
        'imagemagick',
      ],
      'Imagick' => [
        'imagick',
      ],
    ];
  }

}
