/** Unhide the nav for screen readers when clicked **/

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.querySelector('.btn-navbar.menu');
    const nav = document.querySelector('nav.hidden-nav');

    menuButton.addEventListener('click', function() {
        const navIsHidden = nav.getAttribute('aria-hidden') === 'true';
        nav.setAttribute('aria-hidden', !navIsHidden);

        // Set nav visibility based on navIsHidden
        if (!navIsHidden) {
            console.log("hiding");
            nav.classList.add('hidden');
        } else {
            console.log("showing");
            nav.classList.remove('hidden');
        }
    });
});