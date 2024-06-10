const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));

function compileSass() {
  return src('sass/custom.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('assets/css/custom.css'));
}

function watchFiles() {
  watch('sass/scss/**/custom.scss', compileSass);
}

exports.default = series(compileSass, watchFiles);
exports.watchFiles = watchFiles;