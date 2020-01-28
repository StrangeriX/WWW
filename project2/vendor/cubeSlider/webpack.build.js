var merge 	= require('webpack-merge');
var common 	= require('./webpack.common.js');
var path 	= require('path');

module.exports = merge(common, {
	entry: {
		slider: 	'./src/build.js'
	},
	mode: 'production',
	output: {
		filename: '[name].bundle.js',
		path: path.resolve(__dirname, 'build')
	}
});