var path = require('path');
var merge = require('webpack-merge');
var common = require('./webpack.common.js');

module.exports = merge(common, {
	entry: {
		app: 	'./src/index.js'
	},
	mode: 		'development',
	watch: 		true,
	devServer: {
		contentBase: 	path.join(__dirname, 'dist'),
		compress: 		false,
		port: 			3000
	},
	output: {
		filename: '[name].bundle.js',
		path: path.resolve(__dirname, 'dist')
	}
})