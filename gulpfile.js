var gulp = require('gulp')
var sass = require('gulp-sass')
var browserSync = require('browser-sync').create()
var useref = require('gulp-useref')
var uglify = require('gulp-uglify')
var gulpIf = require('gulp-if')
var postcss = require('gulp-postcss')
var cssnano = require('cssnano')
var autoprefixer = require('autoprefixer')
var runSequence = require('run-sequence')
var imagemin = require('gulp-imagemin')
var htmlmin = require('gulp-htmlmin')

gulp.task('sass', function() {
    return gulp.src('app/sass/**/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('app/css'))
    .pipe(browserSync.stream())
})

gulp.task('browserSync', function() {
    browserSync.init({
        server: {
            baseDir: 'app',
            index: 'index.html'
        }
    })
})

gulp.task('js', function() {
    return gulp.src('app/*.html')
    .pipe(useref())
    .pipe(gulpIf('*.js', uglify()))
    .pipe(gulp.dest('dist'))
})

gulp.task('css', function () {
    var plugins = [
        autoprefixer({browsers: ['last 1 version']}),
        cssnano()
    ];
    return gulp.src('app/*.html')
        .pipe(useref())
        .pipe(gulpIf('*.css', postcss(plugins)))
        .pipe(gulp.dest('dist'));
});

gulp.task('copy-fonts', function() {
    return gulp.src('app/**/*.otf')
    .pipe(gulp.dest('dist'))
})

gulp.task('img', function(){
    return gulp.src('app/assets/img/**/*.+(png|jpg|jpeg|gif|svg)')
    .pipe(imagemin({
        // Setting interlaced to true
        interlaced: true,
        verbose: true,
    }))
    .pipe(gulp.dest('dist/images'))
  });

gulp.task('html', function() {
    return gulp.src('dist/*.html')
    .pipe(htmlmin({collapseWhitespace: true}))
    .pipe(gulp.dest('dist'))
})
  
gulp.task('optimize', function() {
    runSequence('js', 'css', 'img', 'html')
})

gulp.task('watch', ['browserSync'], function() {
    gulp.watch('app/sass/**/*.scss', ['sass'])
    gulp.watch('app/*.html', browserSync.reload())
})