require('../css/app.scss');
require('bootstrap');

const calendar = document.querySelector('.calendar');
const buttonLeft = document.querySelector('.arrowToLeft');
const buttonRight = document.querySelector('.arrowToRight');

let current = 0;

buttonLeft.classList.add('disabled');

function nextAffix(previous) {
    buttonLeft.classList.remove('disabled');
    buttonRight.classList.remove('disabled');

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
        buttonRight.classList.add('disabled');
    }
    if (current <= 0) {
        buttonLeft.classList.add('disabled');
    }

    calendar.style.marginLeft = `-${current * 100}%`;
}

document.addEventListener('keydown', function (e) {
    switch (e.code) {
        case 'ArrowLeft':
            nextAffix(true);
            break;
        case 'ArrowRight':
            nextAffix();
            break;
    }
});

document.querySelector('.js--switch-left').onclick = () => {
    nextAffix(true);
}
document.querySelector('.js--switch-right').onclick = () => {
    nextAffix();
}


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
