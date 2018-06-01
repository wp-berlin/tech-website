module.exports = {
    grunt: {
        files: ['Gruntfile.js', 'grunt/*'],
        tasks: ['sass:default','postcss:default', 'uglify:noJquery','uglify:default', 'copy:main', 'modernizr']
    },
    sass: {
        files: ['<%= path.src.scss %>/**/*.scss', '<%= path.src.scss %>/*.scss'],
        tasks: ['sass:default','postcss:default']
    },
    js: {
        files: ['<%= path.src.js %>/**/*.js', '<%= path.src.js %>/*.js'],
        tasks: ['uglify:noJquery','uglify:default']
    },
    img: {
        files: ['<%= path.src.img %>/**/*.jpg', '<%= path.src.img %>/**/*.jpeg', '<%= path.src.img %>/**/*.png', '<%= path.src.img %>/**/*.svg'],
        tasks: ['clean:images', 'copy:main']
    }
};
