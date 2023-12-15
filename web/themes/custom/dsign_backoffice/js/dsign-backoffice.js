/**
 * @file
 * Dsign Backoffice behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.dsignBackoffice = {
    attach: function (context, settings) {
      // rimuovo il bottone di delete dal form di edit del menu
      const collection = document.querySelectorAll("body.role-webmaster form.menu-edit-form .form-actions #edit-delete");
      var len = collection.length;
      for (var i = 0; i < len; i++) {
        collection[i].remove();
      }



      // setto tutti i domain attivi alla creazione
      // Funzione per controllare l'URL e settare i checkbox
      function setAllDomainChecked() {
        // Ottieni l'URL corrente
        var url = window.location.href;

        // Verifica se l'URL contiene la stringa "/node/add/"
        if (url.includes("/node/add/")) {
          // Trova l'elemento con id "edit-domain"
          var editDomainElement = document.getElementById("edit-domain");

          // Verifica se l'elemento esiste
          if (editDomainElement) {
            // Trova tutti gli input di tipo "checkbox" all'interno di editDomainElement
            var checkboxes = editDomainElement.querySelectorAll('input[type="checkbox"]');

            // Imposta come "checked" tutti gli input di tipo "checkbox" che non hanno l'id "edit-field-domain-all-affiliates-value"
            checkboxes.forEach(function (checkbox) {
              if (checkbox.id !== "edit-field-domain-all-affiliates-value") {
                checkbox.checked = true;
              }
            });
          }
        }
      }

      // Chiama la funzione al caricamento della pagina
      setAllDomainChecked();
    }
  };

}(Drupal));
