const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.webpackConfig(webpack => {
    return {
        plugins: [ new webpack.EnvironmentPlugin ( ['MIX_ENV_MODE'] ) ]
    };
});

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/web.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/web.css');

if (mix.inProduction()) {
    mix.version();
}