// Load plugins
const gulp = require("gulp")
const plumber = require("gulp-plumber")
const sass = require("gulp-sass")
const cssnano = require("cssnano")
const postcss = require("gulp-postcss")
const rename = require("gulp-rename")
const browsersync = require("browser-sync").create()
const autoprefixer = require("autoprefixer")
const babel = require('gulp-babel')
const concat = require('gulp-concat')
const terser = require('gulp-terser')
const sourcemaps = require('gulp-sourcemaps');


// BrowserSync \/
function browserSync(done) {
  browsersync.init({
    proxy: "http://localhost/",
    port: 80
  })
  done()
}
function browserSyncReload(done) {
  browsersync.reload()
  done()
}



// Images \/
function images() {
  return gulp
    .src("./assets/img/**/*")
    .pipe(gulp.dest("./dist/img"))
}
// Images /\


// Fonts \/
function fonts() {
  return gulp
    .src("./assets/fonts/*")
    .pipe(gulp.dest("./dist/fonts"))
}
// Fonts /\


// CSS \/
function scss() {
  return gulp
    .src("./src/scss/*.scss")
    .pipe(plumber())
    .pipe(sass({ outputStyle: "expanded" }))
    .pipe(gulp.dest("./dist/css/"))
    .pipe(rename({ suffix: ".min" }))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(gulp.dest("./dist/css/"))
    .pipe(browsersync.stream())
}
function css() {
  return gulp
    .src("./src/css/*.css")
    .pipe(plumber())
    .pipe(rename({ suffix: ".min" }))
    .pipe(gulp.dest("./dist/css/"))
    .pipe(browsersync.stream())
}
// CSS /\


// JS \/
function jsCustom() {
  // Transpile, concatenate and minify scripts
  return (
    gulp
      .src("./src/js/*.js")
      .pipe(plumber())
      .pipe(babel({ presets: [['@babel/env', {modules: false}]] }))
      // .pipe(concat("./dist/js/application.js"))
      // .pipe(sourcemaps.init())
      // .pipe(terser())
      // .pipe(sourcemaps.write('/dist/js'))
      .pipe(gulp.dest("./dist/js"))
      // .pipe(gulp.dest("./"))
      .pipe(browsersync.stream())
  )
}
function jsVendor() {
  // Just copy vendor scripts
  return (
    gulp
      .src("./src/js/vendor/*.js")
      .pipe(plumber())
      .pipe(gulp.dest("./dist/js/vendor/"))
      .pipe(browsersync.stream())
  )
}
// JS /\


// Watch files \/
function watchFiles() {
  gulp.watch("./src/scss/**/*", scss)
  gulp.watch("./src/css/**/*", css)
  gulp.watch("./src/js/**/*", jsCustom)
  gulp.watch("./src/js/vendor/**/*", jsVendor)
  gulp.watch("./assets/img/**/*", images)
  gulp.watch("./assets/fonts/**/*", fonts)
  gulp.watch("./**/*.php", browserSyncReload)
}
// Watch files /\


// Define complex tasks \/
const build = gulp.parallel(scss, css, jsCustom, jsVendor, images, fonts)
const watch = gulp.series(build, gulp.parallel(watchFiles, browserSync))
// Define complex tasks /\


// Export tasks \/
// Ex.: gulp build, gulp dev...
exports.dev = watch
exports.default = build
// Export tasks /\