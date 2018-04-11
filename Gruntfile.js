module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    require('load-grunt-config')(grunt, {
        data: {
            path: {
                src: {
                    scss: 'assets/scss',
                    js: 'assets/js'
                },
                dest: {
                    css: 'web/assets/css',
                    js: 'web/assets/js'
                },
                tmp: 'assets/tmp'
            },
            files: {
                js: {
                    '<%= path.dest.js %>/app.min.js': [
                    ]
                },
                noJquery: {
                    '<%= path.dest.js %>/scriptloader.min.js': '<%= path.src.js %>/scriptloader.js',
                    '<%= path.dest.js %>/webfontloader.min.js': '<%= path.src.js %>/webfonts.js',
                    '<%= path.dest.js %>/fontawesome-all.min.js': '<%= path.src.js %>/fontawesome-all.js',
                    '<%= path.dest.js %>/fa-css.min.js': '<%= path.src.js %>/fa-css.js'
                },
                copy: {}
            }
        }
    });
};
