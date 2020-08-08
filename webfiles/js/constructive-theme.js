const renderPage = true;

let currentPageID = "#tm-section-1";

// TODO: Make dynamic length
let questions = Array.from(Array(formQuestionsCount).fill(false));

// Setup Carousel
function setupCarousel() {

    // If current page isn't Carousel page, don't do anything.
    const section = gimme('#tm-section-2');
    if (!!section && section.style.display !== 'none') {

        const slider = $('.tm-img-slider');

        if (slider.hasClass('slick-initialized')) {
            slider.slick('destroy');
        }

        slider.slick({
            dots: true,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });

        slider.on('afterChange', () => { window.scroll(0, 0); });
    }
}

// Setup Nav
function setupNav() {
    // Add Event Listener to each Nav item
    $(".tm-main-nav a").click(function (e) {
        e.preventDefault();

        changePage( $(this) );

        setupCarousel();

        // Hide the nav on mobile
        $("#tmSideBar").removeClass("show");
    });
}

function changePage(currentNavItem) {
    // Update Nav items
    $(".tm-main-nav a").removeClass("active");
    currentNavItem.addClass("active");

    $(currentPageID).hide();

    // Show current page
    currentPageID = currentNavItem.data("page");
    $(currentPageID).fadeIn(1000);

    // Change background image
    var bgImg = currentNavItem.data("bgImg");
    $.backstretch(`${baseURL}/webfiles/img/${bgImg}`);

    window.scroll(0, 0);
}

// Setup Nav Toggle Button
function setupNavToggle() {

    $("#tmMainNavToggle").on("click", function () {
        $(".sidebar").toggleClass("show");
    });
}

function focusReplyTextarea() {

    document
        .querySelector('.current-form-question')
        .firstElementChild
        .focus();
}

function handleNextButton(currentQuestionIndex) {

    const lang = document
        .cookie
        .split('; ')
        .find(cookie => cookie.startsWith('helixlang'))
        .split('=')[1];

    currentQuestionIndex = parseInt(currentQuestionIndex);
    const btn = gimme('#contact-form-next');

    if (currentQuestionIndex === formQuestionsCount) {
        btn.innerHTML = lang === 'ro' ? 'Trimite' : 'Submit';
        btn.style.color = 'lightgreen';
        btn.style.borderColor = 'lightgreen';
    }

    if (currentQuestionIndex < formQuestionsCount) {
        btn.innerHTML = lang === 'ro' ? 'Următoarea' : 'Next';
        btn.style.color = 'white';
        btn.style.borderColor = 'white';
    }
}

function handlePrevButton(currentQuestionIndex) {

    currentQuestionIndex = parseInt(currentQuestionIndex);
    const btn = gimme('#contact-form-prev');

    if (currentQuestionIndex === 1) {
        btn.style.visibility = 'hidden';
    }
    if (currentQuestionIndex > 1) {
        btn.style.visibility = 'visible';
    }
}

function nextQuestion() {

    const langCookie = getLangCookieValue();
    const currentQuestionDiv = gimme('.current-form-question');
    let crtQuestionIdx = parseInt(currentQuestionDiv.dataset.questionId);

    let text = currentQuestionDiv.children[0].value;
    questions[(crtQuestionIdx-1)] = (text !== "".trim());

    if (crtQuestionIdx === formQuestionsCount) {

        const allQuestionsAnswered = questions.reduce((acc, val) => { return acc && val; }, true);
        if (allQuestionsAnswered) {

            gimme('#contact_form').submit();
        } else {

            onError(
                globalLangObj[langCookie]['js-form-incomplete'],
                globalLangObj[langCookie]['js-form-incomplete-title']
            );
        }
        return;
    }

    const nextQuestionDiv = currentQuestionDiv.nextElementSibling;

    currentQuestionDiv.style.display = 'none';
    currentQuestionDiv.classList.remove('current-form-question');

    nextQuestionDiv.style.display = 'block';
    nextQuestionDiv.classList.add('current-form-question');

    crtQuestionIdx++;

    handleNextButton(crtQuestionIdx);
    handlePrevButton(crtQuestionIdx);

    focusReplyTextarea();
}

function prevQuestion() {

    const currentQuestionDiv = gimme('.current-form-question');
    let crtQuestionIdx = currentQuestionDiv.dataset.questionId;

    let text = currentQuestionDiv.children[0].value;
    questions[crtQuestionIdx-1] = (text !== "".trim());

    const prevQuestionDiv = currentQuestionDiv.previousElementSibling;

    currentQuestionDiv.style.display = 'none';
    currentQuestionDiv.classList.remove('current-form-question');

    prevQuestionDiv.style.display = 'block';
    prevQuestionDiv.classList.add('current-form-question');

    crtQuestionIdx--;

    handleNextButton(crtQuestionIdx);
    handlePrevButton(crtQuestionIdx);

    focusReplyTextarea();
}