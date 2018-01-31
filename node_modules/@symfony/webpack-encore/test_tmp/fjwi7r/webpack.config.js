// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
    // directory where all compiled assets will be stored
    .setOutputPath('build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/')

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // enable support for PostCSS (https://github.com/postcss/postcss)
    .enablePostCssLoader()
    ;
    
    // export the final configuration
    module.exports = Encore.getWebpackConfig();
    