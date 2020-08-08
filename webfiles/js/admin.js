function onBlogPostView(blogPost = null) {

    const langCookie = getLangCookieValue();
    if (blogPost) {
        gimme('#q-post-id').innerHTML      = `${globalLangObj[langCookie]['js-update-blog-post-no']}${blogPost.postID}`;
        gimme('#blogPostIdInput').value    = blogPost.postID;
        gimme('#b1').value                 = blogPost.postTitleRo;
        gimme('#b2').value                 = blogPost.postTitleEn;
        gimme('#b3').innerHTML             = blogPost.postContentRo;
        gimme('#b4').innerHTML             = blogPost.postContentEn;
        gimme('#b5').value                 = blogPost.createdAt;
        gimme('#postSubmit').innerHTML     = `${globalLangObj[langCookie]['js-update-blog-post']}`;

        gimme('#actionInput').value = "adminUpdatePost";
    } else {
        gimme('#q-post-id').innerHTML      = `${globalLangObj[langCookie]['js-add-new-blog-post']}`;
        gimme('#blogPostIdInput').value    = '';
        gimme('#b1').value                 = '';
        gimme('#b2').value                 = '';
        gimme('#b3').innerHTML             = '';
        gimme('#b4').innerHTML             = '';
        gimme('#b5').value                 = '';
        gimme('#postSubmit').innerHTML     = `${globalLangObj[langCookie]['js-add-blog-post']}`;

        gimme('#actionInput').value = "adminAddPost";
    }

    gimme('#tmNavLink5').click();
}

function onShowPostUpdateView(button) {

    const postID = button.parentNode.dataset.postId;

    ajaxPost(
        'index.php',
        { action: 'adminGetBlogPost', postID: postID },
        (response) => {
            response = JSON.parse(response);
            if (response.ok) onBlogPostView({ ...response.blogPost, postID: postID });
        }
    )
}

function onPostRemoveConfirm(button) {
    const langCookie = getLangCookieValue();
    const postID = button.parentNode.dataset.postId;
    onConfirm(
        `${globalLangObj[langCookie]['js-remove-post-question']}${postID} ?`,
        `${globalLangObj[langCookie]['js-remove-post-title']}`,
        `${globalLangObj[langCookie]['js-remove-post-btn-cancel']}`,
        `${globalLangObj[langCookie]['js-remove-post-btn-confirm']}`,
        postID
    );
}

function onPostRemove(button) {

    const postID = button.dataset.postId;
    const langCookie = getLangCookieValue();
    ajaxPost(
        'index.php',
        { action: 'adminRemovePost', postID: postID },
        (response) => {

            response = JSON.parse(response);

            if (response.ok) {

                const blogPostDiv = gimme(`#blog-post-div-${postID}`);

                blogPostDiv.classList.add('removed');
                blogPostDiv.addEventListener('animationend', () => {

                    blogPostDiv.parentNode.removeChild(blogPostDiv);
                    blogPostDiv.classList.remove('removed');

                    onNotify(
                        globalLangObj[langCookie]['js-on-remove-post-success'].replace("{{postID}}", String(postID)),
                        globalLangObj[langCookie]['js-on-remove-post-success-title'].replace("{{postID}}", String(postID))
                    );
                });

            } else {

                onError(`${globalLangObj[langCookie]['js-on-remove-error'].replace("{{postID}}", String(postID))}: ${response.errMsg}`, 'Error');
            }

        }
    )
}

function onReviewRemove(btn) {
    const reviewID = btn.dataset.reviewId;
    const langCookie = getLangCookieValue();
    ajaxPost(
        'index.php',
        { action: 'adminRemoveReview', reviewID: reviewID },
        (response) => {
            response = JSON.parse(response);
            if (response.ok) {
                const reviewDiv = gimme(`#review-div-${reviewID}`);

                reviewDiv.classList.add('removed');
                reviewDiv.addEventListener('animationend', () => {

                    reviewDiv.parentNode.removeChild(reviewDiv);
                    reviewDiv.classList.remove('removed');

                    onNotify(
                        globalLangObj[langCookie]['js-on-remove-review-success'].replace("{{reviewID}}", String(reviewID)),
                        globalLangObj[langCookie]['js-on-remove-review-success-title'].replace("{{reviewID}}", String(reviewID))
                    );
                });
            } else {
                onError(`${globalLangObj[langCookie]['js-on-remove-review-error'].replace("{{reviewID}}", String(reviewID))}: ${response.msg}`, 'Error');
            }
        }
    )
}

function onLogout() {

    ajaxPost(
        'index.php',
        { action: 'logout' },
        () => {
            location.reload();
        }
    );
}

function goToSite() {
    window.location = baseURL;
}

function onFormView(formID) {

    const langCookie = getLangCookieValue();
    ajaxPost(
        'index.php',
        { action: 'adminGetForm', formID: formID },
        (response) => {

            response = JSON.parse(response);

            if (response.ok) {
                gimme('#q-form-id').innerHTML  = `${globalLangObj[langCookie]['js-form-no']}${formID}`;
                gimme('#q12').value            = eval('response.form.' + 'formDate');
                gimme('#q1').value             = eval('response.form.' + 'name');
                gimme('#q2').value             = eval('response.form.' + 'email');
                gimme('#q3').value             = eval('response.form.' + 'live');
                gimme('#q4').value             = eval('response.form.' + 'skype');
                gimme('#q5').textContent       = eval('response.form.' + 'travelStory');

                gimme('#tmNavLink4').click();
            }
        }
    )
}

function onConfirmReviewRemove(confirmQuestion,
                   confirmTitle = 'Confirm',
                   confirmButtonNoTxt = 'No',
                   confirmButtonYesTxt = 'Yes',
                   arg) {

    gimme('#confirm-review-remove-modal-title').innerHTML = confirmTitle;
    gimme('#confirm-review-remove-modal-text').innerHTML = confirmQuestion;

    gimme('#confirm-review-remove-modal-yes-btn').innerHTML = confirmButtonYesTxt;
    gimme('#confirm-review-remove-modal-yes-btn').dataset.reviewId = arg;
    gimme('#confirm-review-remove-modal-no-btn').innerHTML = confirmButtonNoTxt;

    gimme('#confirm-review-remove-modal-trigger').click();
}

function onReviewRemoveConfirm(button) {

    const langCookie = getLangCookieValue();
    const reviewID = button.parentNode.dataset.reviewId;

    onConfirmReviewRemove(
        `${globalLangObj[langCookie]['js-remove-review-question']}${reviewID} ?`,
        `${globalLangObj[langCookie]['js-remove-review-title']}`,
        `${globalLangObj[langCookie]['js-remove-review-btn-cancel']}`,
        `${globalLangObj[langCookie]['js-remove-review-btn-confirm']}`,
        reviewID
    );
}

function setupDatepicker() {

    $('#blog-post-datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
}

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

        $("#tm-section-1").fadeIn();

        // Set up background first page
        var bgImg = $("#tmNavLink1").data("bgImg");

        $.backstretch(`${baseURL}/webfiles/img/${bgImg}`, {fade: 500});

        // Setup Carousel, Nav, and Nav Toggle
        setupNav();
        setupNavToggle();

        setupDatepicker();
    }
});