<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class LoginPage extends aPage
{
    public static function render( $context = [] ): void
    {
        $appName = Language::get( 'app-name' );
        self::clear();

        self::headers( __CLASS__, "{$appName} Admin" );

        ?>
        <div class="wrapper">
            <form class="form-signin" method="post" action="">
                <h2 class="form-signin-heading">
                    <?= $appName; ?> Admin
                </h2>
                <input type="hidden" name="action" value="login">
                <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off" required autofocus/>
                <br>
                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required/>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            </form>
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

        <?php
        self::scripts( __CLASS__ );

        if ( isset($context['error']) && !!$context['error'] ) echo "<script> onError('{$context['error']}')</script>";

        Logger::mark( false );
        die;
    }
}