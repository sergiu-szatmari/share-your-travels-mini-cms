<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

abstract class aPage implements iPage
{
    abstract public static function render( $context = [] ): void;

    public static function clear(): void
    {
        ob_clean();
        ob_start();
    }

    public static function headers()
    {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    }

    public static function css( string $page = '' ): void
    {
        if ( !$page ) return;

        ?>
        <style>
            <?php include_once( Constants::_DIR_CSS . $page . Constants::_CSS_EXT ); ?>
        </style>
        <?php
    }

    public static function js( string $page = '' ): void
    {
        if ( !$page ) return;

        ?>
            <script src="<?= Constants::_DIR_JS . $page . Constants::_JS_EXT ?>"></script>
        <?php
    }

    public static function component( string $componentName = '', array $context = [] ): void
    {
        if ( !$componentName ) return;

        switch ( $componentName )
        {
            case Constants::_COMPONENT_NAVBAR:

                self::css( Constants::_COMPONENT_NAVBAR );
                ?>
                    <nav>
                        <div class="nav-logo">
                            <h4>Mini Cms PHP</h4>
                        </div>

                        <ul class="nav-links">
                            <li>
                                <a href="home">
                                    <?= Language::get( 'nav-link-home', Cookie::get( Constants::_COOKIE_LANG ) ) ?>
                                </a>
                            </li>
                            <li>
                                <a href="about">
                                    <?= Language::get( 'nav-link-about', Cookie::get( Constants::_COOKIE_LANG ) ) ?>
                                </a>
                            </li>
                            <li>
                                <a href="blog">
                                    <?= Language::get( 'nav-link-blog', Cookie::get( Constants::_COOKIE_LANG ) ) ?>
                                </a>
                            </li>
                            <li>
                                <div style="right: 20px;">
                                    <a href="to-en">
                                        <span class="flag flag-england"></span>
                                    </a>
                                    <a href="to-ro">
                                        <span class="flag flag-ro"></span>
                                    </a>
                                </div>
                            </li>
                        </ul>

                        <div class="nav-burger">
                            <div class="nav-burger-line-1"></div>
                            <div class="nav-burger-line-2"></div>
                            <div class="nav-burger-line-3"></div>
                        </div>
                    </nav>
                <?php

                self::js( Constants::_COMPONENT_NAVBAR );
                break;
        }
    }
}