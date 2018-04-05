var gulp         = require( 'gulp' );

// CSS related plugins
var sass         = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );
var minifycss    = require( 'gulp-uglifycss' );

// JS related plugins
var concat       = require( 'gulp-concat' );
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var plumber      = require( 'gulp-plumber' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// Browers related plugins
var browserSync  = require( 'browser-sync' ).create();
var reload       = browserSync.reload;

// Project related variables
var exposeConfig = { expose: { jquery: 'jQuery' } };
var projectURL   = 'http://codearchitect';

var npm = './node_modules';
//SCSS
var styleAdminSrcFile = 'codearchitect_plugin_admin.scss';
var styleAdminSRC = './src/scss/' + styleAdminSrcFile;
var styleFrontSrcFile = 'codearchitect_plugin_front.scss';
var styleFrontSRC = './src/scss/'+styleFrontSrcFile;
var styleURL     = './assets/css/';
var mapURL       = './';

//JS
var jsSRC        = './src/js/';
var jsSrcSettingsFile      = 'codearchitect_plugin_settings.js';
var jsSrcAdminFile      = 'codearchitect_plugin_admin.js';
var jsSrcFrontFile  = 'codearchitect_plugin_front.js';
var jsAdminFrontFile = 'codearchitect_plugin_admin.min.js'; //added prefix min.js
var jsFiles      = [ jsSrcSettingsFile, jsSrcAdminFile, jsSrcFrontFile ];
var jsURL        = './assets/js/';


var imgSRC       = './src/images/**/*';
var imgURL       = './assets/images/';

var fontsSRC     = './src/fonts/**/*';
var fontsURL     = './assets/fonts/';

var styleWatch   = './src/scss/**/*.scss';
var jsWatch      = './src/js/**/*.js';
var imgWatch     = './src/images/**/*.*';
var fontsWatch   = './src/fonts/**/*.*';
var phpWatch     = './**/*.php';

// Tasks
gulp.task( 'browser-sync', function() {
    browserSync.init({
        proxy: projectURL,
        injectChanges: true,
        open: false
        /*
        https:{
            key:'your_key',
            cert:'your_cert'
        }*/
    });
});

gulp.task( 'styles', function() {

    gulp.src( [ styleAdminSRC, styleFrontSRC ] )
        .pipe( sourcemaps.init() )
        .pipe( sass({
            errLogToConsole: true,
            outputStyle: 'compressed'
        }) )
        .on( 'error', console.error.bind( console ) )
        .pipe( autoprefixer({ browsers: [ 'last 2 versions', '> 5%', 'Firefox ESR' ] }) )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( sourcemaps.write( mapURL ) )
        .pipe( gulp.dest( styleURL ) )
        .pipe( browserSync.stream() );
});

gulp.task( 'js', function() {
    jsFiles.map( function( entry ) {
        return browserify({
            entries: [jsSRC + entry]
        })
            .transform( babelify, { presets: [ 'env' ] } )
            .bundle()
            .pipe( source( entry ) )
            .pipe( rename( {
                extname: '.min.js'
            } ) )
            .pipe( buffer() )
            .pipe( gulpif( options.has( 'production' ), stripDebug() ) )
            .pipe( sourcemaps.init({ loadMaps: true }) )
            .pipe( uglify() )
            .pipe( sourcemaps.write( '.' ) )
            .pipe( gulp.dest( jsURL ) )
            .pipe( browserSync.stream() );
    });
});



gulp.task( 'images', function() {
    triggerPlumber( imgSRC, imgURL );
});

gulp.task( 'fonts', function() {

    /*gulp.src([
        npm + '/bootstrap-sass/assets/fonts/**'
    ]).pipe(plumber())
        .pipe(gulp.dest(fontsURL));*/

    triggerPlumber( fontsSRC, fontsURL );
});

function triggerPlumber( src, url ) {
    return gulp.src( src )
        .pipe( plumber() )
        .pipe( gulp.dest( url ) );
}

gulp.task( 'default', ['styles', 'js', 'images', 'fonts'], function() {
    gulp.src( jsURL + jsAdminFrontFile )
        .pipe( notify({ message: 'Assets Compiled!' }) );
});

gulp.task( 'watch', ['default', 'browser-sync'], function() {
    gulp.watch( phpWatch, reload );
    gulp.watch( styleWatch, [ 'styles', reload ] );
    gulp.watch( jsWatch, [ 'js', reload ] );
    gulp.watch( imgWatch, [ 'images' ] );
    gulp.watch( fontsWatch, [ 'fonts' ] );
    gulp.src( jsURL + jsAdminFrontFile )
        .pipe( notify({ message: 'Gulp watch activated!' }) );
});
