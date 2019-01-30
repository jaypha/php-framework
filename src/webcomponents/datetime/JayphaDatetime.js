// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

let jaypha_datetime_template = document.createElement("template");
jaypha_datetime_template.innerHTML = 
`<input type='hidden' name=''><input type='date'> <input type='time'>`;

//---------------------------------------------------------
// Class

class JayphaDatetime extends HTMLElement
{
  connectedCallback()
  {
    this.appendChild(jaypha_datetime_template.content.cloneNode(true));

    this.name = this.getAttribute("name");
    this.retElement = this.querySelector("input[type=hidden]");
    this.retElement.setAttribute("name", this.name);
    this.timeElement = this.querySelector("input[type=time]");
    this.timeElement.addEventListener("change", () => this.fillValue());
    this.dateElement = this.querySelector("input[type=date]");
    this.dateElement.addEventListener("change", () => this.fillValue());
    if (this.hasAttribute("required"))
    {
      console.log("requird");
      this.timeElement.required = true;
      this.dateElement.required = true;
    }
    
    let val = this.getAttribute("value");
    if (val)
    {
      let vals=val.split("T");
      this.dateElement.value = vals[0];
      let times = vals[1].split(":");
      this.timeElement.value = times[0] + ":" + times[1];
      this.fillValue();
    }
  }

  fillValue()
  {
    let v1 = this.dateElement.value;
    let v2 = this.timeElement.value;
    if (v1 == "" || v2 == "")
      this.retElement.value = "";
    else
      this.retElement.value = v1 + "T" + v2 + ":00";
  }
}

customElements.define('jaypha-datetime', JayphaDatetime);

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

