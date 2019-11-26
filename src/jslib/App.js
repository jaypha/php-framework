window.docReady = new Promise
(
  function(resolve,reject)
  {
    document.addEventListener
    (
      "DOMContentLoaded",
      function()
      {
        resolve(true);
      }
    );
  }
);

window.App = 
{
  alert: function(msg)
         {
           window.alert(msg);
         },
  assetDir:"/assets",
  dialogs:[]
};

document.cookie="tzoffset="+((new Date()).getTimezoneOffset()*-60)+"; path=/";

