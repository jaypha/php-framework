//----------------------------------------------------------------------------
// Editable element
//----------------------------------------------------------------------------

//---------------------------------------------------------
// Template

let jaypha_editable_template = document.createElement("template");
jaypha_editable_template.innerHTML = `<input type='hidden'><pre style='margin:0; overflow-y: auto; height: 100%; max-height: inherit; min-height: inherit;' contenteditable></pre>`;

//---------------------------------------------------------
// Class

class JayphaEditable extends HTMLElement
{
  get value() { return this.pre.innerText; }
  set value(v) { this.pre.innerText = v; }


  getContent() { return this.value; }
  setContent(text) { this.value = text; }

  focus() { this.pre.focus(); }

  connectedCallback()
  {
    this.style.display='block';
    let c = this.innerHTML;
    this.innerHTML = "";
    this.appendChild(jaypha_editable_template.content.cloneNode(true));
    this.pre = this.querySelector("pre");
    //if (this.hasAttribute("autofocus"))
    //  this.pre.setAttribute("autofocus", this.getAttribute("autofocus"));
    this.pre.innerText = c;
    this.input = this.querySelector("input");
    this.input.setAttribute("name",this.getAttribute("name"));
  }
}

customElements.define('jaypha-editable', JayphaEditable);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
