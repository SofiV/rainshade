'use strict';

require('dotenv').config();

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const cssBase64 = require('gulp-base64-inline');
const uglify = require('gulp-uglify-es').default;
const concat = require('gulp-concat');
const browserSync = require('browser-sync').create();

// gulp-sass 5 uses the legacy Sass API; keep the console quiet about it.
const sassOptions = { outputStyle: 'compressed', charset: false, silenceDeprecations: ['legacy-js-api'] };

const paths = {
    style: ['./assets/scss/style.scss'],
    scripts: ['./assets/js/**/_*.js'],
    adminStyles: ['./assets/admin/editor.scss'],
    blockStyles: ['./blocks/*/style.scss'],
    // Everything else that changes the page without a build step.
    reload: [
        './**/*.php',
        './theme.json',
        './blocks/**/block.json',
        './blocks/**/editor.js',
        '!./node_modules/**',
    ],
};

// Reloads both addresses: the proxy (http://localhost:3000) and the site itself
// (BROWSERSYNC_PROXY, e.g. http://rainshade.test) — the theme adds the client there in the local environment (inc/assets.php).
function initBrowserSync(done) {
    browserSync.init({
        proxy: process.env.BROWSERSYNC_PROXY,
        port: 3000,
        open: false,
        https: process.env.BROWSERSYNC_PROXY.startsWith('https'),
        notify: false,
    });
    done();
}

function themeStyles() {
    return gulp.src(paths.style)
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(cssBase64())
        .pipe(rename({ extname: '.css' }))
        .pipe(gulp.dest('.'))
        .pipe(browserSync.stream());
}

function editorStyles() {
    return gulp.src(paths.adminStyles)
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(cssBase64())
        .pipe(rename('editor.css'))
        .pipe(gulp.dest('./assets/admin'))
        .pipe(browserSync.stream());
}

// blocks/<name>/style.scss → blocks/<name>/style.css (the path block.json points to)
function blockStyles() {
    return gulp.src(paths.blockStyles, { base: '.' })
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(cssBase64())
        .pipe(rename({ extname: '.css' }))
        .pipe(gulp.dest('.'))
        .pipe(browserSync.stream());
}

function themeScripts() {
    return gulp.src(paths.scripts)
        .pipe(uglify())
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('assets/js'))
        .on('end', browserSync.reload);
}

function watchFiles() {
    gulp.watch('./assets/scss/**/*.scss', gulp.parallel(themeStyles, editorStyles));
    gulp.watch('./assets/admin/**/*.scss', gulp.series(editorStyles));
    gulp.watch('./blocks/**/*.scss', gulp.series(blockStyles));
    gulp.watch(paths.scripts, gulp.series(themeScripts));
    gulp.watch(paths.reload).on('change', browserSync.reload);
}

/**
 * Create Tasks.
 */
gulp.task('default', gulp.series(themeStyles, editorStyles, blockStyles, themeScripts));
gulp.task('watch', gulp.series('default', initBrowserSync, watchFiles));
