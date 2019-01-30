// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------


class JayphaData extends HTMLElement
{
  constructor()
  {
    super(); // always call super() first in the ctor.
  }
  
  connectedCallback()
  {
    this.style.display = "none";

    let type = this.getAttribute("type");
    let stuff = this.innerText;
    switch (type)
    {
      case "application/json":
        this.data = JSON.parse(stuff);
        break;
      default:
        console.log("Type '"+type+"' not supported");
    }
  }
}

customElements.define('jaypha-data', JayphaData);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
