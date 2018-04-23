var $nav = $('#nav'),
    $toggle = $('#toggle'),
    $header = $('#header');

$toggle.on('click', function() {
    $nav.toggleClass('is-expanded');
    $header.toggleClass('is-nav-expanded');
});
