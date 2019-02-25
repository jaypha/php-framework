// Client side javascript
//----------------------------------------------------------------------------
// Make DOMContentLoader into a promise. Similar to jQuery's ready() function.
//----------------------------------------------------------------------------

docReady = new Promise(function(resolve,reject) {
  document.addEventListener("DOMContentLoaded", () => resolve(true));
});

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

