<?php

namespace Drupal\country_path;

use Drupal\domain_alias\DomainAliasValidator;
use Drupal\domain_alias\DomainAliasInterface;

/**
 * Supplies validator methods for common domain requests.
 */
class CountryPathDomainAliasValidator extends DomainAliasValidator {

  /**
   * Validates the rules for a domain alias.
   *
   * @param \Drupal\domain_alias\DomainAliasInterface $alias
   *   The Domain Alias to validate.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|null
   *   A validation error message, if any.
   */
  public function validate(DomainAliasInterface $alias) {
    $pattern = $alias->getPattern();

    // 1) Check for at least one dot or the use of 'localhost'.
    // Note that localhost can specify a port.
    $localhost_check = explode(':', $pattern);
    if (substr_count($pattern, '.') == 0 && $localhost_check[0] != 'localhost') {
      return $this->t('At least one dot (.) is required, except when using <em>localhost</em>.');
    }

    // 2) Check that the alias only has one wildcard.
    $count = substr_count($pattern, '*') + substr_count($pattern, '?');
    if ($count > 1) {
      return $this->t('You may only have one wildcard character in each alias.');
    }
    // 3) Only one colon allowed, and it must be followed by an integer.
    $count = substr_count($pattern, ':');
    if ($count > 1) {
      return $this->t('You may only have one colon ":" character in each alias.');
    }
    elseif ($count == 1) {
      $int = substr($pattern, strpos($pattern, ':') + 1);
      if (!is_numeric($int)) {
        return $this->t('A colon may only be followed by an integer indicating the proper port.');
      }
    }
    // 4) Check that the alias doesn't contain any invalid characters.
    // Check for valid characters, unless using non-ASCII domains.
    $non_ascii = $this->configFactory->get('domain.settings')->get('allow_non_ascii');
    if (!$non_ascii) {
      $check = preg_match('/^[a-z0-9\.\+\-\*\/\/?:]*$/', $pattern);
      if ($check == 0) {
        return $this->t('The pattern contains invalid characters.');
      }
    }
    // 5) The alias cannot begin or end with a period.
    if (substr($pattern, 0, 1) == '.') {
      return $this->t('The pattern cannot begin with a dot.');
    }
    if (substr($pattern, -1) == '.') {
      return $this->t('The pattern cannot end with a dot.');
    }

    // 6) Check that the alias is not a direct match for a registered domain.
    $check = preg_match('/[a-z0-9\.\+\-:]*$/', $pattern);
    if ($check == 1 && $this->domainStorage->loadByHostname($pattern)) {
      return $this->t('The pattern matches an existing domain record.');
    }
    // 7) Check that the alias is unique across all records.
    if ($alias_check = $this->aliasStorage->loadByPattern($pattern)) {
      /** @var \Drupal\domain_alias\DomainAliasInterface $alias_check */
      if ($alias_check->id() != $alias->id()) {
        return $this->t('The pattern already exists.');
      }
    }
  }

}
