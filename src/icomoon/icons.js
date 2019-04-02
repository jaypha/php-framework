// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

App.icomoonSvg = function(name, cssClass)
{
  return `<svg class="icon icon-${cssClass}"><use xlink:href="${App.assetDir}/icomoon/symbol-defs.svg#icon-${name}"></use></svg>`;
}

App.icomoonButton = function(name, cssClass)
{
  let button = document.createElement("button");
  button.innerHTML = App.icomoonSvg(name, cssClass);
  button.classList.add("svg-button");
  return button;
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

