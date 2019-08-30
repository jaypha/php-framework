import resolve from 'rollup-plugin-node-resolve';
import commonjs from 'rollup-plugin-commonjs';

export default [
	{
		input: 'src/polyfills.ie.js',
		output: {
			name: 'library',
      file: 'dist/polyfills.ie.js',
			format: 'umd'
		},
		plugins: [
			resolve(),
			commonjs()
		]
	},
	{
		input: 'src/polyfills.js',
		output: {
			name: 'library',
      file: 'dist/polyfills.js',
			format: 'umd'
		},
		plugins: [
			resolve(),
			commonjs()
		]
	}
];
