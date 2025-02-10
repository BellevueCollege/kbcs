/** Unhide the nav for screen readers when clicked **/

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.querySelector('.btn-navbar.menu');
    const nav = document.getElementById('nav-main');
    const navClass = document.querySelector('nav.hidden-nav');

    menuButton.addEventListener('click', function() {
        const navIsHidden = nav.getAttribute('aria-expanded') === 'false';
        nav.setAttribute('aria-expanded', !navIsHidden);
        menuButton.setAttribute('aria-expanded', !navIsHidden);

        // Set nav visibility based on navIsHidden
        if (navIsHidden && !nav.classList.contains('hidden')) {
            console.log("hiding");
            navClass.classList.add('hidden');
        } else if(navIsHidden && !nav.classList.contains('hidden')) {
            console.log("state is inconsistent");
        } else {
            console.log("showing");
            navClass.classList.remove('hidden');
        }
    });
});