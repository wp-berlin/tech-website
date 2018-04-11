module.exports = function (grunt, options) {
    return {
        postcss: {
            files: [{
                expand: true,
                cwd: options.path.tmp,
                src: '*.css',
                dest: options.path.dest.css,
                ext: '.css',
                extDot: 'last'
            }]
        },
        sass: {
            files: [{
                expand: true,
                flatten: true,
                cwd: options.path.src.scss,
                src: ['**/*.scss'],
                dest: options.path.tmp,
                ext: '.css',
                extDot: 'first'
            }]
        }
    };
};
