// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

function icoMoon(name)
{
  switch (name)
  {
    case "pending":
      return getSvg("icon-circle", "icon-pending");
    default:
      return getSvg(`icon-${name}`, `icon-${name}`);
  }
}

function getSvg(iconName, iconClass)
{
  return `<svg class="icon ${iconClass}"><use xlink:href="/assets/symbol-defs.svg#${iconName}"></use></svg>`;
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

