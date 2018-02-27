require('../css/app.scss');
require('bootstrap');

const $ = require('jquery');

const buttonLeft = $('.arrowToLeft');
const buttonRight = $('.arrowToRight');

let current = 0;

buttonLeft.addClass('disabled');

function nextAffix(previous) {
    buttonLeft.removeClass('disabled');
    buttonRight.removeClass('disabled');
    if (previous) {
        if (current > 0) {
            current -= 1;
        }
    } else {
        if (current < 3) {
            current += 1;
        }
    }
    if (current >= 3) {
        buttonRight.addClass('disabled');
    }
    if (current <= 0) {
        buttonLeft.addClass('disabled');
    }
    $('.calendar').css('margin-left', '-' + (current * 100) + '%');
}

$(document).keydown(function (e) {
    switch (e.which) {
        case 37:
            nextAffix(1);
            break;
        case 39:
            nextAffix();
            break;
    }
});