require('es6-promise').polyfill();

var gulp            = require('gulp'),
    gulpif          = require('gulp-if'),
    uglify          = require('gulp-uglify'),
    order           = require("gulp-order"),
    uglifycss       = require('gulp-uglifycss'),
    minifyCss       = require('gulp-minify-css'),
    concat          = require('gulp-concat'),
    sourcemaps      = require('gulp-sourcemaps'),
    autoprefixer    = require('gulp-autoprefixer'),
    cssimport       = require('gulp-cssimport');

var env = process.env.GULP_ENV;

gulp.task('js', function(){
    return gulp.src([
            'src/Acted/LegalDocsBundle/Resources/public/js/*.js', "!src/Acted/LegalDocsBundle/Resources/public/js/admin.js", "!src/Acted/LegalDocsBundle/Resources/public/js/userCreationAdmin.js"])
        .pipe(order([
            "jquery.min.js",
            "moment.min.js",
            "jquery.throttle.min.js",
            "bootstrap.min.js",
            "jquery.bxslider.min.js",
            "jquery.wwCarousel.min.js",
            "bootstrap-editable.min.js",
            "bootstrap-datetimepicker.min.js",
            "HTTPProvider.js",
            "fabric.min.js",
            "cropper.min.js",
            "select2.min.js",
            "*.js"
        ]))
        .pipe(concat('javascript.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});
gulp.task('css', function(){
    return gulp.src('src/Acted/LegalDocsBundle/Resources/public/css/**/*.css')
        .pipe(minifyCss())
        .pipe(concat('styles.min.css'))
        .pipe(cssimport({}))
        .pipe(autoprefixer())
        .pipe(gulpif(env === 'prod', uglifycss()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/css'));
});

gulp.task('watch-all', function() {
  gulp.watch('src/Acted/LegalDocsBundle/Resources/public/js/**/*.js', ['js']);
  gulp.watch('src/Acted/LegalDocsBundle/Resources/public/css/**/*.css', ['css']);
});

gulp.task('default', ['js', 'css']);
