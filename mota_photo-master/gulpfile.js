const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));

function compileSass() {
  return src('src/scss/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('dist/css'));
}

function watchFiles() {
  watch('src/scss/**/*.scss', compileSass);
}

exports.default = series(compileSass, watchFiles);