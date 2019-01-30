
let phs_spinput_template = document.createElement("template");
phs_spinput_template.innerHTML = `
  <input type='text'  style='min-width:30px; flex-grow:1; flex-shrink:1'/>
  <span class='phs-spinput-up' style='cursor: pointer;'>&#9650;</span>
  <span class='phs-spinput-dn' style='cursor: pointer;'>&#9660;</span>
`;

class PhsSpinput extends HTMLElement
{
  get required() { return this.inputElement.requried; }
  set required(v) { this.inputElement.required = v; }

  get autofocus() { return this.inputElement.autofocus; }
  set autofocus(v) { this.inputElement.autofocus = v; }

  get placeholder() { return this.inputElement.placeholder; }
  set placeholder(v) { this.inputElement.placeholder = v; }

  get value() { return +this.inputElement.value; }
  set value(v) { this.inputElement.value = v; }

  get step() { if (this.hasAttribute("step")) return +this.getAttribute("step"); else return 1; }
  set step(v) { this.setAttribute("step",v); }

  get page() { if (this.hasAttribute("page")) return +this.getAttribute("page"); else return 10; }
  set page(v) { this.setAttribute("page",v); }

  get min() { return this.getAttribute("min"); }
  set min(v) { this.setAttribute("min",v); }

  get max() { return this.getAttribute("max"); }
  set max(v) { this.setAttribute("max",v); }

  constructor()
  {
    super(); // always call super() first in the ctor.

  }
  
  connectedCallback()
  {
    let self = this;

    this.style.display = "inline-flex";

    this.appendChild(phs_spinput_template.content.cloneNode(true));
    this.inputElement = this.querySelector("input");

    if (this.hasAttribute("name"))
      this.inputElement.name = this.getAttribute("name");
    if (this.hasAttribute("value"))
      this.inputElement.value = this.getAttribute("value");
    if (this.hasAttribute("placeholder"))
      this.inputElement.placeholder = this.getAttribute("placeholder");

    this.inputElement.required = this.hasAttribute("required");
    this.inputElement.autofocus = this.hasAttribute("autofocus");

    this.inputElement.addEventListener("input", function()
    {
      let val = this.value;

      if (val == '')
      {
        if (this.required)
          this.setCustomValidity("Please fill this field");
        else
          this.setCustomValidity("");
      }
      else
      {
        if (!/^[+-]?[0-9]+(\.[0-9]+)?$/.test(val))
          this.setCustomValidity("Entry is not valid");
        else if (this.hasAttribute('max') && +val > this.max)
          this.setCustomValidity("Entry is too high");
        else if (this.hasAttribute('min') && +val < self.min)
          this.setCustomValidity("Entry is too low");
        else
          this.setCustomValidity("");
      }
    });

    this.inputElement.addEventListener("keydown", function(ev)
    {
      if (ev.ctrlKey) return; // Allow control keys (paste, cut, etc);
      switch (ev.keyCode)
      {
        case 38: // Up key
          self.moveStep(1);
          break;
        case 40: // Down key
          self.moveStep(-1);
          break;
        case 33: //pgUp key
          self.movePage(1);
          break;
        case 34: // pgDn key
          self.movePage(-1);
          break;
        default: // All others.
          break;
      }
    });

    this.querySelector(".phs-spinput-up").addEventListener
    (
      "click",
      function() { self.moveStep(1); }
    );

    this.querySelector(".phs-spinput-dn").addEventListener
    (
      "click",
      function() { self.moveStep(-1); }
    );

  }

  moveStep(count) { this.move(count*this.step); }
  movePage(count) { this.move(count*this.page); }

  move(count)
  {
    let curVal = this.value;
    curVal += count;
    if (this.hasAttribute('max') && curVal > this.max)
     curVal = this.max;
    if (this.hasAttribute('min') && curVal < this.min)
     curVal = this.min;
    this.value = curVal;
  }

  stepUp() { this.moveStep(1); }
  stepDown() { this.move(-1); }
}


customElements.define('phs-spinput', PhsSpinput);

