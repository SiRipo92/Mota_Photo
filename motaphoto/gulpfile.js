const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sassLint = require('gulp-sass-lint');
const sourcemaps = require('gulp-sourcemaps');

function lintSass() {
  return src('sass/**/*.scss')
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError());
}

function compileSass() {
  return src('sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write('./'))
    .pipe(dest('./'));
}

function watchFiles() {
  watch('sass/**/*.scss', series(lintSass, compileSass));
}

exports.default = series(lintSass, compileSass, watchFiles);
exports.watchFiles = watchFiles;
exports.lint = lintSass;