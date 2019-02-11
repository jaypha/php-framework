// Client side javascript
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

class JayphaList extends HTMLElement
{

  get columnOrder() { return this.getAttribute("columnorder").trim().replace(/\s+/g, ' ').split(" "); }
  set columnOrder(v) { this.setAttribute("columnorder", v.join(" ")); }

  //-------------------------------------------------------

  get sortby() {
    if (this.hasAttribute("sortby"))
    {
      let s = this.getAttribute("sortby").trim().replace(/\s+/g, " ").split(" ");
      let x =  { column: s[0], dir: "up" };
      if (typeof(s[1]) !== "undefined")
      {
        let dir = s[1];
        if (!(dir == 'up' || dir == 'asc' || dir == 'true' || dir == 't' || dir == 1 || dir === true))
          x.dir = "down";
      }
      return x;
    }
    else
      return null;
  }

  set sortby(v)
  {
    if (!("dir" in v))
      this.setAttribute("sortby", v.column);
    else      
      this.setAttribute("sortby", v.column+" "+v.dir);
  }

  //-------------------------------------------------------

  get columnDefs()
  {
    let defs = {};
    let es = this.querySelectorAll("jaypha-column");
    if (es.length)
    {
      es.forEach(
        function(e) {
          let i = e.getAttribute("name");
          defs[i] = e;
        }
      );
    }
    return defs;
  }

  //-------------------------------------------------------

  constructor()
  {
    super(); // always call super() first in the ctor.
  }

  //-------------------------------------------------------
  
  connectedCallback()
  {
    // Create the table
    document.addEventListener("DOMContentLoaded", () =>
    {
      let fn = () => this.refresh();

      this.dataElement = this.querySelector("jaypha-data");
      this.dataElement.data.addEventListener("add", fn);
      this.dataElement.data.addEventListener("remove", fn);
      this.dataElement.data.addEventListener("rearrange", fn);

      this.tableElement = this.querySelector("table");
      if (!this.tableElement)
      {
        this.tableElement = document.createElement("table");
        this.appendChild(this.tableElement);
      }
      this.refresh();
    });
  }

  //-------------------------------------------------------

  sortList()
  {
    console.log('sortTable');
  }

  //-------------------------------------------------------

  getSortClass(col)
  {
    let sortColumn = this.sortby;
    if (sortColumn === null || sortColumn.column != col)
      return 'sortable';
    else if (sortColumn.dir == "up")
      return 'sorted-up';
    else
      return 'sorted-down';
  }

  //-------------------------------------------------------

  setSort(idx)
  {
    let sortColumn = this.sortby;
    if (sortColumn === null || sortColumn.column != idx)
      this.sortby = { column: idx };
    else
    {
      if (sortColumn.dir == "down")
        this.sortby = { column: idx };
      else
        this.sortby = { column: idx, dir: "down" };
    }
    this.reSort();
  }

  reSort()
  {
    let sortColumn = this.sortby;
    if (sortColumn != null)
    {
      this.dataElement.sort(
        this.columnDefs[sortColumn.column]
          .getSortFn(sortColumn.dir == "down")
      );

/*      
      let sortAs = this.columnDefs[col].sortAs;
      switch(sortAs)
      {
        case "string":
          this.fn = (a,b) => a[col].localeCompare(b[col]);
          break;
        case "number":
          this.fn = (a,b) => a[col] - b[col];
          break;
        default: // sortAs describes a function
          this.fn = new Function('a','b', sortAs);
      }
      this.dataElement.sort(this.fn, sortColumn.dir == "down");
*/
    }
  }

  refresh()
  {
    this.tableElement.innerHTML = "";
    this.tableElement.appendChild(this.createColgroup());
    this.tableElement.appendChild(this.createHead());
    this.tableElement.appendChild(this.createBody());
  }

  //-------------------------------------------------------

  createColgroup()
  {
    let columnDefs = this.columnDefs;
    let colgroup = document.createElement("colgroup");

    this.columnOrder.map((idx) =>
    {
      if (!(idx in columnDefs))
        console.log("Error: column order '"+idx+"' is not in column definitions");
      else {
        let col = document.createElement("col");
        col.setAttribute("style", columnDefs[idx].origStyle);
        col.className = columnDefs[idx].className;
        colgroup.appendChild(col);
      }
    });
    return colgroup;
  } 
    
  //-------------------------------------------------------

  createHead()
  {
    let self = this;

    let columnDefs = this.columnDefs;
    let thead = document.createElement("thead");
    let tr = document.createElement("tr");
    this.columnOrder.map
    (
      function(idx) 
      {
        if (!(idx in columnDefs))
          console.log("Error: column order '"+idx+"' is not in column definitions");
        else {
          let th = document.createElement("th");
          th.className = self.getSortClass(idx);
          th.innerHTML = columnDefs[idx].label;
          th.onclick = (e) => self.setSort(idx);
          tr.appendChild(th);
        }
      }
    );
    thead.appendChild(tr);
    return thead;
  }

  //-------------------------------------------------------

  createBody()
  {
    let tbody = document.createElement("tbody");
    let l = this.dataElement.data.length;
    for (let i=0; i<l; ++i)
      tbody.appendChild(this.createRow(this.dataElement.data[i]));
    return tbody;
  }

  //-------------------------------------------------------

  createRow(row)
  {
    let columnDefs = this.columnDefs;

    let tr = document.createElement("tr");

    for (let i=0; i<this.columnOrder.length; ++i)
    {
      let td = document.createElement("td");

      columnDefs[this.columnOrder[i]].addCellContent(row, td);
      tr.appendChild(td);
    }
      
    return tr;
  }
}

customElements.define('jaypha-list', JayphaList);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
