import resolve from 'rollup-plugin-node-resolve';
import commonjs from 'rollup-plugin-commonjs';

export default [
	{
		input: 'src/polyfills.ie.js',
		output: {
			name: 'library',
      file: 'dist/ie/polyfills.ie.js',
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
      file: 'dist/modern/polyfills.js',
			format: 'umd'
		},
		plugins: [
			resolve(),
			commonjs()
		]
	}
];
