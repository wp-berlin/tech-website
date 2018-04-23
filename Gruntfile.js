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
                    '<%= path.dest.js %>/front.min.js': [
                        'node_modules/typed.js/lib/typed.js',
                        '<%= path.src.js %>/_typed.js',
                        '<%= path.src.js %>/scrollspy.js',
                        '<%= path.src.js %>/_parallax.js',
                    ],
                    '<%= path.dest.js %>/app.min.js': [
                        '<%= path.src.js %>/_home-link.js',
                        '<%= path.src.js %>/_nav.js',
                    ]
                },
                noJquery: {
                    '<%= path.dest.js %>/webfontloader.min.js': '<%= path.src.js %>/webfonts.js'
                },
                copy: {}
            }
        }
    });
};
