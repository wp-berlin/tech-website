module.exports = function(grunt, options) {
    var config = grunt.file.readJSON('config/env/local.json');
    return {
        dev: {
            bsFiles: {
                src: [
                    'web/assets/css/*.css',
                    'web/assets/js/*.js',
                    './**/*.php'
                ]
            },
            options: {
                watchTask: true,
                proxy: config.url,
                online: config.bs.online,
                reload_delay: config.bs.delay,
                open: config.bs.open,
                notify: config.bs.notify,
                browser: config.bs.browser
            }
        }
    };
};
