module.exports = {
    default: ['<%= path.tmp %>/*'],
    build: ['<%= path.tmp %>/*', '<%= path.dest.css %>/*', '<%= path.dest.js %>/*', '<%= path.dest.img %>/*'],
    images: '<%= path.dest.img %>/*',
    options: {
        force: true
    }
};
