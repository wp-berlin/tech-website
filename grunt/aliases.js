module.exports = {
  "build": [
    "clean:build",
    "sass",
    "postcss:dist",
    "postcss:fonts",
    "uglify:noJquery",
    "uglify:dist",
    "modernizr"
  ],
  "default": [
    "clean:default",
    "sass:default",
    "postcss:default",
    "postcss:fonts",
    "uglify:noJquery",
    "uglify:default",
    "modernizr",
    "browserSync",
    "watch"
  ],
  "fast": [
    "browserSync",
    "watch"
  ]
};
