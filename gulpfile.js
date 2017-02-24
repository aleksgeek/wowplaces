var gulp = require('gulp');
var browserSync = require('browser-sync');
var useref = require('gulp-useref');
var uglify = require('gulp-uglify');
var minifyCSS = require('gulp-minify-css');
var gulpIf = require('gulp-if');

gulp.task('browserSync', function() {
	browserSync({
		server: {
			baseDir: 'public-dev'
		},
	})
});

gulp.task('build', function(){
	gulp.src('public-dev/fonts/*').pipe(gulp.dest('public/fonts'));
	gulp.src('public-dev/img/*').pipe(gulp.dest('public/img'));
	gulp.src('public-dev/app/**/*.html').pipe(gulp.dest('public/app'));
    
    return gulp.src('public-dev/*.html')
		.pipe(gulpIf('*.js', uglify()))
		.pipe(gulpIf('*.css', minifyCSS()))
		.pipe(useref())
		.pipe(gulp.dest('public'));
});
