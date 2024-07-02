// Hamburger menu toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    hamburger.classList.toggle('active');
});

// Opportunity slider
const opportunitySlider = document.querySelector('.opportunity-slider');
let scrollAmount = 0;
const scrollStep = 300;

function slideOpportunities() {
    opportunitySlider.scrollTo({
        left: scrollAmount,
        behavior: 'smooth'
    });

    scrollAmount += scrollStep;

    if (scrollAmount >= opportunitySlider.scrollWidth - opportunitySlider.clientWidth) {
        scrollAmount = 0;
    }
}

setInterval(slideOpportunities, 3000);