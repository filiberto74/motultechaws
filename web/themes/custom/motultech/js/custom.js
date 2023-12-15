/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

  'use strict';

  Drupal.behaviors.motultech = {
    attach: function(context, settings) {

      /* Force Location Switcher modal opening */
      if (window.location.href.indexOf("lsmodal=true") !== -1) {
        console.log("modal = true 111 ??");
        jQuery('#LocactionSwitcherModalTrigger').trigger("click");
        jQuery('#LocactionSwitcherModal .modal-header button').hide();
      }
      //  ----

      /* Contact webform */
      if (window.location.href.indexOf("/contacts") !== -1) {
        jQuery(".form-item-privacy").addClass("form-required");
        var current_url_exp =  window.location.href.split("/");
        var privacy_href = jQuery(".form-item-privacy a.privacy-link").attr("href");
        if (current_url_exp.length == 6) {
          var privacy_href_ok = '/'+current_url_exp[3]+'/'+current_url_exp[4]+privacy_href;
        }
        else {
          var privacy_href_ok = '/'+current_url_exp[3]+privacy_href;
        }
        jQuery(".form-item-privacy a.privacy-link").attr("href", privacy_href_ok);
      }
      //  ----

      // classe active menu book
      // jQuery( ".view-book-sidebar-menu-pages a" ).each(function( index ) {
      //   if (jQuery( this ).once().attr('href') == window.location.pathname) {
      //     jQuery( this ).addClass('active');
      //   }
      // });
      jQuery( "#sidebar_first a" ).each(function( index ) {
        if (jQuery( this ).attr('href') == window.location.pathname || jQuery( this ).attr('href') == window.location) {
          jQuery( this ).addClass('active'); 
        }
      });
      //  ----

      // rimuovo la classe form select dal filtro esposto dell'archivio notizie
      jQuery('#views-exposed-form-news-archive-page-1 div.form-select.bef-links').removeClass('form-select');
      jQuery('#block-views-block-news-archive-block-1 div.form-select.bef-links').removeClass('form-select');
      // ---

      // focus on click al box di ricerca sulla navbar
      jQuery( "#dropdownSearchWrapper" ).click(function() {
        jQuery( "#edit-s" ).focus();
      });
      //  ----

      // mostro un solo no-results nella vista generale di ricerca
      if (jQuery('body.page-node-20 .view-search.empty').length == 2) {
        console.log('non ci sono risultati');
        jQuery('body.page-node-20 div[class*=\'block-views-blocksearch-block-\']').remove();
        jQuery('#block-noresults').removeClass('d-none');
      }
      //  ----


      // chiudo il menu al click del langswitcher o del form di ricerca
        jQuery( "#LangSwitcherDropdown" ).click(function() {
          jQuery('#CollapsingNavbar').removeClass('show');
        });
        jQuery( "#dropdownSearch" ).click(function() {
          jQuery('#CollapsingNavbar').removeClass('show');
        });
      //  ----

      jQuery('#views-exposed-form-reseller-block-1 select.form-select option[value=All]').attr('disabled', 'disabled');
    }
  };

})(jQuery, Drupal);

