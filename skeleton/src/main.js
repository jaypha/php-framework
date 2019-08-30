/*
 * Root file for compiling a javascript bundle using rollup.
 */

import '@jaypha/webcomponents';

// Import local files.

import './framework/import.js';


docReady.then(function()
{
  let forms = document.querySelectorAll("form.ajax-submit");
  [...forms].forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      App.formSubmit(form);
      return false;
    });
  });
});
