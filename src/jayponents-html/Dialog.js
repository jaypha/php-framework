//----------------------------------------------------------------------------
// ES6 Module
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

App.setUpDialog = function(dlgId)
{
  let dlg = document.getElementById(dlgId);
  App.dialogs[dlgId] = dlg;
  dialogPolyfill.registerDialog(dlg);
  let cancelBtns = dlg.querySelectorAll('button[value=cancel]');
  [...cancelBtns].forEach(function (btn) {
    btn.addEventListener('click', function() { dlg.close(); });
  });
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima health Solutions Pty Ltd. All rights reserved.
// Authors: Jason den Dulk
//
