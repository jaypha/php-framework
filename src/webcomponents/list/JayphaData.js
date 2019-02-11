// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

import { bindableArray, bindableAssoc } from "./bindable.js";

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
    let parsedStuff;

    switch (type)
    {
      case "application/json":
        parsedStuff = JSON.parse(stuff);
        break;
      default:
        console.log("Type '"+type+"' not supported");
        this.data = [];
        return;
    }

    let a = [];
    for (let i=0; i<parsedStuff.length; ++i)
      a.push(bindableAssoc(parsedStuff[i]));
    this.data = bindableArray(a);
  }

  sort(fn) { this.data.sort(fn); }
}

customElements.define('jaypha-data', JayphaData);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
