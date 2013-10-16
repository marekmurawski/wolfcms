<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * @package Views
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 *
 * @copyright Martijn van der Kleijn, 2008-2010
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo __('Login') . ' - ' . Setting::get('admin_title'); ?></title>
        <link rel="favourites icon" href="<?php echo PATH_PUBLIC; ?>wolf/admin/images/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php
        /* ========= LESS RUNTIME ============= 
         * Generates stylesheets ON - THE - FLY
         * if DEBUG = true
         * !!! TEMPORARY ONLY !!!
         */
        if ( DEBUG ):
            ?>
            <!-- Loads .less theme for compilation -->
            <link rel="stylesheet/less" href="<?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo Setting::get('theme'); ?>/styles.less" id="css_theme" type="text/css" />
            <script type="text/javascript">
                less = {};
            </script>
            <script src="<?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo Setting::get('theme'); ?>/less.js" type="text/javascript"></script>    
        <?php else: ?>
            <link href="<?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo Setting::get('theme'); ?>/styles.css" id="css_theme" media="screen" rel="stylesheet" type="text/css" />
        <?php
        endif;
        /* ========= LESS RUNTIME ============= */
        ?>

        <script type="text/javascript" charset="utf-8" src="<?php echo PATH_PUBLIC; ?>wolf/admin/javascripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript">
            // <![CDATA[
            $(document).ready(function() {
                (function showMessages(e) {
                    e.fadeIn('slow')
                            .animate({opacity: 1.0}, 1500)
                            .fadeOut('slow', function() {
                                if ($(this).next().attr('class') == 'message') {
                                    showMessages($(this).next());
                                }
                                $(this).remove();
                            })
                })($(".message:first"));

                $("input:visible:enabled:first").focus();
            });
            // ]]>
        </script>
    </head>
    <body>
        <?php if ( Flash::get('error') !== null ): ?>
            <div id="error" class="message" style="display: none;"><?php echo Flash::get('error'); ?></div>
        <?php endif; ?>
        <?php if ( Flash::get('success') !== null ): ?>
            <div id="success" class="message" style="display: none"><?php echo Flash::get('success'); ?></div>
        <?php endif; ?>
        <?php if ( Flash::get('info') !== null ): ?>
            <div id="info" class="message" style="display: none"><?php echo Flash::get('info'); ?></div>
        <?php endif; ?>
        <div id="login-site-title">
            <h1><?php echo Setting::get('admin_title'); ?></h1>
        </div>
        <div id="login-dialog">
            <h2><?php echo __('Login'); ?></h2>
            <form action="<?php echo get_url('login/login'); ?>" class="form-horizontal" method="post">
                <input id="login-redirect" type="hidden" name="login[redirect]" value="<?php echo $redirect; ?>" />
                <div class="form-group" id="login-username-div">
                    <div class="form-label">
                        <label class="control-label" for="login-username">
                            <?php echo __('Username'); ?>
                        </label>
                    </div>
                    <div class="form-value">
                        <input id="login-username" class="form-control" type="text" name="login[username]" value="" />
                    </div>
                </div>
                <div class="form-group" id="login-password-div">
                    <div class="form-label">
                        <label class="control-label" for="login-password">
                            <?php echo __('Password'); ?>
                        </label>
                    </div>
                    <div class="form-value">
                        <input id="login-password" class="form-control" type="password" name="login[password]" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="remember-me">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="login[remember]" value="checked" />
                                <?php echo __('Remember me for :min minutes.', array( ':min' => round(COOKIE_LIFE / 60) )); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="login-submit">
                    <button class="btn btn-primary" type="submit" accesskey="s"><?php echo __('Login'); ?></button>
                    <span class="alternate-link">(<a href="<?php echo get_url('login/forgot'); ?>"><?php echo __('Forgot password?'); ?></a>)</span>
                </div>
            </form>
        </div>
        <div id="login-footer">
            <p><?php echo __('website:') . ' <a href="' . URL_PUBLIC . '">' . Setting::get('admin_title') . '</a>'; ?></p>
        </div>
        <script type="text/javascript" charset="utf-8">
            // <![CDATA[
            var loginUsername = document.getElementById('login-username');
            if (loginUsername.value == '') {
                loginUsername.focus();
            } else {
                document.getElementById('login-password').focus();
            }
            // ]]>
        </script>
    </body>
</html>