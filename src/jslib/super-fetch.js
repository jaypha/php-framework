//---------------------------------------------------------------------------
// ES6 Module
//---------------------------------------------------------------------------
// Dialog to capture a password
//---------------------------------------------------------------------------

let passwdDialogHtml =
"<form method='dialog'><h2>Supply Password</h2><p class='message'>&nbsp;</p><p><input name='password' type='password'></p><button type='button' value='ok'>OK</button><button type='button' value='cancel'>Cancel</button></form>";


function showPasswordDialog()
{
  return new Promise((s,f) => {
    let passwordDialog = document.createElement("dialog");
    passwordDialog.innerHTML = passwdDialogHtml;
    dialogPolyfill.registerDialog(passwordDialog);
    document.body.appendChild(passwordDialog);
    passwordDialog.showModal();
    s(passwordDialog);
  })
}

//---------------------------------------------------------------------------
// 'touches' a person's login status on the server.

let reloginUrl = "relogin.php";

function relogin(password)
{
  return fetch(
    reloginUrl,
    {
      method: "POST",
      mode: "cors",
      credentials: "include",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "password="+encodeURIComponent(password)
    }
  )
  .then((response) => {
    if (response.ok) return response.json();
    throw new Error("Request failed: "+response.statusText);
  });
}

//---------------------------------------------------------------------------
// Cycles the password dialog's submission to the server

function dialogCycle(passwordDialog)
{
  return new Promise((s,f) => {
    let okButton = passwordDialog.querySelector("[value=ok]");
    let cancelButton = passwordDialog.querySelector("[value=cancel]");
    okButton.addEventListener(
      "click",
      () => relogin(passwordDialog.firstChild["password"].value)
            .then((data) => {
              if (data.success) {
                document.body.removeChild(passwordDialog);
                s(true);
              }
              else { alert(data.message); }
            })
    );
    cancelButton.addEventListener(
      "click",
      () => document.body.removeChild(passwordDialog)
    );
  });
}

//---------------------------------------------------------------------------
// A fetch replacement that will prompt for a password if requested by the 
// server's response.

App.superFetch = function(url, params)
{
  return fetch(url,params)
  .then((response) =>
  {
    if (response.ok) return response.json();
    throw new Error("Request failed: "+response.statusText);
  })
  .then(
    function(v)
    {
      if (v.message) alert(v.message);
      if (v.success) return v;
      else if (v.loginTimeout)
      {
        return showPasswordDialog()
        .then(dialogCycle)
        .then(() => superFetch(url,params));
      }
      else throw v;
    }
  );
}

//---------------------------------------------------------------------------
//

App.formSubmit = function(form)
{
  let params = {
    credentials: "include",
    method: "post",
    body: new FormData(form)
  };

  return App.superFetch
  (
    form.getAttribute("action"),
    params
  )
  .then((data) =>
  {
    if ("redirect" in data)
      window.location.href = data.redirect;
    else if ("reload" in data)
      window.location.reload();
    return data;
  });
}


App.justFetch = function(url)
{
  let params = {
    credentials: "include",
    method: "get"
  };
  return App.superFetch(url, params);
}

App.postFetch = function(url, bodyData)
{
  let params = {
    credentials: "include",
    method: "post",
    body: bodyData
  };
  return App.superFetch(url, params);
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//


