<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * @package Views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo __('Forgot password'); ?></title>
        <link rel="favourites icon" href="<?php echo PATH_PUBLIC; ?>wolf/admin/images/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php
        /* ========= LESS RUNTIME ============= 
         * Generates stylesheets ON - THE - FLY
         * if LESS_DEBUG = true /in config.php/
         * !!! TEMPORARY ONLY !!!
         * 
         */
        $current_theme = (isset($_COOKIE['tmp_theme']) && file_exists(CMS_ROOT . DS . 'wolf/admin/themes/' . $_COOKIE['tmp_theme'])) ? $_COOKIE['tmp_theme'] : Setting::get('theme');

        if ( defined('LESS_DEBUG') && LESS_DEBUG ):
            ?>
            <!-- Loads .less theme for compilation -->
            <link rel="stylesheet/less" href="<?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo $current_theme ?>/styles.less" id="css_theme" type="text/css" />
            <script type="text/javascript">
                less = {};
            </script>
            <script src="<?php echo PATH_PUBLIC; ?>wolf/admin/javascripts/less.js" type="text/javascript"></script>
        <?php else: ?>
            <link href="<?php echo PATH_PUBLIC; ?>wolf/admin/stylesheets/bootstrap.wolf.css" id="css_theme_wolf" rel="stylesheet" type="text/css" />
            <link href="<?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo $current_theme; ?>/styles.css" id="css_theme" media="screen" rel="stylesheet" type="text/css" />
        <?php
        endif;
        /* ========= LESS RUNTIME ============= */
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

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
        <div id="login-site-title">
            <h1><?php echo Setting::get('admin_title'); ?></h1>
        </div>        
        <div id="login-dialog">
            <h2><?php echo __('Forgot password'); ?></h2>
            <?php if ( Flash::get('error') !== null ): ?>
                <div id="error" class="message" style="display: none;"><?php echo Flash::get('error'); ?></div>
            <?php endif; ?>
            <?php if ( Flash::get('success') !== null ): ?>
                <div id="success" class="message" style="display: none"><?php echo Flash::get('success'); ?></div>
            <?php endif; ?>
            <?php if ( Flash::get('info') !== null ): ?>
                <div id="info" class="message" style="display: none"><?php echo Flash::get('info'); ?></div>
            <?php endif; ?>
            <form action="<?php echo get_url('login', 'forgot'); ?>" method="post" class="form-horizontal">
                <div class="form-group">
                    <div class="form-label">
                        <label class="control-label" for="forgot-email">
                            <?php echo __('Email address'); ?>
                        </label>
                    </div>
                    <div class="form-value">
                        <input class="form-control" id="forgot-email" type="text" name="forgot[email]" value="<?php echo $email; ?>" />
                    </div>
                </div>
                <div class="login-submit">
                    <button class="btn btn-primary" type="submit" accesskey="s">
                        <?php echo __('Send password'); ?>
                    </button>
                    <span class="alternate-link">
                        <a href="<?php echo get_url('login'); ?>"><?php echo __('Login'); ?></a>
                    </span>
                </div>
            </form>
        </div>
        <div id="login-footer">
            <p><?php echo __('website:') . ' <a href="' . URL_PUBLIC . '">' . Setting::get('admin_title') . '</a>'; ?></p>
        </div>
    </body>
</html>