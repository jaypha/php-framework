//----------------------------------------------------------------------------
// ES6 Module
//----------------------------------------------------------------------------
// This class acts as localised cache for remotely fetched data for a two
// dimensional grid.
//
// The primary function, promiseMeData, returns a Promise that, when resolved,
// contained the desired data.
//
// If the data is already locally stored, the promise resolves immediately.
// Otherwise, the function dataFetcher is called, which also returns a
// promise. When that promise resolves, the cache's proimise resolves.
//----------------------------------------------------------------------------
// The class is constructed with a callback function with the following
// synopsis
//
// synopsis: dataFetcher(viewPort)
//
// returns: a Promise that resolves with the data fetched.
//
//
// eg dataFetcher({row:0,col:0,numRows:5,numCols:6})
//    .then((data) => { do stuff });
//
// DataCache.promiseMeData also has the same synopsis.
//----------------------------------------------------------------------------
// Within this class:
// 'viewPort' is an object that defines a box.
// { row, col, numRows, numCols }
//----------------------------------------------------------------------------

class DataCache
{
  constructor(dataFetcher) // dataFetcher = function(viewPort);
  {
    this.dataFetcher = dataFetcher;
    this.storedData = [];
  }

  promiseMeData(viewPort)
  {
    return new Promise((resolve,reject) => {
      let xRight = viewPort.row + viewPort.numRows;
      let yBottom =  viewPort.col + viewPort.numCols;
      for (let i = viewPort.row; i < xRight; ++i)
      {
        if (typeof this.storedData[i] !== 'undefined')
        {
          for (let j = viewPort.col; j < yBottom; ++j)
          {
            if (typeof this.storedData[i][j] === 'undefined')
            {
              this.dataFetcher(viewPort)
              .then((fetchedData) => {
                this._insertFetchedData(fetchedData, viewPort);
                resolve(fetchedData);
              })
              .catch(() => reject());
              return;
            }
          }
        }
        else
        {
          this.dataFetcher(viewPort)
          .then((fetchedData) => {
            this._insertFetchedData(fetchedData, viewPort);
            resolve(fetchedData);
          })
          .catch(() => reject());
          return;
        }
      }
      // data already contained.
      let retrievedData = [];
      {
        for (let i = viewPort.row; i < xRight; ++i)
        {
          retrievedData.push(this.storedData[i].slice(viewPort.col,yBottom));
        }
      }
      resolve(retrievedData);
    });
  }

  _insertFetchedData(fetchedData, viewPort)
  {
    let xRight = viewPort.row + viewPort.numRows;
    let yBottom =  viewPort.col + viewPort.numCols;
    let row=0,col;

    for (let i = viewPort.row; i < xRight; ++i)
    {
      if (typeof this.storedData[i] === 'undefined')
        this.storedData[i] = [];
      col=0;
      for (let j = viewPort.col; j < yBottom; ++j)
      {
        this.storedData[i][j] = fetchedData[row][col];
        ++col;
      }
      ++row;
    }
    //console.log(this.storedData);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

