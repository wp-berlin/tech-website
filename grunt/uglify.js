module.exports = function (grunt, options) {
    return {
        noJquery: {
            options: {
                sourceMap: true,
                sourceMapIncludeSources: true,
                preserveComments: 'some',
                compress: {
                    drop_console: false
                },
                mangle: true
            },
            files: options.files.noJquery
        },
        default: {
            options: {
                sourceMap: true,
                sourceMapIncludeSources: true,
                mangle: false,
                banner: '(function ($) {',
                footer: '\n}(jQuery));'
            },
            files: options.files.js
        },
        dist: {
            options: {
                sourceMap: true,
                sourceMapIncludeSources: true,
                preserveComments: 'some',
                compress: {
                    drop_console: true
                },
                mangle: true,
                banner: '(function ($) {',
                footer: '\n}(jQuery));'
            },
            files: options.files.js
        }
    };
} ;
