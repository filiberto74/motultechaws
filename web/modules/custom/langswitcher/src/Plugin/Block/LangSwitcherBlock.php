<?php

namespace Drupal\langswitcher\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'Language Switcher' custom block.
 *
 * @Block(
 *   id = "langswitcher_block",
 *   admin_label = @Translation("Language Switcher Block"),
 *   category = @Translation("MotulTech")
 * )
 */
class LangSwitcherBlock extends BlockBase {


  private function __getNativeLanguageName($lang_code) {
    $nativeLangs = \Drupal::LanguageManager()->getNativeLanguages();
    $nativeLang = $nativeLangs[strtolower($lang_code)];
    if ($nativeLang) {
      return $nativeLang->get("label");
    }
    else {
      return "";
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    // Location Switcher Panes
    $systemLanguages = \Drupal::LanguageManager()->getLanguages();

    $global_lang_links = '<div class="global-lang-wrapper"><h5 class="modal-h5-title">GLOBAL WEBSITE:</h5><div class="wrapper-lang-links">';
    foreach (LOCALIZATION_MATRIX['GLOBAL']['global']['langs'] as $lang_code) {
      $langName = $this->__getNativeLanguageName($lang_code);
      $global_lang_links .= '<a href="/change-location/?country_code=global&url=/'.$lang_code.'">'.$langName.'</a>';
    }
    $global_lang_links .= '</div></div>';

    $switcher_panes = '<div class="tab-content" id="pills-tab-content">';
    foreach (LOCALIZATION_MATRIX as $continent=>$data) {
      $switcher_panes .= '<div class="tab-pane fade" id="pills-'.strtolower($continent).'" role="tabpanel" aria-labelledby="pills-'.strtolower($continent).'-tab">
                    <div class="row">
                        <div class="col-md-4">';
      $count = count(LOCALIZATION_MATRIX[$continent]);
      if ($count > 0) {
        $ceil = ceil($count/3);
        $i = 0;
        foreach (LOCALIZATION_MATRIX[$continent] as $country_code=>$country_data) {
          $switcher_panes .= '<h5>
            <span class="flagwrapper"><img src="/themes/custom/motultech/images/flags/'.strtoupper($country_code).'.png" class="flag" alt=""/></span>
            <a href="/change-location/?country_code='.$country_code.'&url=/'.COUNTRY_DOMAIN[$country_code].'/'.COUNTRY_LANGUAGE_DEFAULT[$country_code].'">'.$country_data['label'].'</a></h5>';
          $cnt = 1;
          $switcher_panes .= '<div class="translation-links">';
          foreach ($systemLanguages as $langcode => $language) {
            $langName = $this->__getNativeLanguageName($langcode);

            // Native langName exceptions
            if ($langName == "Polszczyzna") {
              $langName = "Polski";
            }
            if ($langName == "Norwegian Bokmål") {
              $langName = "Norwegian";
            }
            if ($langName == "Portuguese, Portugal") {
              $langName = "Portuguese";
            }
            if (in_array($langcode, $country_data['langs'])) {
              $switcher_panes .= (($cnt>1)?' | ':'').'<a href="/change-location/?country_code='.$country_code.'&url=/'.COUNTRY_DOMAIN[$country_code].'/'.$langcode.'">'.$langName.'</a>';
            }
            $cnt++;
          }
          $switcher_panes .= '</div>';
          $i++;
          if ($i == $ceil) {
            $switcher_panes .= '</div><div class="col-md-4">';
            $i = 0;
          }
        }
      }
      else {
        $switcher_panes .= 'Sorry, no countries available in this area yet.';
      }
      $switcher_panes .= '</div>
                    </div>
                </div>';
    }
    $switcher_panes .= '</div>';


    // Current country languages
    if (isset($_COOKIE['MotulTech_User_Location'])) {
      $current_lang_code = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $current_country_code = $_COOKIE['MotulTech_User_Location'];

      if ($current_country_code != "global") {
        // $country_infos = file_get_contents("https://restcountries.com/v3.1/alpha/".$current_country_code);
        // $country_infos_details = json_decode($country_infos, true);
        //
        // if (isset($country_infos_details[0]['name']['common'])) {
        //   $current_country_name = $country_infos_details[0]['name']['common'];
        // }
        $ids = \Drupal::entityQuery('taxonomy_term')
          ->condition('vid', 'countries')
          ->condition('field_iso_2', $current_country_code)
          ->condition('status', 1)
          ->accessCheck(FALSE)
          ->execute();
        if (count($ids) > 0) {
          $countries_tax = Term::load(array_key_first($ids));
          $current_country_name = $countries_tax->get('name')->value;
        }
        else {
          $current_country_name = $current_country_code;
        }
        $lang_links = '<li class="country-label"><a class="disabled dropdown-item">'.$current_country_name.'</a></li>';
      }
      else {
        $lang_links = '';
      }




      foreach (COUNTRY_LANGUAGES[$current_country_code] as $lang_code) {
        $langName = $this->__getNativeLanguageName($lang_code);
        $active_lang_class = "";
        if ($current_lang_code == $lang_code) {
          $active_lang_class = "active";
        }
        if ($current_country_code == "global") {
          $lang_links .= '<li><a class="'.$active_lang_class.' dropdown-item" href="/'.$lang_code.'">'.$langName.'</a></li>';
        }
        else {
          $lang_links .= '<li><a class="'.$active_lang_class.' dropdown-item" href="/'.COUNTRY_DOMAIN[$current_country_code].'/'.$lang_code.'">'.$langName.'</a></li>';
        }
      }
    }
    else {
      $loader = \Drupal::service('domain.negotiator');
      $current_domain = $loader->getActiveDomain();
      $current_lang_code = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $lang_links = '<li class="country-label">'.$current_domain->get("name").'</li>';
      foreach (DOMAIN_LANGUAGES[$current_domain->get("id")] as $lang_code) {
        $langName = $this->__getNativeLanguageName($lang_code);
        $active_lang_class = "";
        if ($current_lang_code == $lang_code) {
          $active_lang_class = "active";
        }
        if (isset($current_domain->get("third_party_settings")["country_path"]["domain_path"])) {
          $lang_links .= '<li><a class="'.$active_lang_class.' dropdown-item" href="/'.$current_domain->get("third_party_settings")["country_path"]["domain_path"].'/'.$lang_code.'">'.$langName.'</a></li>';
        }
        else {
          $lang_links .= '<li><a class="'.$active_lang_class.' dropdown-item" href="/'.$lang_code.'">'.$langName.'</a></li>';
        }
      }
    }

    return [
      '#theme' => 'langswitcher',
      '#data' => [],
      '#lang_links' => [
        '#markup' => $lang_links,
      ],
      '#global_lang_links' => [
        '#markup' => $global_lang_links,
      ],
      '#tab_panes' => [
        '#markup' => $switcher_panes,
      ],
    ];
  }
}
