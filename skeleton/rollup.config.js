//----------------------------------------------------------------------------
// ES6 Module
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

import resolve from 'rollup-plugin-node-resolve';
import commonjs from 'rollup-plugin-commonjs';

export default [
	{
		input: 'src/home/main.js',
		output: {
      file: 'assets/js/bundle.js',
			format: 'esm'
		},
		plugins: [
			resolve(),
			commonjs()
		]
	},
	{
		input: 'src/home/main.js',
		output: {
      file: 'assets/js/bundle.iife.js',
			format: 'iife'
		},
		plugins: [
			resolve(),
			commonjs()
		]
	}
];

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha
// License: BSL-1.0
// Authors: Jason den Dulk
//

