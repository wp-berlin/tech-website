module.exports = function (grunt) {
    var domain = grunt.file.readJSON('config/env.json');

    return {
        dev: {
            options: {
                hostname: domain.host,
                port: domain.port,
                base: 'web',
                keepalive: false,
                open: false
            }
        }
    };
};
