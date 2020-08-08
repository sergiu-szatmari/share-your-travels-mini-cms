<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class AdminPage extends aPage
{
    public static function render( $context = [] ): void
    {
        self::clear();

        self::headers( __CLASS__, "Share your travels Admin" );

        $user           = $context['username'];
        $langCode       = 'Ro';

        $formQuestions  = Language::get( 'contact-questions' );

        $postTitle      = "postTitle{$langCode}";
        $postContent    = "postContent{$langCode}";
        $blogPosts      = BlogPostManagement::getBlogposts( $newestFirst = true );
        $forms          = FormManagement::getForms();
        $reviews        = ReviewManagement::getReviews( $newestFirst = true );
        ?>

        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>

        <!-- Page Content -->
        <div class="container-fluid tm-main">
            <div class="row tm-main-row">

                <!-- Sidebar -->
                <div id="tmSideBar" class="col-xl-3 col-lg-3 col-md-12 col-sm-12 sidebar" style="">

                    <button id="tmMainNavToggle" class="menu-icon">&#9776;</button>

                    <div class="inner">
                        <nav id="tmMainNav" class="tm-main-nav">
                            <ul>
                                <li>
                                    <a href="#" id="tmNavLink1" class="scrolly" data-bg-img="admin_bg.jpg" data-page="#tm-section-2">
                                        <i class="fas fa-sticky-note tm-nav-fa-icon"></i>
                                        <span> <?= Language::get( 'admin-menu-blog-posts' ); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" id="tmNavLink2" class="scrolly" data-bg-img="admin_bg.jpg" data-page="#tm-section-3">
                                        <i class="fas fa-address-card tm-nav-fa-icon"></i>
                                        <span> <?= Language::get( 'admin-menu-forms' ); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a style="display: none;" href="#" id="tmNavLink4" class="scrolly" data-bg-img="admin_bg.jpg" data-page="#tm-section-4"></a>
                                </li>
                                <li>
                                    <a style="display: none;" href="#" id="tmNavLink5" class="scrolly" data-bg-img="admin_bg.jpg" data-page="#tm-section-5"></a>
                                </li>
                                <li>
                                    <a href="#" class="scrolly" data-bg-img="admin_bg.jpg" data-page="#tm-section-7">
                                        <i class="fas fa-star tm-nav-fa-icon"></i>
                                        <span> <?= Language::get('reviews'); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="scrolly" onclick="goToSite();">
                                        <i class="fab fa-black-tie tm-nav-fa-icon"></i>
                                        <span> <?= Language::get( 'admin-menu-go-to-site' ); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="scrolly" onclick="onLogout();">
                                        <i id="logout-nav" class="fas fa-sign-out-alt tm-nav-fa-icon"></i>
                                        <span> <?= Language::get( 'admin-menu-log-out' ); ?> </span>
                                    </a>
                                </li>
                                <li id="language-switch-li">
                                    <button class="btn btn-sm" onclick="onChangeLanguage(this);">EN</button>
                                    <i id="lang-globe" class="fa fa-globe" aria-hidden="true"></i>
                                    <button class="btn btn-sm" onclick="onChangeLanguage(this);">RO</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 tm-content">

                    <section id="tm-section-1" class="tm-section">
                        <div class="ml-auto">
                            <header class="mb-4">
                                <p id="welcome-admin" class="mb-5 tm-font-big">
                                    <?= Language::get( 'app-name' ) ?> Admin
                                </p>
                                <h2 id="welcome-admin-text" class="tm-text-shadow">
                                    <?= Language::get( 'admin-welcome' ); ?>,
                                    <span id="welcome-admin-special">
                                        <?= $user; ?>
                                    </span>
                                </h2>
                            </header>
                        </div>
                    </section>

                    <!-- Blog -->
                    <section id="tm-section-2" class="tm-section">
                        <div class="row mb-4">
                            <header class="col-xl-12">
                                <h2 class="tm-text-shadow">
                                    <?= Language::get( 'blog-blogposts' ); ?>
                                </h2>
                            </header>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                <button class="btn btn-outline-light col-12" onclick="onBlogPostView(null);">
                                    <?= Language::get( 'new-post' ); ?>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (count($blogPosts) == 0): ?>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                    <div class="media tm-bg-transparent-black tm-border-white">
                                        <div class="media-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?= Language::get( 'blog-no-posts' ); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: foreach ($blogPosts as $blogPost): ?>
                                <div id="blog-post-div-<?= $blogPost['id']; ?>" class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                    <div class="media tm-bg-transparent-black tm-border-white">
                                        <i class="fas fa-sticky-note tm-icon-circled tm-icon-media"></i>

                                        <div class="media-body">
                                            <div class="row">
                                                <h3 class="col-12">
                                                    <a id="powered-by">
                                                        <?= $blogPost[$postTitle]; ?>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="row">
                                                <h6 class="col-12">
                                                    <?= $blogPost['createdAt']; ?>
                                                </h6>
                                            </div>
                                            <div class="row">
                                                <p class="col-12">
                                                    <?= BlogPostManagement::trimContent( $blogPost['seo'], $blogPost[ $postContent ], 50, true ) ?>
                                                </p>
                                            </div>

                                            <div class="row justify-content-between" style="margin: 30px 5px; border-spacing: 5px;" data-post-id="<?= $blogPost['id']; ?>">
                                                <button class="action-button btn btn-sm btn-outline-warning col-4 col-sm-4 col-md-3 col-lg-3 col-xl-3" onclick="onShowPostUpdateView(this);">
                                                    <?= Language::get( 'admin-blog-post-update' ); ?>
                                                </button>
                                                <button class="action-button btn btn-sm btn-outline-danger col-4 col-sm-4 col-md-3 col-lg-3 col-xl-3" onclick="onPostRemoveConfirm(this);">
                                                    <?= Language::get( 'admin-blog-post-remove' ); ?>
                                                </button>
                                                <a class="action-button btn btn-sm btn-outline-info col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"
                                                   href="<?= Environment::getBaseURL()."/posts/{$blogPost['seo']}"; ?>" target="_blank">
                                                    <?= Language::get( 'admin-blog-post-see-post' ); ?>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </section>

                    <!-- Forms -->
                    <section id="tm-section-3" class="tm-section">
                        <div class="row mb-4">
                            <header class="col-xl-12">
                                <h2 class="tm-text-shadow">
                                    <?= Language::get( 'admin-forms-requests' ); ?>
                                </h2>
                            </header>
                        </div>
                        <div class="row">
                            <?php if (count($forms) == 0): ?>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                    <div class="media tm-bg-transparent-black tm-border-white">
                                        <div class="media-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?= Language::get( 'forms-no-forms' ); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: foreach ($forms as $idx => $form): $i = $idx + 1; ?>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                    <div class="media tm-bg-transparent-black tm-border-white">
                                        <i class="fa fa-user tm-icon-circled tm-icon-media"></i>
                                        <div class="media-body" style="text-align: center;">
                                            <div class="row">
                                                <h3>
                                                    <a href="#" onclick="onFormView(<?= $form['id']; ?>);"
                                                       id="tmNavLink4 powered-by"
                                                       data-page="#tm-section-4">
                                                        <?= "{$i}. {$form['name']}"; ?>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="row">
                                                <h5>
                                                    <?= $form['email']; ?>
                                                </h5>
                                            </div>
                                            <div class="row">
                                                <h6>
                                                    <?= "{$form['formDate']}"; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>

                    <!-- See contact form view -->
                    <section id="tm-section-4" class="tm-section">
                        <div class="tm-bg-transparent-black tm-contact-box-pad">
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <header>
                                        <h2 id="q-form-id" class="tm-text-shadow"></h2>
                                    </header>
                                </div>
                            </div>
                            <div class="row tm-page-12-content">
                                <div class="col-md-12 col-sm-12 tm-contact-col">
                                    <div class="contact-form">
                                        <div class="form-group">
                                            <label for="q12">
                                                <i>
                                                    <?= Language::get( 'form-date' ); ?>
                                                </i>
                                            </label>
                                            <input type="text" id="q12" class="form-control disabled">
                                        </div>

                                        <?php foreach ($formQuestions as $formQuestion): ?>

                                        <div class="form-group">
                                            <label for="q<?= $formQuestion['questionID']; ?>">
                                                <i> <?= $formQuestion['question']; ?> </i>
                                            </label>

                                            <?php if ($formQuestion['type'] === 'input'): ?>
                                                <input type="text" id="q<?= $formQuestion['questionID']; ?>" class="form-control disabled">
                                            <?php elseif ($formQuestion['type'] === 'textarea'): ?>
                                                <textarea id="q<?= $formQuestion['questionID']; ?>" class="form-control disabled" rows="9"></textarea>
                                            <?php endif; ?>

                                        </div>

                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                    </section>

                    <!-- Blog post add / update view -->
                    <section id="tm-section-5" class="tm-section">
                        <div class="tm-bg-transparent-black tm-contact-box-pad">
                            <div class="row mb-12">
                                <div class="col-sm-12">
                                    <header>
                                        <h2 id="q-post-id" class="tm-text-shadow">
                                            Update blog post
                                        </h2>
                                    </header>
                                </div>
                            </div>
                            <div style="margin-top: 20px" class="row tm-page-12-content">
                                <div class="col-md-12 col-sm-12 tm-contact-col">
                                    <form action="" method="post" class="contact-form">
                                        <input id="blogPostIdInput" type="hidden" name="id" value="">
                                        <input id="actionInput" type="hidden" name="action" value="adminUpdatePost">
                                        <div class="form-group">
                                            <label for="b5">
                                                <i>
                                                    <?= Language::get( 'created-at' ); ?>
                                                </i>
                                            </label>

                                            <div class='input-group date' id='blog-post-datepicker'>
                                                <input type='text'
                                                    class="form-control"
                                                    id="b5"
                                                    name="createdAt"
                                                    autocomplete="off"
                                                    onfocus="blur();"
                                                    required/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="b1">
                                                <i>
                                                    <?= Language::get( 'blog-post-title' ); ?> (Ro)
                                                </i>
                                            </label>
                                            <input name="postTitleRo" autocomplete="off" type="text" id="b1" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="b2">
                                                <i>
                                                    <?= Language::get( 'blog-post-title' ); ?> (En)
                                                </i>
                                            </label>
                                            <input name="postTitleEn" autocomplete="off" type="text" id="b2" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="b3">
                                                <i>
                                                    <?= Language::get( 'blog-post-content' ); ?> (Ro)
                                                </i>
                                            </label>
                                            <textarea name="postContentRo" id="b3" class="form-control" rows="9" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="b4">
                                                <i>
                                                    <?= Language::get( 'blog-post-content' ); ?> (En)
                                                </i>
                                            </label>
                                            <textarea name="postContentEn" id="b4" class="form-control" cols="60" rows="9" required></textarea>
                                        </div>
                                        <button id="postSubmit" type="submit" class="btn btn-sm btn-outline-light col-12">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Reviews -->
                    <section id="tm-section-7" class="tm-section justify-content-center">
                        <div class="tm-bg-transparent-black tm-contact-box-pad">
                            <div class="row mb-4">
                                <header class="col-xl-12">
                                    <h2 class="tm-text-shadow">
                                        <?= Language::get( 'reviews' ); ?>
                                    </h2>
                                </header>
                            </div>
                            <div class="row">
                                <?php if ( count($reviews) == 0 ): ?>
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                        <div class="media tm-bg-transparent-black tm-border-white">
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?= Language::get( 'no-reviews' ); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: foreach ( $reviews as $review ): ?>
                                    <div id="review-div-<?= $review['id']; ?>" class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                        <div class="media tm-bg-transparent-black tm-border-white">
                                            <div class="media-body">
                                                <div class="row">
                                                    <h3 class="col-12">
                                                        <a id="powered-by" style="font-style: italic">
                                                            <?= "{$review['displayName']} ({$review['email']})"; ?>
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="row">
                                                    <h6 class="col-12">
                                                        <?= $review['createdAt']; ?>
                                                    </h6>
                                                </div>
                                                <div class="row">
                                                    <h6 class="col-12" style="user-select: none;">
                                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                                            <span class="fa fa-star<?= $i <= $review['rating'] ? ' checked' : ''; ?>"></span>
                                                        <?php endfor; ?>
                                                    </h6>
                                                </div>
                                                <div class="row">
                                                    <p class="col-12">
                                                        <?= $review['message']; ?>
                                                    </p>
                                                </div>

                                                <div class="row justify-content-between" style="margin: 30px 5px; border-spacing: 5px;" data-review-id="<?= $review['id']; ?>">
                                                    <button class="action-button btn btn-sm btn-outline-danger col-4 col-sm-4 col-md-3 col-lg-3 col-xl-3" onclick="onReviewRemoveConfirm(this);">
                                                        <?= Language::get( 'admin-blog-post-remove' ); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>

                </div>	<!-- .tm-content -->

                <footer class="footer-link">
                    <p class="tm-copyright-text" style="text-align: right !important;"> <?= Language::get( 'powered-by' ); ?> </p>
                </footer>
            </div>	<!-- row -->
        </div>


        <button id="info-modal-trigger" class="hidden" data-toggle="modal" data-target="#info-modal"></button>
        <div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="info-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="info-modal-title">Modal title</h5>
                        <button id="modal-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="info-modal-text"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <button id="error-modal-trigger" class="hidden" data-toggle="modal" data-target="#error-modal"></button>
        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="error-modal-title">Modal title</h5>
                        <button id="modal-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="error-modal-text"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <button id="confirm-modal-trigger" class="hidden" data-toggle="modal" data-target="#confirm-modal"></button>
        <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-modal-title">Modal title</h5>
                        <button id="modal-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="confirm-modal-text"></div>
                    <div class="modal-footer">
                        <button id="confirm-modal-no-btn" type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                        <button data-post-id="" id="confirm-modal-yes-btn" type="button" class="btn btn-danger" data-dismiss="modal" onclick="onPostRemove(this)">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <button id="confirm-review-remove-modal-trigger" class="hidden" data-toggle="modal" data-target="#confirm-review-remove-modal"></button>
        <div class="modal fade" id="confirm-review-remove-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-review-remove-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-review-remove-modal-title">Modal title</h5>
                        <button id="modal-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="confirm-review-remove-modal-text"></div>
                    <div class="modal-footer">
                        <button id="confirm-review-remove-modal-no-btn" type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                        <button data-review-id="" id="confirm-review-remove-modal-yes-btn" type="button" class="btn btn-danger" data-dismiss="modal" onclick="onReviewRemove(this)">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="preload-01"></div>
        <div id="preload-02"></div>
        <div id="preload-03"></div>
        <div id="preload-04"></div>

        <?php

        self::scripts( __CLASS__ );

        die;
    }

}