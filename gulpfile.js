var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var order = require("gulp-order");
var uglifycss = require('gulp-uglifycss');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var cssimport = require("gulp-cssimport");

var env = process.env.GULP_ENV;

gulp.task('js', function(){
    return gulp.src([
            'src/Acted/LegalDocsBundle/Resources/public/js/*.js'])
        .pipe(order([
            "jquery.min.js",
            "jquery.throttle.min.js",
            "bootstrap.min.js",
            "bootstrap-editable.min.js",
            "*.js",
            "profile.js"
        ]))
        .pipe(concat('javascript.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('css', function(){
    return gulp.src([
            'src/Acted/LegalDocsBundle/Resources/public/css/*.css'])
        .pipe(concat('styles.css'))
        .pipe(cssimport({}))
        .pipe(autoprefixer())
        .pipe(gulpif(env === 'prod', uglifycss()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/css'));
});

gulp.task('default', ['js', 'css']);