const gulp = require('gulp');

const config = {
	// your config here
};

// Require GulpWP and pass your custom config
const gulpWP = require('gulp-wp')(gulp, config);

/**
 * Copy assets from node_modules.
 * Run: gulp upboot
 *
 * Does the following:
 * 1. Copies _custom-asu-variables.scss partial from asu package.
 *
 */

gulp.task("up-glide", function (done) {

	var paths = {
		"node": "./node_modules",
		"dev": "./src",
	}

	/** ----------------------------------------------------------
	Copy assets for glide.js into the dist folder
	------------------------------------------------------------- */
	gulp
		.src(paths.node + "/@glidejs/glide/dist/css/glide.core.min.css")
		.pipe(gulp.dest(paths.dev + "/glidejs"));

	gulp
		.src(paths.node + "/@glidejs/glide/dist/glide.min.js")
		.pipe(gulp.dest(paths.dev + "/glidejs"));

	done();
});
