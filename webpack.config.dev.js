var webpack = require('webpack');
var path = require('path');
var VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
    entry: './public/src/index.js',
    output: {
        path: path.resolve(__dirname, 'public/dist'),
        filename: 'index.js'
    },
    module: {
        rules: [{
           test: /\.vue$/,
           loader: 'vue-loader'
        }, {
            test: /\.css$/,
            use: [
                'vue-style-loader',
                'css-loader'
            ]
        }]
    },
    watch: true,
    watchOptions: {
        ignored: /node_modules/
    },
    watchOptions: {
        poll: 1000
    },  
    plugins: [
        new VueLoaderPlugin(),
        new webpack.EnvironmentPlugin({
            'ENV': 'development',
            'ROOT_API': 'http://192.168.10.10',
            'API_URL': 'http://192.168.10.10/api'
        })
    ]
}
