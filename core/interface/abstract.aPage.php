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

                $mapping = [
                    // Url  => Nav link name
                    'home'  => 'nav-link-home',
                    'about' => 'nav-link-about',
                    'blog'  => 'nav-link-blog',
                ];

                self::css( Constants::_COMPONENT_NAVBAR );
                ?>
                    <nav>
                        <div class="nav-logo">
                            <h4>Mini Cms PHP</h4>
                        </div>

                        <ul class="nav-links">
                            <?php foreach ( $mapping as $url => $navLinkName ): ?>
                                <li>
                                    <a href="<?= $url; ?>">
                                        <?= Language::get( $navLinkName, Cookie::get( Constants::_COOKIE_LANG ) ) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
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