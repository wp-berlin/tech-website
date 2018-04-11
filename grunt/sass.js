module.exports = function(grunt, options) {
    return {
        default: {
            options: {
                sourceMap: true
            },
            files: [{
                expand: true,
                cwd: options.path.src.scss,
                src: ['**/*.scss'],
                dest: options.path.tmp,
                ext: '.css',
                extDot: 'first'
            }]
        }
    };
};
