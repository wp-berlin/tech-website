module.exports = {
    default: ['<%= path.tmp %>/*'],
    build: ['<%= path.tmp %>/*', '<%= path.dest.css %>/*', '<%= path.dest.js %>/*'],
    options: {
        force: true
    }
};
