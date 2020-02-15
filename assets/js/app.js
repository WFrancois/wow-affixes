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

$('.js--switch-left').on('click', () => nextAffix(1));
$('.js--switch-right').on('click', () => nextAffix());

const buttonNightMode = document.querySelector('.js--switch-to-darkmode');
const textNightMode = buttonNightMode.querySelector('span');

function toggleDarkMode () {
    document.body.classList.toggle('darkmode');
    document.querySelector('nav.navbar').classList.toggle('navbar-inverse');

    const isNightMode = document.body.classList.contains('darkmode');
    if (isNightMode) {
        textNightMode.textContent = 'Light mode';
    } else {
        textNightMode.textContent = 'Night mode';
    }

    const expiresAt = new Date();
    expiresAt.setYear(expiresAt.getYear() + 1902);

    document.cookie = `isNightMode=${isNightMode ? 'true' : 'false'}; path=/; expires=${expiresAt.toUTCString()}`;
}

buttonNightMode.onclick = () => {
    toggleDarkMode();
};
