<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Login extends aPage
{
    public static function render( $context = [] ): void
    {
        self::clear();
        self::headers();
        self::css( __CLASS__ );

        $context['error'] = $context['error'] ?? null;
        if ( $context['error'] )
        {
            ?> <script> alert("<?= $context['error']; ?>"); </script> <?php
        }

        ?>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: sans-serif;
                background: #34495e;
            }

            .login-box {
                width: 300px;
                padding: 40px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #191919;
                text-align: center;
            }

            .login-box h1 {
                color: white;
                text-transform: uppercase;
                font-weight: 500;
            }

            .login-box input[type="text"],
            .login-box input[type="password"] {

                /*border: 0;*/
                background: none;
                display: block;
                margin: 20px auto;
                text-align: center;
                border: 2px solid #3498db;
                padding: 14px 10px;
                width: 200px;
                outline: none;
                color: white;
                border-radius: 24px;
                transition: 0.25s;
            }

            .login-box input[type="text"]:focus,
            .login-box input[type="password"]:focus {
                width: 280px;
                border-color: #2ecc71;
            }

            .login-box input[type="submit"] {

                /*border: 0;*/
                background: none;
                display: block;
                margin: 20px auto;
                text-align: center;
                border: 2px solid #2ecc71;
                padding: 14px 40px;
                width: 200px;
                outline: none;
                color: white;
                border-radius: 24px;
                transition: 0.25s;
                cursor: pointer;
            }

            .login-box input[type="submit"]:hover {
                background: #2ecc71;
            }
        </style>

        <form class="login-box" action="" method="POST">
            <h1>Mini-Cms-PHP Admin</h1>
            <input type="hidden" name="action" value="login">
            <input type="text" name="username" placeholder="Username" autocomplete="off">
            <input type="password" name="password" placeholder="Password" autocomplete="off">
            <input type="submit" name="" value="Login">
        </form>

        <?php
        die;
    }
}