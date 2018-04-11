module.exports = {
    grunt: {
        files: ['Gruntfile.js', 'grunt/*'],
        tasks: ['sass:default','postcss:default', 'uglify:noJquery','uglify:default', 'modernizr']
    },
    sass: {
        files: ['<%= path.src.scss %>/**/*.scss', '<%= path.src.scss %>/*.scss'],
        tasks: ['sass:default','postcss:default']
    },
    js: {
        files: ['<%= path.src.js %>/**/*.js', '<%= path.src.js %>/*.js'],
        tasks: ['uglify:noJquery','uglify:default']
    }
};
