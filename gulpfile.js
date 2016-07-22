// var elixir = require('laravel-elixir');
//
// /*
//  |--------------------------------------------------------------------------
//  | Elixir Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Elixir provides a clean, fluent API for defining some basic Gulp tasks
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for our application, as well as publishing vendor resources.
//  |
//  */
//
// elixir(function(mix) {
//     mix.sass('main.scss');
// });

var gulp = require('gulp');
var watch = require('gulp-watch');
var jshint = require('gulp-jshint');
var plumber = require('gulp-plumber');
var cleanCss = require('gulp-clean-css');
var uglyfly = require('gulp-uglyfly');
var sass = require('gulp-sass');
var gutil = require('gulp-util');
var ftp = require('vinyl-ftp');
var stylish = require('jshint-stylish');
var rename = require('gulp-rename');

var js_asset_path = 'resources/assets/js/**/*.js';
var js_path = 'public/src/js';

var scss_asset_path = 'resources/assets/sass/**/*.scss';
var css_path = 'public/src/css';

gulp.task('jshint', function() {
    return gulp.src('js_asset_path')
        .pipe(plumber())
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'));
});

gulp.task('compress', ['jshint'], function() {
    gulp.src('resources/assets/js/*.js')
    // .pipe(uglyfly({
    //     mangle: false
    // }))
    // .pipe(rename({
    //     suffix: '.min',
    //     extname: '.js'
    // }))
        .pipe(gulp.dest(js_path))
});

gulp.task('styles', function () {
    return gulp.src('resources/assets/sass/*.scss')
        .pipe(sass.sync().on('error', sass.logError))
        //.pipe(gulp.dest(css_path))
        .pipe(cleanCss())
        // .pipe(rename({
        //     suffix: '.min',
        //     extname: '.css'
        // }))
        .pipe(gulp.dest(css_path))
});

gulp.task('cleanCss', function () {
    return gulp.src(css_path)
        .pipe(cleanCss)
        .pipe(gulp.dest(css_path))
});

var globs = [

];

// gulp.task('ftp', function () {
//     var conn = ftp.create({
//         host: '',
//         user: '',
//         password: '',
//         log: gutil.log
//     });
//
//     return gulp.src(globs, {base: '.', buffer: false})
//         .pipe(conn.newerOrDifferentSize('/public_html'))
//         .pipe(conn.dest('/public_html'));
// });

gulp.task('watch', function() {
    gulp.watch(js_asset_path, ['compress']);
    gulp.watch(scss_asset_path, ['styles']);
});

gulp.task('default', ['watch']);