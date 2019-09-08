// Require path.
const path = require( 'path' );
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const { VueLoaderPlugin } = require('vue-loader');

const proxy_url = "http://localhost:9999";
// Configuration object.
const config = {
	// Create the entry points.
	// One for frontend and one for the admin area.
	entry: {
		// frontend and admin will replace the [name] portion of the output config below.
		main: './src/frontend/frontend.js',
	},

	// Create the output files.
	// One for each of our entry points.
	output: {
		// [name] allows for the entry object keys to be used as file names.
		filename: 'js/[name].js',
		// Specify the path to the JS files.
		path: path.resolve( __dirname, 'dist' )
  },


  plugins: [
		new VueLoaderPlugin(),
		new BrowserSyncPlugin({
      // browse to http://localhost:3000/ during development,
      // ./public directory is being served
      host: 'localhost',
      port: 3000,
      proxy: proxy_url
    })
	],

	resolve: {
    extensions: ['.js', '.vue', '.css']
  },

	// Setup a loader to transpile down the latest and great JavaScript so older browsers
	// can understand it.
	module: {
		rules: [
			{
				// Look for any .js files.
				test: /\.js$/,
				// Exclude the node_modules folder.
				exclude: /node_modules/,
				// Use babel loader to transpile the JS files.
				loader: 'babel-loader'
			},
			{
        test: /\.vue$/,
        use: 'vue-loader'
			},
			{
				test: /\.css$/,
				use: [
					'vue-style-loader',
					'css-loader'
				]
			}

		],
	}
}

// Export the config object.
module.exports = config;
