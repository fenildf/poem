const path = require('path');
const VueLoadPlugin = require('vue-loader/lib/plugin');
const webpack = require('webpack');
const HTMLPlugin = require('html-webpack-plugin');

const config = {
  mode: "development",
  target:'web',
  entry: path.resolve(__dirname,'src/poem/authors/authors.js'),
  output: {
    filename: "js/authors.js",
    path: path.resolve(__dirname,'dist')
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader:'vue-loader'
      },
      {
        test: /\.less$/,
        use: [
          'style-loader',
          'css-loader',
          'less-loader'
        ]
      },
      {
        test:/\.(ttf|svg|eot|woff|woff2|png)\w*/,
        loader:'file-loader'
      }
    ]
  },
  plugins: [
    new VueLoadPlugin(),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'authors.html'
    })
  ]
};

module.exports = config;