module.exports = function (grunt, options) {
    return {
        default: {
            options: {
                processors: [
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
