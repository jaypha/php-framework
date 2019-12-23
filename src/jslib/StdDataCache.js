//----------------------------------------------------------------------------
// ES6 Module
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

export class StdDataCache
{
  constructor(id)
  {
    this.data = JSON.parse(document.getElementById(id).innerText);
    this.numRows = this.data.length;
    this.numCols = this.data[0].length;
  }

  async update(row, col, numRows, numCols)
  {
  }

  getContent(row, col)
  {
    return this.data[row][col];
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

