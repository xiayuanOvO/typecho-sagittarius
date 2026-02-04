const gulp = require('gulp');
const cleanCSS = require('gulp-clean-css');
const terser = require('gulp-terser');
const concat = require('gulp-concat');
const rename = require('gulp-rename');

// 1. 处理 CSS：扫描所有 CSS 并合并压缩为一个 main.min.css
gulp.task('minify-css', () => {
    return gulp.src(['assets/css/**/*.css', '!assets/css/**/*.min.css']) // 避开已压缩的文件
        .pipe(concat('main.css'))       // 合并所有 css
        .pipe(cleanCSS())                 // 执行压缩
        .pipe(rename({ suffix: '.min' })) // 改名为 main.min.css
        .pipe(gulp.dest('assets/css'));
});

// 2. 处理 JS：扫描所有 JS 并合并压缩
gulp.task('minify-js', () => {
    return gulp.src(['assets/js/**/*.js', '!assets/js/**/*.min.js'])
        .pipe(concat('app.js'))
        .pipe(terser())                   // 压缩 JS
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('assets/js'));
});

// 3. 自动化监听：文件一动，自动打包
gulp.task('watch', () => {
    gulp.watch('assets/css/**/*.css', gulp.series('minify-css'));
    gulp.watch('assets/js/**/*.js', gulp.series('minify-js'));
});

// 默认任务
gulp.task('default', gulp.parallel('minify-css', 'minify-js'));