$(window).trigger('scroll');

var $logo = $('#logo'),
    $intro = $('#intro'),
    $header = $('#header');

$header
    .css('min-height', $header.outerHeight())
    .scrollspy({
        min: $logo.offset().top - parseInt($logo.css('top'), 10),
        // max: $(document).height(),
        onEnter: function (el) {
            if ($(document).width() > 700) {
                $(el).addClass('is-fixed');
            }
        },
        onLeaveTop: function (el) {
            $(el).removeClass('is-fixed');
            if ($(document).width() > 700) {
                $logo.find('svg').css('width', 300);
            }
        },
        onTick: function (el, position) {
            if ($(document).width() > 700) {
                var width = 380 - position.top;
                if (width < 150) {
                    width = 150;
                }

                $logo.find('svg').css('width', width);
                $intro.css('top', width + 20);
            }
        }
    });
