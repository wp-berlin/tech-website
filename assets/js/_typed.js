var typed = new Typed('#intro', {
    typeSpeed: 60,
    backSpeed: 20,
    showCursor: false,
    autoInsertCss: false,
    strings: [
        'WordPress Meetup Berlin for Devs',
        'WordPress Meetup Berlin for Admins',
        'WordPress Meetup Berlin for Web Developers',
        'WordPress Meetup Berlin for Dev Ops',
        'WordPress Meetup Berlin for Front End Developers',
        'WordPress Meetup Berlin <span>Tech Edition</span>',
    ],
    smartBackspace: true,
    // pseudo onStart; onStart does not fire and this fires only onec for smartBackspace
    preStringTyped: function (arrayPos, self) {
        typed.el.classList.add('has-cursor');
    },
    onStringTyped: function (arrayPos, self) {
        // if (arrayPos === 2) {
        //     self.stop();
        // }
    },
    onStart: function () {
        console.log('why??');
    },
    onComplete: function (typed) {
        typed.el.children[0].classList.add('header-intro-highlight');
        setTimeout(function () {
            typed.el.classList.remove('has-cursor');
        }, 2000);
    }
});
