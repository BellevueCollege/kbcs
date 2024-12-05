/** Unhide the nav for screen readers when clicked **/

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.querySelector('.btn-navbar.menu');
    const nav = document.querySelector('nav.hidden-nav');
    const linkElems = document.querySelectorAll('.hidden-nav li.aria-hidden a');
    // const form = document.querySelector('form.hidden-search');

    menuButton.addEventListener('click', function() {
        const navIsHidden = nav.getAttribute('aria-hidden') === 'true';
        for (const link of linkElems) {
            link.setAttribute('aria-hidden', !navIsHidden);
        }
        nav.setAttribute('aria-hidden', !navIsHidden);

        // Set form style to display none when nav is hidden
        if(!navIsHidden) {
            nav.style.display = 'none';
        }
        else {
            nav.style.display = 'block';
        }
    });
});