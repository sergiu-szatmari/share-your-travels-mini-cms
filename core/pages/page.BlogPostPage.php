<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class BlogPostPage extends aPage
{
    public static function render($context = []): void
    {
        self::clear();

        $seoName        = $context['seoName'];
        $blogPost       = BlogPostManagement::getBlogpostBySeo( $seoName );

        $langCode       = ucfirst( Cookie::get(Constants::_COOKIE_LANG) );
        $getPostTitle   = "postTitle{$langCode}";
        $getPostContent = "postContent{$langCode}";

        self::headers( __CLASS__, $blogPost[ $getPostTitle ] );

        ?>
        <script> const baseURL = "<?= Environment::getEnvironment()['base_url']; ?>"; </script>
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>

        <div class="container-fluid tm-main">
            <div class="row tm-main-row">

                <!-- Sidebar -->
                <div id="tmSideBar" class="col-xl-3 col-lg-3 col-md-12 col-sm-12 sidebar" style="">

                    <button id="tmMainNavToggle" class="menu-icon">&#9776;</button>

                    <div class="inner">
                        <nav id="tmMainNav" class="tm-main-nav">
                            <ul>
                                <li>
                                    <a href="" id="tmNavLink3" class="scrolly active" data-bg-img="blogpost.jpg" data-page="#tm-section-3">
                                        <i class="fas fa-sticky-note tm-nav-fa-icon"></i>
                                        <span id="blog-post-title-nav-link"> <?= $blogPost[ $getPostTitle ]; ?> </span>
                                    </a>
                                </li>
                                <li id="language-switch-li">
                                    <button class="btn btn-sm" onclick="onChangeLanguage(this);">EN</button>
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                    <button class="btn btn-sm" onclick="onChangeLanguage(this);">RO</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 tm-content">

                    <section id="tm-section-3" class="tm-section">
                        <div class="row mb-4">
                            <header class="col-xl-12">
                                <h2 class="tm-text-shadow">
                                    <!-- Language::get( 'blog-blogposts' ); -->
                                </h2>
                            </header>
                        </div>
                        <div class="row mb-12">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                                <div class="media tm-bg-transparent-black tm-border-white">
<!--                                    <i class="fab fa-apple tm-icon-circled tm-icon-media"></i>-->
<!--                                    <i class="fas fa-sticky-note tm-icon-circled tm-icon-media"></i>-->
                                    <div class="media-body">
                                        <div class="row">
                                            <h1 class="col-12">
                                                <?= $blogPost[ $getPostTitle ]; ?>
                                            </h1>
                                        </div>
                                        <div class="row">
                                            <h6 class="col-12">
                                                <?= $blogPost['createdAt']; ?>

                                            </h6>
                                        </div>
                                        <div class="row">
                                            <p class="col-12">
                                                <?= $blogPost[ $getPostContent ]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <footer class="footer-link">
                    <p class="tm-copyright-text" style="text-align: right !important;"> <?= Language::get( 'powered-by' ); ?> </p>
                </footer>
            </div>
        </div>

        <div id="preload-01"></div>
        <div id="preload-02"></div>
        <div id="preload-03"></div>
        <div id="preload-04"></div>

        <?php

        self::scripts( __CLASS__ );

        ?>
        <script>
            document.addEventListener('load', () => {
                setTimeout(() => {
                    changePage(gimme('a'));
                }, 0);
            });
        </script>
        <?php
        Logger::log( "Blog post page for post '{$seoName}'" );
        Logger::mark( false );
        die;
    }

}