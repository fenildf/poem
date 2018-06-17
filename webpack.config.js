const path = require('path');
const VueLoadPlugin = require('vue-loader/lib/plugin');
const webpack = require('webpack');
const HTMLPlugin = require('html-webpack-plugin');
const miniCSS = require('mini-css-extract-plugin');
const clean = require('clean-webpack-plugin');
const isDev = process.env.NODE_ENV === 'development';

const config = {
  mode: isDev ? 'development' : 'production',
  target:'web',
  entry: {
    // 'babel-polyfill':'babel-polyfill',
    index: './src/index.js',
    authors: './src/poem/authors/authors.js',
    poems: './src/poem/poems/poems.js',
    search: './src/poem/search/search.js',
    article: './src/poem/article/article.js'
    //,
    // lib: ['vue/dist/vue.js','axios',]
  },
  output: {
    filename: "js/[name].[chunkhash:8].js",
    path: path.resolve(__dirname,'dist')
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader:'vue-loader'
      },
      {
        test: /\.css$/,
        use: [
          'style-loader',
          // miniCSS.loader,
          'css-loader'
        ]
      },
      {
        test: /\.less$/,
        use: [
          'style-loader',
          // miniCSS.loader,
          'css-loader',
          'less-loader'
        ]
        
      },
      {
        test:/\.(ttf|svg|eot|woff|woff2|png)\w*/,
        use: [{
          loader:'file-loader',
          options:{
            name: 'font/[name].[hash:8].[ext]'
          }
          // ,
          // options: {
          //   publicPath: '../'
          // }
        }]
      },
      {
        test: /\.js$/,
        use: {
          loader: 'babel-loader'
        },
        exclude: path.resolve(__dirname,'node_modules/')
      }
    ]
  },
  plugins: [
    new clean(['dist']),
    new VueLoadPlugin(),
    // new miniCSS({
    //   filename:'css/[name].[chunkhash:8].css'
    // }),
    new HTMLPlugin({
      template: './src/home.html',
      filename: './home.html',
      chunks: ['lib','index']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'poems.html',
      chunks: ['lib','poems']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'authors.html',
      chunks: ['lib','authors']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'article.html',
      chunks: ['lib','article']
    }),
    new HTMLPlugin({
      template: './src/poem/article/article.html',
      filename: 'search.html',
      chunks: ['lib','search']
    })
  ],
  optimization: {
    splitChunks: {
      cacheGroups: {
        lib: {
          name: 'lib',
          filename: 'js/[name].[chunkhash:8].js',
          // test: /\.js$/,
          minChunks: 2,
          chunks: 'initial'
        }
        // ,
        // styles: {
        //   name: 'styles',
        //   test: /\.(less|css)$/,
        //   chunks: 'all',
        //   enforce: true
        // }
      }
    }
  }
};

module.exports = config;