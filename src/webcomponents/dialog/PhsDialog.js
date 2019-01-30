// Client side javascript
//----------------------------------------------------------------------------
// A custom replacement for <dialog>.
//----------------------------------------------------------------------------

let tmpl = document.createElement('template');
tmpl.innerHTML = `
<style>

:host {
    display: none;
    position: fixed;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
 }

  .caption {
    display: flex;
    align-items: center;
    padding:5px;
  }

  .caption span:first-child { flex-grow: 1 }

  .content {
    padding: 20px;
  }

  .close {
  }

  .close:hover,
  .close:focus {
      cursor: pointer;
  }

  .modal-box {
      position: relative;
      top: 20%;
      left: 50%;
      transform: translate(-50%, 0);
      background-color: #EEE;
      margin-left: auto;
      margin-right: auto;
      padding: 0;
  }
</style>

<div class="modal-box">
  <div class='caption'>
    <span><slot name='title'>Title</slot></span>
    <span class="fa fa-window-close close" aria-hidden='true'>X</span>
  </div>
  <div class='content'>
   <slot name='content'></slot>
  </div>
</div>
`;

ShadyCSS.prepareTemplate(tmpl, 'phs-dialog');
class PhsDialog extends HTMLElement
{
   constructor() {
      super(); // always call super() first in the ctor.
    }

  connectedCallback() {
      ShadyCSS.styleElement(this);
      let shadowRoot = this.attachShadow({mode: 'open'});
      let self=this;
      shadowRoot.appendChild(tmpl.content.cloneNode(true));
      //this.appendChild(tmpl.content.cloneNode(true));
      shadowRoot.querySelector('.close').addEventListener('click', e => {
        self.close();
      });
  }

  showModal()
  {
    this.style.display = 'block';
  }

  close()
  {
    this.style.display = 'none';
  }

  show()
  {
  }
}

customElements.define('phs-dialog', PhsDialog);

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima health Solutions Pty LTd. All rights reserved.
// Authors: Jason den Dulk
//

