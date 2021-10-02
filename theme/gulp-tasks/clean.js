'use strict';

import { paths } from "../gulpfile.babel";
import gulp from 'gulp';
import clean from 'gulp-clean';
import debug from 'gulp-debug';

gulp.task('clean', () => {
    return gulp.src(paths.build.clean, { read: false })
        .pipe(clean({force: true}))
        .pipe(debug({
            'title': 'Cleaning...'
        }))
});
