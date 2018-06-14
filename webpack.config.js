const path = require('path');
const VueLoadPlugin = require('vue-loader/lib/plugin');
const webpack = require('webpack');
const HTMLPlugin = require('html-webpack-plugin');

const config = {
  mode: "development",
  target:'web',
  entry: {
    index: path.resolve(__dirname,'src/index.js'),
    authors: path.resolve(__dirname,'src/poem/authors/authors.js'),
    poems: path.resolve(__dirname,'src/poem/poems/poems.js'),
    search: path.resolve(__dirname,'src/poem/search/search.js'),
    article: path.resolve(__dirname,'src/poem/article/article.js')
  },
  output: {
    filename: "js/[name].js",
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
      template: './src/home.html',
      filename: './home.html',
      chunks: ['index']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'poems.html',
      chunks: ['poems']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'authors.html',
      chunks: ['authors']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'article.html',
      chunks: ['article']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'search.html',
      chunks: ['search']
    })
  ]
};

module.exports = config;