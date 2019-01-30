//----------------------------------------------------------------------------
// Editable element
//----------------------------------------------------------------------------

//---------------------------------------------------------
// Template

let jaypha_editable_template = document.createElement("template");
jaypha_editable_template.innerHTML = `<pre style='margin:0; overflow-y: auto; height: 100%; max-height: inherit; min-height: inherit;' contenteditable></pre>`;

//---------------------------------------------------------
// Class

class JayphaEditable extends HTMLElement
{
  getContent()
  {
    return this.pre.innerText;
  }

  setContent(text)
  {
    this.pre.innerText = text;
  }

  connectedCallback()
  {
    this.style.display='block';
    let c = this.innerHTML;
    this.innerHTML = "";
    this.appendChild(jaypha_editable_template.content.cloneNode(true));
    this.pre = this.querySelector("pre");
    this.pre.innerText = c;
  }
}

customElements.define('jaypha-editable', JayphaEditable);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
