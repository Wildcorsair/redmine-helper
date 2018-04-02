var gulp   = require('gulp'),
    sass   = require('gulp-sass'),
    concat = require('gulp-concat');

// SASS to CSS task
gulp.task('sass', function() {
    return gulp.src('web/assets/sass/*.sass')
        .pipe(sass())
        .pipe(gulp.dest('web/css'));
});

// Copy libraries
gulp.task('copy-libs', function () {
    return gulp.src('web/assets/libs/**')
        .pipe(gulp.dest('web/libs/'));
});

gulp.task('build', ['sass', 'copy-libs']);

// Watch task
gulp.task('watch', function() {
    gulp.watch('web/assets/sass/*.sass', ['sass']);
});