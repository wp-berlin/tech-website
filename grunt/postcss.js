module.exports = function (grunt, options) {
    return {
        default: {
            options: {
                processors: [
                    require('tailwindcss')('./tailwind.js'),
                    require('autoprefixer')({
                        browsers: ['> 1%', 'Last 2 versions']
                    }),
                    require('css-mqpacker')({
                        sort: true
                    })
                ],
                map: false,
                diff: true
            },
            files: [{
                expand: true,
                cwd: options.path.tmp,
                src: '*.css',
                dest: options.path.dest.css,
                ext: '.css',
                extDot: 'last'
            }]
        },
        fonts: {
            options: {
                processors: [
                    require('cssnano')
                ]
            },
            files: [{
                expand: true,
                cwd: options.path.tmp,
                src: 'icon-fonts/**/*.css',
                dest: options.path.dest.css + '/fonts',
                ext: '.css',
                extDot: 'last',
                flatten: true
            }]
        },
        dist: {
            options: {
                processors: [
                    require('autoprefixer')({
                        browsers: ['> 1%', 'Last 2 versions']
                    }),
                    require('css-mqpacker'),
                    require('cssnano')
                ],
                map:
                    {
                        prev: 'tmp',
                        inline:
                            false
                    }
            },
            files: [{
                expand: true,
                cwd: options.path.tmp,
                src: '*.css',
                dest: options.path.dest.css,
                ext: '.css',
                extDot: 'last'
            }]
        }
    };
};
