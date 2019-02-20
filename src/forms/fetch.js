// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

function submitForm(form)
{
  stdFetch
  (
    form.getAttribute("action"),
    "post",
    new FormData(form),
    function(data)
    {
      if ("redirect" in data)
        window.location.href = data.redirect;
    }
  );
  return false;
}
    
function stdFetch(url,method = 'get', data = null,successFn = null,failureFn = null)
{
  let params = { credentials: "include", method: method };
  if (data !== null)
    params.body = data;
  
  fetch(url,params)
  .then((resp) => resp.json()) // Transform the data into json
  .then(function(data)
  {
    if (data.message) alert(data.message);
    if (data.success)
    {
      if (successFn)
        successFn(data);
    }
    else
    {
      if (failureFn)
        failureFn(data);
    }
  })
  .catch(function(error)
  {
    console.log(error);
    alert("Server Error");
  });
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

