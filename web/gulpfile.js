var gulp   = require('gulp'),
    sass   = require('gulp-sass'),
    concat = require('gulp-concat');

// SASS to CSS task
gulp.task('sass', function() {
    return gulp.src('assets/sass/*.sass')
    .pipe(sass())
    .pipe(gulp.dest('../web/css'));
});

// Watch task
gulp.task('watch', function() {
    gulp.watch('assets/sass/*.sass', ['sass']);
});