module.exports = {
    "build": [
        "clean:build",
        "sass",
        "postcss:dist",
        "uglify:noJquery",
        "uglify:dist",
        "copy",
        "modernizr"
    ],
    "default": [
        "clean:default",
        "sass:default",
        "postcss:default",
        "uglify:noJquery",
        "uglify:default",
        "modernizr",
        "copy",
        "php",
        "browserSync",
        "watch"
    ],
    "fast": [
        "php",
        "browserSync",
        "watch"
    ]
};
