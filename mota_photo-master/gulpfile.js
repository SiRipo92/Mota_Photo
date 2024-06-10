const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sassLint = require('gulp-sass-lint');

function lintSass() {
  return src('sass/**/*.scss')
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError());
}

function compileSass() {
  return src('sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('/assets/css/'));
}

function watchFiles() {
  watch('sass/**/*.scss', compileSass);
}

exports.default = series(compileSass, watchFiles);
exports.watchFiles = watchFiles;
exports.lint = lintSass;