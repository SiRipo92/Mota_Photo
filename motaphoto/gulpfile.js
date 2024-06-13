const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sassLint = require('gulp-sass-lint');
const sourcemaps = require('gulp-sourcemaps');

function lintSass() {
  return src('sass/custom.scss')
    .pipe(sassLint({
      configFile: '.sass-lint.yml' // Ensure you have a sass-lint configuration file
    }))
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError());
}

function compileSass() {
  return src('sass/custom.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write('./'))
    .pipe(dest('assets/css')); // Output to the css directory
}

function watchFiles() {
  watch('sass/custom.scss', series(lintSass, compileSass));
}

exports.default = series(lintSass, compileSass, watchFiles);
exports.watchFiles = watchFiles;
exports.lint = lintSass;
