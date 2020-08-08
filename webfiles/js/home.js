function onWhoAmI() {

    gimme('a#tmNavLink2').click();
}

function goToAdmin() {

    window.location = `${baseURL}/admin`;
}

function animateLangGlobe() {

    const langGlobe = gimme('#lang-globe');

    langGlobe.addEventListener('mouseover', () => {
        langGlobe.style.animation = 'globe-rotate 1.5s ease-in-out';
        langGlobe.addEventListener('animationend', () => { langGlobe.style.animation = ''; });
    });
}

function onSwitchPage(aElem) {

    const id = aElem.dataset.pageId;

    if (['reviews', 'join'].includes(id)) {
        gimme('#powered-by-footer').classList.add('hidden');
    } else {
        gimme('#powered-by-footer').classList.remove('hidden');
    }

    let cookies = document.cookie
        .split(';')
        .map(pair => pair.trim())
        .map(pairStr => {
            const parts = pairStr.split('=');
            return { k: parts[0], v: parts[1] };
        });

    const expire = new Date();
    expire.setHours(expire.getHours() + 2);
    let exists = false;

    for (let i = 0; i < cookies.length; i++) {
        if (cookies[i].k.trim() === "last-nav") {

            cookies[i].v = `${id}`;
            cookies[i].path = '/';
            cookies[i].expire = expire.toString();
            exists = true;
            break;
        }
    }

    if (!exists) cookies.push({ k: 'last-nav', v: `${id}`, path: '/', expire: expire });

    cookies.forEach(cookieObj => {
        document.cookie = cookieObj.k === "last-nav" ?
            `${cookieObj.k}=${cookieObj.v}; path=${cookieObj.path}; expire=${cookieObj.expire}` :
            `${cookieObj.k}=${cookieObj.v}`;
    });
}

function onLastSeenSection() {

    // If last-nav cookie exists, commute to it on load
    let cookie = document.cookie
        .split(';')
        .map(pair => pair.trim())
        .find(pair => pair.startsWith('last-nav'));

    if (!!cookie) cookie = cookie.split('=')[1].trim();

    // Commute to last seen section
    if (!!cookie) gimme(`a[data-page-id="${cookie}"]`).click();
}

function onShowSubscribe() {

    const langCookie = getLangCookieValue();

    gimme('#subscribe-modal-title').innerHTML = 'Newsletter';
    gimme('#subscribe-modal-text').innerHTML = globalLangObj[ langCookie ]['js-subscribe-modal-text'];

    gimme('#subscribe-modal-btn-cancel').innerHTML = globalLangObj[ langCookie ]['js-subscribe-btn-cancel'];
    gimme('#subscribe-modal-btn-submit').innerHTML = globalLangObj[ langCookie ]['js-subscribe-btn-submit'];


    gimme('#subscribe-modal-trigger').click();
    gimme('#subscribe-modal-input').focus();
}

function onSubscribe() {

    const langCookie = getLangCookieValue();
    const email = gimme('#subscribe-modal-input').value;
    gimme('#subscribe-modal-input').value = '';

    if (!isEmailValid(email)) {

        onError(globalLangObj[ langCookie ]['js-error-message-email'], globalLangObj[ langCookie ]['js-error-message-email-title']);
    } else {

        ajaxPost(
            'index.php',
            { action: 'onSubscribe', email: email },
            (response) => {

                response = JSON.parse(response);
                if (response.ok) {
                    onNotify(globalLangObj[ langCookie ]['js-success-subscribe-msg'], globalLangObj[ langCookie ]['js-success-subscribe-msg-title']);
                } else {
                    onError(globalLangObj[ langCookie ]['js-subscribe-error']);
                }
            }
        )
    }
}

function onNewReview() {

    gimme('a#toggle-review').click();
}

function onRatingHover(hoveredStar) {

    const starPos = hoveredStar.dataset.pos;
    for (let i = 0; i <= starPos; i++) {
        gimme(`span[data-pos="${i}"]`).classList.add('checked');
    }
}

function onRatingUnhover() {
    gimmeAll('.new-review').forEach(span => { span.classList.remove('checked'); });
}

function onRatingSet(star) {

    const starPos = star.dataset.pos;
    console.log(`Selected ${starPos}`);

    onRatingUnhover();
    onRatingHover(star);

    gimmeAll('.new-review').forEach(star => {
        star.removeAttribute('onmouseleave' );
        star.removeAttribute('onmouseenter');
    });
    gimme('input[name="review_rating"]').value = starPos;
}

function cancelAddReview() {

    gimme('#add-review-name').value = '';
    gimme('#add-review-email').value = '';
    gimme('#add-review-rating').value = '';
    onRatingUnhover();

    gimme('#add-review-message').value = '';
    gimme('a[data-page-id="reviews"]').click();
}

function submitReview() {

    const langCookie = getLangCookieValue();

    if (gimme('#add-review-name').value === '' ||
        gimme('#add-review-email').value === '' ||
        !["0","1","2","3","4"].includes(gimme('#add-review-rating').value.trim()) ||
        gimme('#add-review-message').value === '') {

        onError( globalLangObj[ langCookie ]['js-review-incomplete'], globalLangObj[ langCookie ]['js-review-incomplete-title'] );
    } else {

        const data = {
            action: 'reviewSubmit',
            review_name: gimme('#add-review-name').value,
            review_email: gimme('#add-review-email').value,
            review_rating: gimme('#add-review-rating').value,
            review_message: gimme('#add-review-message').value,
        };
        ajaxPost(
            'index.php',
            data,
            (response) => {
                response = JSON.parse(response);
                if (response.ok) {
                    onNotify(globalLangObj[langCookie]['js-new-review-success-message'], globalLangObj[langCookie]['js-on-remove-post-success-title'])
                    cancelAddReview();
                    setTimeout(() => { location.reload() }, 1500);
                } else {
                    onError(response.message);
                }
            }
        );
    }
}


landingSection = $('#tm-section-1'); // TODO: This can be used in the 'onLastSeenSection()'
elementContainingBgImg = gimme('#tmNavLink1');

// Everything is loaded including images.
$(window).on("load", function () {

    // Render the page on modern browser only.
    if (renderPage) {
        // Remove loader
        document.body.classList.add('loaded');

        // Page transition
        const allPages = $(".tm-section");

        // Hide all pages
        allPages.hide();

        landingSection.fadeIn();

        // Set up background first page
        const bgImg = elementContainingBgImg.dataset.bgImg;

        $.backstretch(`${baseURL}/webfiles/img/${bgImg}`, {fade: 500});

        setupNav();
        setupNavToggle();

        onLastSeenSection(); // if possible
    }

    animateLangGlobe();

});