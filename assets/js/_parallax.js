$(window).trigger('scroll');

var $logo = $('#logo svg'),
    $intro = $('#intro'),
    $header = $('#header');

$header
    .css('min-height', $header.outerHeight())
    .scrollspy({
        min: 100,
        // max: $(document).height(),
        onEnter: function (el) {
            if ($(document).width() > 700) {
                $(el).addClass('is-fixed');
            }
        },
        onLeaveTop: function (el) {
            $(el).removeClass('is-fixed');
            if ($(document).width() > 700) {
                $logo.css('width', 300);
            }
        },
        onTick: function (el, position) {
            if ($(document).width() > 700) {
                var width = 400 - position.top;
                if (width < 150) {
                    width = 150;
                }

                $logo.css('width', width);
                $intro.css('top', width);
            }
        }
    });
