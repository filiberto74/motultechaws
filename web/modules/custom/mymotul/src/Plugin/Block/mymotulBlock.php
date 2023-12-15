<?php

namespace Drupal\mymotul\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'mymotul' custom block.
 *
 * @Block(
 *   id = "mymotul_block",
 *   admin_label = @Translation("mymotul Block"),
 *   category = @Translation("MotulTech")
 * )
 */
class mymotulBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    if (isset($_COOKIE['MotulTech_User_Location'])) {
      $current_country_code = $_COOKIE['MotulTech_User_Location'];
      if (isset(MYMOTUL_LINK_EXCEPTIONS[$current_country_code])) {
        $link = MYMOTUL_LINK_EXCEPTIONS[$current_country_code];
      }else{
        $link = MYMOTUL_LINK_DEFAULT['default'];
      }
    }else{
      $link = MYMOTUL_LINK_DEFAULT['default'];
    }

    
    return [
      '#theme' => 'mymotul',
      '#data' => [],
      '#link_mymotul' => [
        '#markup' => $link,
      ],
    ];
  }
}
