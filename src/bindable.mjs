// Client side javascript
//----------------------------------------------------------------------------
// Binding without the bloat
//----------------------------------------------------------------------------

// Binding works by allowing event handler to be attached to the value in
// question. When the value changes, the event is fired.


//----------------------------------------------------------------------------
// BindableValue is an object encapsulating a single value. You need to use
// get and set as simply sddigning will replace the object. Attach listeners
// using addEventListener. Every time set is called, the event fires.

export class BindableValue
{
  get() { return this._value; }

  set(v) {
    if (v !== this._value)
    {
      let prev = this._value;
      this._value = v;
      for (let i=0; i<this._listeners.length; ++i)
        (this._listeners[i])(v, prev);
    }
  }

  addEventListener(listener) {
    this._listeners.push(listener);
  }

  trigger() {
    for (let i=0; i<this._listeners.length; ++i)
      (this._listeners[i])(this._value, this._value);
  }

  bindWidget(w) {
    this.addEventListener(((v) => w.value=v) );
    w.addEventListener('change', (ev) => this.set(w.value));
  }

  constructor(initVal) {
    this._listeners = [];
    this._value = initVal;
  }
}

//----------------------------------------------------------------------------
// bindableObject() returns an object that listens for when a property is
// added or removed. You need to use obj.remove(), not delete. To have the
// individual properties bindable, use BindableValue. There are two types of
// event: 'add' and 'remove'.

// NOTE: This is a function that returns an object. Do not use 'new'.

export function bindableObject(initVal)
{
  if (typeof(initVal) == "undefined")
    initVal = {};
  return new Proxy({
    _props: initVal,
    _listeners: { add:[], remove:[] }
  },
  {
    set: function(obj,prop,val)
    {
      let triggerEvent = false;
      if (typeof(obj._props[prop]) == "undefined")
        triggerEvent = true;
      obj._props[prop] = val;
      if (triggerEvent)     
        for (let i=0; i<obj._listeners.add.length; ++i)
          (obj._listeners.add[i])(prop);
      return true;
    },
    get: function(obj, prop)
    {
      if (prop == "remove")
        return ((p) => {
          delete obj._props[p];
          for (let i=0; i<obj._listeners.remove.length; ++i)
            (obj._listeners.remove[i])(p);
        });
      if (prop == "addEventListener")
        return ((type,listener) => obj._listeners[type].push(listener));
      return obj._props[prop];
    }
  });
}

//----------------------------------------------------------------------------
// bindableArray() is similar to BindableObject, but for arrays. Adding,
// removing and rearranging the elements will trigger the 'add', 'remove' and
// 'rearrange' events respectively.

export function bindableArray(initVal)
{
  if (typeof(initVal) == "undefined")
    initVal = [];
  return new Proxy({
    _array: initVal,
    _listeners: { add:[], remove:[], rearrange: [] }
  },
  {
    get: function(target, prop)
    {
      if (prop == "addEventListener")
        return ((type,listener) => target._listeners[type].push(listener));
      const val = target._array[prop];
      if (typeof val == "function") {
        if (["reverse", "sort"].includes(prop))
          return function (el) {
            let result = Array.prototype[prop].apply(target._array, arguments);
            for (let i=0; i<target._listeners.rearrange.length; ++i)
              (target._listeners.rearrange[i])();
            return result;
          }
        else if (["pop", "shift"].includes(prop))
          return function (el) {
            let result = Array.prototype[prop].apply(target._array, arguments);
            for (let i=0; i<target._listeners.remove.length; ++i)
              (target._listeners.remove[i])();
            return result;
          }
        else if (["push", "unshift"].includes(prop))
          return function (el) {
            let result = Array.prototype[prop].apply(target._array, arguments);
            for (let i=0; i<target._listeners.add.length; ++i)
              (target._listeners.add[i])();
            return result;
          }
        else if (["splice"].includes(prop))
          return function (el) {
            let len = target._array.length;
            let result = Array.prototype[prop].apply(target._array, arguments);
            if (result.length > 0)
              for (let i=0; i<target._listeners.remove.length; ++i)
                (target._listeners.remove[i])();
            if (len - result.length < target._array.length)
              for (let i=0; i<target._listeners.add.length; ++i)
                (target._listeners.add[i])();
            return result;
          }
        return val.bind(target._array);
      }
      return val;
    }
  });
}

//----------------------------------------------------------------------------
// bindableAssoc returns an object where all the properties are
// BindableValues. It does not fire an event when you add and remove a
// property, but you can use addEventListener to add an event to a particular
// property. This object can be passed on to other parts of the code that are
// not aware of the objects nature, (however you still need to use remove()).

export function bindableAssoc(initVal)
{
  let x = {
    _props: {},
    _listeners: {},
    addEventListener: function(prop, fn)
    {
      if (typeof(this._listeners[prop]) == "undefined")
        this._listeners[prop] = [];
      this._listeners[prop].push(fn);
    }
  }

  if (typeof(initVal) != "undefined")
    for (let i in initVal)
      x._props[i] = new BindableValue(initVal[i]);

  return new Proxy(
    x,
    {
      set: function(target,prop,val)
      {
        if (typeof(target._props[prop]) == "undefined")
          target._props[prop] = new BindableValue(val);
        else 
          target._props[prop].set(val);
        return true;
      },
      get: function(target, prop)
      {
        if (prop == "addEventListener")
          return (p,v) => {
            if (typeof(target._props[p]) == "undefined")
              target._props[p] = new BindableValue();
            target._props[p].addEventListener(v);
          };
        else if (prop == "bindWidget")
          return (p,w) => {
            if (typeof(target._props[p]) == "undefined")
              target._props[p] = new BindableValue();
            target._props[p].bindWidget(w);
          };
        else if (prop == "remove")
          return ((p) => delete target._props[p]);
        else
          return target._props[prop].get();
      }
  });
}

//----------------------------------------------------------------------------
// A convenience function that updates the innards of an element in response
// to a change.

export function setInnerHtml(r,sel) {
  return function(v) {
    let l = r.querySelectorAll(sel);
    for (let i=0; i<l.length; ++i)
      l[i].innerHTML = v;
  }
};

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

