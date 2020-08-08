<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class SubmittedPage extends aPage
{
    public static function render($context = []): void
    {
        self::clear();

        self::headers( 'HomePage', Language::get( 'app-name' ) );

        ?>
        <script> const baseURL = "<?= Environment::getBaseURL(); ?>"; </script>
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
                                    <a href="#" id="tmNavLink1" class="scrolly active" data-bg-img="bg_05.jpg" data-page="#tm-section-1">
                                        <i class="fas fa-check tm-nav-fa-icon"></i>
                                        <span> <?= Language::get('success') ?> </span>
                                    </a>
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
                            <p class="mb-5 tm-font-big">
                                <?= Language::get( 'submitted-text' ); ?>
                            </p>
                            <a href="<?= Environment::getBaseURL(); ?>" class="btn tm-btn tm-font-big" data-nav-link="#tmNavLink2">
                                <?= Language::get( 'back-to-site-btn' ); ?>
                            </a>
                        </div>
                    </section>
                </div>	<!-- .tm-content -->
                <footer class="footer-link">
                    <p class="tm-copyright-text" style="text-align: right !important;">
                        <?= Language::get( 'powered-by' ); ?>
                    </p>
                </footer>
            </div>	<!-- row -->
        </div>
        <div id="preload-01"></div>
        <div id="preload-02"></div>
        <div id="preload-03"></div>
        <div id="preload-04"></div>

        <?php

        self::scripts( 'HomePage' );

        Logger::log( 'Submitted page' );
        Logger::mark( false );
        die;
    }

}