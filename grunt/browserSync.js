module.exports = function (grunt, options) {
    var defaults = grunt.file.readJSON('config/env/default.json'),
        config = grunt.file.readJSON('config/env/local.json'),
        bs = {};
    for (var attrname in defaults.bs) {
        bs[attrname] = defaults.bs[attrname];
    }
    for (attrname in config.bs) {
        bs[attrname] = config.bs[attrname];
    }
    config.bs = bs;

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
