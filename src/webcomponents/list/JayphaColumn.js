// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------


class JayphaColumn extends HTMLElement
{
  get name() { return this.getAttribute("name"); }

  //-----------------------------------------------

  get sortAs()
  {
    if (this.hasAttribute("sortas"))
      return this.getAttribute("sortas");
    else
      return "string";
  }

  //-----------------------------------------------

  get label()
  {
    let label = this.querySelector("label");
    if (label)
      return label.innerHTML;
    else
      return this.innerHTML;
  }

  //-----------------------------------------------

  constructor()
  {
    super(); // always call super() first in the ctor.
  }

  //-----------------------------------------------

  getCellContent(row)
  {
    if (this.hasAttribute("format"))
    {
      this.fn = new Function('row',this.getAttribute("format"));
      return this.fn(row);
    }
    else
      return row[this.name];
  }

  //-----------------------------------------------

  connectedCallback()
  {
    this.origStyle = this.getAttribute("style");
    this.style.display = "none";
  }
}

customElements.define('jaypha-column', JayphaColumn);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

