module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    require('load-grunt-config')(grunt, {
        data: {
            path: {
                src: {
                    scss: 'assets/scss',
                    js: 'assets/js',
                    img: 'assets/img'
                },
                dest: {
                    css: 'web/assets/css',
                    js: 'web/assets/js',
                    img: 'web/assets/img',
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
                copy: [
                    {
                        expand: true,
                        cwd: '<%= path.src.img %>',
                        src: ['**/*.jpg', '**/*.jpeg', '**/*.png', '**/*.svg'],
                        dest: '<%= path.dest.img %>',
                        flatten: true,
                    }
                ]
            }
        }
    });
};
