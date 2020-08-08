<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class HomePage extends aPage
{
    public static function render( $context = [] ): void
    {
        self::clear();
        self::headers( __CLASS__, Language::get( 'app-name' ) );

        $langCode       = ucfirst( Cookie::get(Constants::_COOKIE_LANG) );
        $formQuestions  = Language::get( 'contact-questions' );
        $aboutEntries   = [
            '1' => 'fa fa-paperclip',
            '2' => 'fa fa-question',
            '3' => 'fa fa-ellipsis-h',
            '4' => 'fa fa-check',
            '5' => 'fa fa-briefcase',
            '6' => 'fa fa-paper-plane',
        ];
        $postTitle = "postTitle{$langCode}";
        $postContent = "postContent{$langCode}";
        $blogPosts = BlogPostManagement::getBlogposts( $newestFirst = true );
        $reviews = ReviewManagement::getReviews( $newestFirst = true );
        ?>

        <script> const formQuestionsCount = parseInt("<?= count($formQuestions); ?>"); </script>
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
                                    <a onclick="onSwitchPage(this);" href="#" data-page-id="home" id="tmNavLink1" class="scrolly active" data-bg-img="bg_01.jpg" data-page="#tm-section-1">
                                        <i class="fas fa-home tm-nav-fa-icon"></i>
                                        <span> <?= Language::get('nav-link-home') ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="onSwitchPage(this);" href="#" data-page-id="about" id="tmNavLink2" class="scrolly" data-bg-img="bg_02.jpg" data-page="#tm-section-2" data-page-type="carousel">
                                        <i class="fas fa-address-card tm-nav-fa-icon"></i>
                                        <span> <?= Language::get( 'nav-link-about' ); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="onSwitchPage(this);" href="#" data-page-id="blog" class="scrolly" data-bg-img="bg_03.jpg" data-page="#tm-section-3">
                                        <i class="fas fa-sticky-note tm-nav-fa-icon"></i>
                                        <span> <?= Language::get( 'nav-link-blog' ); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="onSwitchPage(this);" href="#" data-page-id="join" class="scrolly" data-bg-img="bg_04.jpg" data-page="#tm-section-4">
                                        <i class="fas fa-comments tm-nav-fa-icon"></i>
                                        <span> <?= Language::get( 'nav-link-contact' ); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="onSwitchPage(this);" href="#" data-page-id="reviews" class="scrolly" data-bg-img="bg_05.jpg" data-page="#tm-section-5">
                                        <i class="fas fa-star tm-nav-fa-icon"></i>
                                        <span> <?= Language::get('reviews'); ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a id="toggle-review" style="display: none;" href="#" class="scrolly" data-page="#tm-section-6"></a>
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

                    <!-- Home / Landing page -->
                    <section id="tm-section-1" class="tm-section">
                        <div class="ml-auto">
                            <header class="mb-4">
                                <h1 class="tm-text-shadow">
                                    <?= Language::get( 'app-name' ); ?>
                                </h1>
                            </header>
                            <p class="mb-5 tm-font-big">“Life is short and the world is wide.”</p>
                            <a href="#" class="btn tm-btn tm-font-big" data-nav-link="#tmNavLink2" onclick="onWhoAmI();">
                                <?= Language::get( 'home-whoami' ); ?>
                            </a>
                        </div>
                    </section>

                    <!-- About -->
                    <a href="topabout"></a>
                    <section id="tm-section-2" class="tm-section tm-section-carousel">
                        <div>
                            <header class="mb-4"><h2 class="tm-text-shadow"> <?= Language::get( 'about-aboutme' ); ?> </h2></header>
                            <div class="tm-img-container">

                                <div class="tm-img-slider">
                                    <?php foreach ($aboutEntries as $idx => $icon): ?>
                                        <div class="tm-bg-transparent-black col-12">
                                            <div class="row justify-content-center">
                                                <i class="<?= $icon; ?> tm-icon-circled tm-icon-media"></i>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <p> <?= Language::get( "about-{$idx}" ); ?> </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Blog -->
                    <section id="tm-section-3" class="tm-section">
                        <div class="row mb-4">
                            <header class="col-xl-12"><h2 class="tm-text-shadow"> <?= Language::get( 'blog-blogposts' ); ?></h2></header>
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
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                    <div class="media tm-bg-transparent-black tm-border-white">
                                        <i class="fas fa-sticky-note tm-icon-circled tm-icon-media"></i>
                                        <div class="media-body">
                                            <div class="row">
                                                <h3 class="col-12">
                                                    <a id="powered-by" href="<?= Environment::getBaseURL()."/posts/{$blogPost['seo']}"; ?>" target="_blank">
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
                                                    <?= BlogPostManagement::trimContent( $blogPost['seo'], $blogPost[ $postContent ], 50 ) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>

                    <!-- Join -->
                    <section id="tm-section-4" class="tm-section">
                        <div class="tm-bg-transparent-black tm-contact-box-pad">
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <header>
                                        <h2 class="tm-text-shadow">
                                            <?= Language::get( 'contact-title' ); ?>
                                        </h2>
                                    </header>
                                </div>
                            </div>
                            <div class="row tm-page-4-content">
                                <div class="col-md-6 col-sm-12 tm-contact-col">
                                    <div class="tm-address-box">
                                        <p> <?= Language::get( 'contact-text1' ); ?> </p>
                                        <p> <?= Language::get( 'contact-text2' ); ?> </p>
                                        <p> <?= Language::get( 'contact-text3' ); ?> </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 tm-contact-col">
                                    <div class="contact_message">
                                        <form action="" method="post" id="contact_form" class="contact-form">

                                            <input type="hidden" name="action" value="formSubmit">

                                            <?php $first = true; foreach ($formQuestions as $formQuestion): ?>

                                            <div
                                                class="form-group <?= $first ? "current-form-question" : ""; ?>"
                                                data-question-id="<?= $formQuestion['questionID']; ?>"
                                                style="<?= !$first ? "display: none;" : ""; ?>"
                                            >
                                                <textarea
                                                    name="<?= $formQuestion['name']; ?>"
                                                    class="form-control"
                                                    rows="9"
                                                    placeholder="<?= "* {$formQuestion['questionID']}. {$formQuestion['question']}"; ?>"
                                                    required
                                                ></textarea>
                                            </div>


                                            <?php $first = $first && false; endforeach; ?>

                                            <div class="row justify-content-between">
                                                <button style="font-size: 2vh; visibility: hidden;" id="contact-form-prev" type="button" class="btn form-btn col-5 col-md-4 col-sm-12 justify-content-evenly" onclick="prevQuestion();">
                                                    <?= Language::get( 'contact-prev' ); ?>
                                                </button>

                                                <button style="font-size: 2vh;" id="contact-form-next" type="button" class="btn form-btn col-5 col-md-4 col-sm-12 justify-content-evenly" onclick="nextQuestion();">
                                                    <?= Language::get( 'contact-next' ); ?>
                                                </button>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Reviews -->
                    <section id="tm-section-5" class="tm-section justify-content-center">
                        <div class="tm-bg-transparent-black tm-contact-box-pad">
                            <div class="row mb-4">
                                <header class="col-xl-12">
                                    <h2 class="tm-text-shadow">
                                        <?= Language::get( 'reviews' ); ?>
                                    </h2>
                                </header>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                    <button class="btn btn-outline-light col-12" onclick="onNewReview();">
                                        <?= Language::get( 'add-review' ); ?>
                                    </button>
                                </div>
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
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                    <div class="media tm-bg-transparent-black tm-border-white">
                                        <div class="media-body">
                                            <div class="row">
                                                <h3 class="col-12">
                                                    <a id="powered-by" style="font-style: italic">
                                                        <?= $review['displayName']; ?>
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
                                        </div>
                                    </div>
                                </div>

                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>

                    <!-- Add review -->
                    <section id="tm-section-6" class="tm-section">
                        <div class="tm-bg-transparent-black tm-contact-box-pad">
                            <div class="row tm-page-12-content ">
                                <div class="col-md-12 col-sm-12 justify-content-between">
                                    <div class="">
                                        <form action="" method="post" id="new-review-form" class="contact-form">
                                            <div class="form-group">
                                                <label for="add-review-name"><?= Language::get( 'add-review-name' ); ?></label>
                                                <input type="text" id="add-review-name" name="review_name" class="form-control" placeholder="<?= Language::get( 'name' ); ?>" required autocomplete="off">
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label for="add-review-email"><?= Language::get( 'add-review-email' ); ?></label>
                                                <input type="email" id="add-review-email" name="review_email" class="form-control" placeholder="Email" required autocomplete="off">
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label for="add-review-rating"><?= Language::get( 'add-review-rating' ); ?></label>
                                                <input type="hidden" id="add-review-rating" name="review_rating" required value="">
                                                <div class="row">
                                                    <?php for ( $i = 0; $i < 5; $i++ ): ?>
                                                        <span
                                                                class="fa fa-star new-review"
                                                                data-pos="<?= $i; ?>"
                                                                onclick="onRatingSet(this);"
                                                                onmouseenter="onRatingHover(this);"
                                                                onmouseleave="onRatingUnhover();"></span>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label for="add-review-message"> <?= Language::get( 'add-review-message' ); ?></label>
                                                <textarea id="add-review-message" name="review_message" class="form-control" rows="5" placeholder="<?= Language::get( 'message' ); ?>" required autocomplete="off"></textarea>
                                            </div>

                                            <div class="row justify-content-between">
                                                <button style="font-size: 2vh;" type="button" class="btn form-btn col-5 col-md-4 col-sm-12 justify-content-evenly" onclick="cancelAddReview();">
                                                    <?= Language::get( 'js-subscribe-btn-cancel' ); ?>
                                                </button>

                                                <button style="font-size: 2vh; color: lightgreen; border-color: lightgreen;" type="button" class="btn form-btn col-5 col-md-4 col-sm-12 justify-content-evenly" onclick="submitReview();">
                                                    <?= Language::get( 'submit-review' ); ?>
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <footer id="powered-by-footer" class="footer-link">
                    <p class="tm-copyright-text" style="text-align: right !important;"> <?= Language::get( 'powered-by' ); ?> </p>
                </footer>
            </div
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

        <button id="subscribe-modal-trigger" class="hidden" data-toggle="modal" data-target="#subscribe-modal"></button>
        <div class="modal fade" id="subscribe-modal" tabindex="-1" role="dialog" aria-labelledby="subscribe-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subscribe-modal-title">Modal title</h5>
                        <button id="modal-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="subscribe-modal-text"></div>
                    <div class="modal-body justify-content-center">
                        <input type="text" id="subscribe-modal-input" class="form-control" placeholder="email@example.com">
                    </div>
                    <div class="modal-footer">
                        <button id="subscribe-modal-btn-cancel" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button id="subscribe-modal-btn-submit" type="button" class="btn btn-outline-success" data-dismiss="modal" onclick="onSubscribe();">Subscribe</button>
                    </div>
                </div>
            </div>
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

        <div id="preload-01"></div>
        <div id="preload-02"></div>
        <div id="preload-03"></div>
        <div id="preload-04"></div>









        <?php

        self::scripts( __CLASS__ );

        Logger::mark( false );
        die();
    }

}