var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');


var cssFiles = [
	'bower_components/bootstrap/dist/css/bootstrap.min.css',
	'assets/css/chat.css'
];

var jsFiles = [
	'bower_components/jquery/dist/jquery.min.js',
	'bower_components/boostrap/dist/js/bootstrap.min.js',
	'vendor/oktopost/tattler-php/js/tattler.min.js',
	'assets/js/*'
];

var build = function () {

	gulp.src(cssFiles)
		.pipe(concat('app.css'))
		.pipe(gulp.dest('public/css'));

	gulp.src(jsFiles)
		.pipe(concat('app.js'))
		.pipe(uglify())
		.pipe(gulp.dest('public/js'));
	
};


gulp.task('build', function () {
	build();
});

gulp.task('watch', function () {
	gulp.watch(cssFiles, ['build']);
	gulp.watch(jsFiles, ['build']);
});