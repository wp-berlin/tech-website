module.exports = function(grunt, options) {
    var config = grunt.file.readJSON('config/env/local.json');
    return {
        dev: {
            bsFiles: {
                // src: 'web/**/*.(css|js|php)'
                src: [
                    'web/assets/css/*.css',
                    'web/assets/js/*.js',
                    './**/*.php'
                ]
            },
            options: {
                watchTask: true,
                proxy: config.url,
                online: true,
                reload_delay: 100,
                open: false,
                notify: true,
                browser: 'Google Chrome Canary'
            }
        }
    };
};
