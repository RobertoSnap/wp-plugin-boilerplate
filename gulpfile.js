var gulp        = require('gulp');
var browserSync = require('browser-sync');
var sass        = require('gulp-sass');
var sourcemaps 	= require('gulp-sourcemaps');
var plumber 	= require('gulp-plumber');
var concat 		= require('gulp-concat');
var uglify 		= require('gulp-uglify');
var del 		= require('del');
var zip			= require('gulp-zip');
var pluginName = "my-plugin";

// Static Server + watching scss/html files
gulp.task('serve', ['sass', 'sass-admin', 'js', 'js-admin'], function() {

    browserSync.init({
		files: "assets/css/*.css",
        proxy: "rpe.dev/wp-admin/edit.php?post_type=shop_order",
		logLevel: "info"
    });

    gulp.watch( "assets/scss/**/*.scss" , ['sass', 'sass-admin']);
    gulp.watch( "assets/js/plugin.js", ['js'] );
    gulp.watch( "assets/js/plugin-admin.js" ,['js-admin'] );


});

gulp.task('watch', ['sass', 'sass-admin', 'js', 'js-admin'], function() {

	gulp.watch( 'assets/scss/**/*.scss' , ['sass', 'sass-admin']);
	gulp.watch( "assets/js/plugin.js", ['js'] );
	gulp.watch( "assets/js/plugin-admin.js" ,['js-admin'] );

});

//sass
gulp.task('sass', function() {
	return gulp.src(['assets/scss/style.scss'])
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(sourcemaps.write('maps/'))
		.pipe(gulp.dest("assets/css/"));
});

//admin
gulp.task('sass-admin', function() {
	return gulp.src(['assets/scss/style-admin.scss'])
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(sourcemaps.write('maps/'))
		.pipe(gulp.dest("assets/css/"));
});


//js frontend
gulp.task('js', function(){
	return gulp.src(['assets/js/plugin.js'])
		.pipe(sourcemaps.init())
		.pipe(concat('plugin.min.js'))
		.pipe(gulp.dest('assets/js/'))
		.pipe(uglify())
		.pipe(sourcemaps.write('maps/'))
		.pipe(gulp.dest('assets/js/'));
});

//js frontend
gulp.task('js-admin', function(){
	return gulp.src(['assets/js/plugin-admin.js'])
		.pipe(sourcemaps.init())
		.pipe(concat('plugin-admin.min.js'))
		.pipe(gulp.dest('assets/js/'))
		.pipe(uglify())
		.pipe(sourcemaps.write('maps/'))
		.pipe(gulp.dest('assets/js/'));
});

gulp.task('clean', function () {
	return del([
		'dist/**/*'
	],({force: true}));
});


gulp.task('zip', ['copy'], function () {
	return gulp.src('dist/**')
		.pipe(zip(pluginName+'.zip'))
		.pipe(gulp.dest('dist/'));
});

gulp.task('copy',['clean','basic'], function () {
	return gulp.src([
		'./**',
		'!assets/js/plugin.js',
		'!assets/js/plugin-admin.js',
		'!assets/scss/**',
		'!assets/scss/',
		'!node_modules/**',
		'!node_modules',
		'!.gitignore',
		'!composer.**',
		'!gulpfile.js',
		'!dist',
		'!package.json'
	])
		.pipe(gulp.dest('dist/'+pluginName+'/'));
});

gulp.task('default', ['serve']);
gulp.task('deploy', ['zip']);
gulp.task('basic', ['sass', 'sass-admin', 'js', 'js-admin']);

