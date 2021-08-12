const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const mode = process.env.NODE_ENV == 'production' ? 'production' : 'development'

module.exports = {
  mode: mode,
  entry: './themes/rm-theme/assets/src/main.js',
  output: {
    filename: mode === 'production' ? 'main.[contenthash].js' : 'main.js',
    path: path.resolve(__dirname, 'themes/rm-theme/assets/dist'),
  },
  plugins: [
    new CleanWebpackPlugin(
      {
        cleanOnceBeforeBuildPatterns: [ '**/*', '!.gitkeep' ]
      }
    )
  ]
};