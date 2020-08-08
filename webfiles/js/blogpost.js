// Everything is loaded including images.
$(window).on("load", function () {

    // Render the page on modern browser only.
    if (renderPage) {
        // Remove loader
        $('body').addClass('loaded');

        // Page transition
        var allPages = $(".tm-section");

        // Handle click of "Continue", which changes to next page
        // The link contains data-nav-link attribute, which holds the nav item ID
        // Nav item ID is then used to access and trigger click on the corresponding nav item
        var linkToAnotherPage = $("a.tm-btn[data-nav-link]");

        if (linkToAnotherPage != null) {

            linkToAnotherPage.on("click", function () {
                var navItemToHighlight = linkToAnotherPage.data("navLink");
                $("a" + navItemToHighlight).click();
            });
        }

        // Hide all pages
        allPages.hide();

        $("#tm-section-3").fadeIn();

        // Set up background first page
        var bgImg = $("#tmNavLink3").data("bgImg");

        $.backstretch(`${baseURL}/webfiles/img/${bgImg}`, {fade: 500});

        // Setup Carousel, Nav, and Nav Toggle
        setupNav();
        setupNavToggle();

    }
});