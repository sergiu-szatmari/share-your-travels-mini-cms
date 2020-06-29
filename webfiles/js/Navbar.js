const navSlide = () => {

    const burger    = document.querySelector('.nav-burger');
    const nav       = document.querySelector('.nav-links');
    const navLinks  = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {

        // Toggle nav
        nav.classList.toggle('nav-active');

        // Animate links
        navLinks.forEach((link, index) => {

            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.5}s`;
            }
        });

        // Burger animation
        burger.classList.toggle('nav-burger-toggled');
    });
};

const app = () => {

    navSlide();
};

app();