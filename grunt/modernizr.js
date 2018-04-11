// https://modernizr.com/download?flexbox-flexboxlegacy-history-localstorage-sessionstorage-setclasses
module.exports = {
    dist: {
        'crawl': false,
        'customTests': [],
        'dest': '<%= path.dest.js %>/modernizr.min.js',
        'tests': [
            'history',
            'localstorage',
            'sessionstorage'
        ],
        'options': [
            'setClasses'
        ],
        'uglify': true
    }
};
