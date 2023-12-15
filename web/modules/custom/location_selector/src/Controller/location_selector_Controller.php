<?php
/**
 * @file
 * Contains \Drupal\location_selector\Controller\location_selector_Controller.
 */
namespace Drupal\location_selector\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;


class location_selector_Controller extends ControllerBase {
  
  public function choose_your_location() {
    
    // Try to find the user country by IP address
    function getClientIP() {
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }
      return $ip;
    }
    $ipaddress = getClientIP();
    
    function ip_details($ip) {
      $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
      $details = json_decode($json, true);
      return $details;
    }
    $details = ip_details($ipaddress);
    
    if (isset($details['country'])) {
      $user_country_detected_code = strtolower($details['country']);
      
      // Checks if detected country code is in our list
      if (key_exists($user_country_detected_code, COUNTRY_DOMAIN)) {
        $country_infos = file_get_contents("https://restcountries.com/v3.1/alpha/".$user_country_detected_code);
        $country_infos_details = json_decode($country_infos, true);
        
        if (isset($country_infos_details[0]['name']['common'])) {
          $user_country_detected_name = $country_infos_details[0]['name']['common'];
          return [
            '#theme' => 'location_selector',
            '#user_country_detected_code' => $user_country_detected_code,
            '#user_country_detected_name' => $user_country_detected_name,
          ];
        }
        else {
          $response = new RedirectResponse('/?lsmodal=true');
          $response->send();
          exit;
        }
      }
      else {
        $response = new RedirectResponse('/?lsmodal=true');
        $response->send();
        exit;
      }
    }
    else {
      $response = new RedirectResponse('/?lsmodal=true');
      $response->send();
      exit;
    }
  }
  
  
  public function set_location($country_code) {
    // Checks if detected country code is in our list
    if (key_exists($country_code, COUNTRY_DOMAIN)) {
      $domain_code = COUNTRY_DOMAIN[$country_code];
  
      $arr_cookie_options = array (
        'expires' => strtotime('+30 days'),
        'path' => '/',
        'domain' => $_SERVER['SERVER_NAME'],
        'secure' => true,     // or false
        'httponly' => true,    // or false
        'samesite' => 'None' // None || Lax  || Strict
      );
      
      setcookie("MotulTech_User_Location", $country_code, $arr_cookie_options);
      //setcookie("MotulTech_User_Location", $country_code, strtotime('+30 days'), '/', $_SERVER['SERVER_NAME'], true, false, array('Samesite'=>'None'));
      $response = new RedirectResponse('/'.$domain_code.'/'.COUNTRY_LANGUAGE_DEFAULT[$country_code]);
      $response->send();
      exit;
    }
    else {
      $response = new RedirectResponse('/?lsmodal=true');
      $response->send();
      exit;
    }
  }
  
  public function change_location() {
    // Checks if detected country code is in our list
    $country_code = \Drupal::request()->query->get('country_code');
    $url = \Drupal::request()->query->get('url');
    if (key_exists($country_code, COUNTRY_DOMAIN)) {
      if (isset($_COOKIE['MotulTech_User_Location'])) {
        unset($_COOKIE['MotulTech_User_Location']);
      }
  
      $arr_cookie_options = array (
        'expires' => strtotime('+30 days'),
        'path' => '/',
        'domain' => $_SERVER['SERVER_NAME'],
        'secure' => true,     // or false
        'httponly' => true,    // or false
        'samesite' => 'None' // None || Lax  || Strict
      );
  
      setcookie("MotulTech_User_Location", $country_code, $arr_cookie_options);
      
      //setcookie("MotulTech_User_Location", $country_code, strtotime('+30 days'), '/', $_SERVER['SERVER_NAME'], true);
      $response = new RedirectResponse($url);
      $response->send();
      exit;
    }
    else {
      $response = new RedirectResponse('/?lsmodal=true');
      $response->send();
      exit;
    }
  }
  
}