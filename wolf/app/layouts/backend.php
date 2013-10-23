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
 * @package Layouts
 */
/* Security measure */
if ( !defined('IN_CMS') ) {
    exit();
}

// Redirect to front page if user doesn't have appropriate roles.
if ( !AuthUser::hasPermission('admin_view') ) {
    header('Location: ' . URL_PUBLIC . ' ');
    exit();
}

// Setup some stuff...
$ctrl   = Dispatcher::getController(Setting::get('default_tab'));
$action = Dispatcher::getAction();

// Allow for nice title.
// @todo improve/clean this up.
if ( !isset($title) || trim($title) == '' ) {
    $title = ($ctrl == 'plugin') ? Plugin::$controllers[Dispatcher::getAction()]->label : ucfirst($ctrl) . 's';
    if ( isset($this->vars['content_for_layout']->vars['action']) ) {
        $tmp = $this->vars['content_for_layout']->vars['action'];
        $title .= ' - ' . ucfirst($tmp);

        if ( $tmp == 'edit' && isset($this->vars['content_for_layout']->vars['page']) ) {
            $tmp = $this->vars['content_for_layout']->vars['page'];
            $title .= ' - ' . $tmp->title;
        }
    }
}
?><!DOCTYPE html>
<html lang="<?php echo AuthUser::getRecord()->language; ?>">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <title><?php
            use_helper('Kses');
            echo $title . ' | ' . kses(Setting::get('admin_title'), array());
            ?></title>

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
            <link href="<?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo $current_theme; ?>/styles.css" id="css_theme" rel="stylesheet" type="text/css" />
        <?php
        endif;
        /* ========= LESS RUNTIME ============= */
        ?>

        <!-- temporarily using CDN version of jQuery v.1.8.3 - latest non-revolutionary ;) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- NOT NEEDED in HTML5 - we have input types! <script type="text/javascript" src="<?php echo PATH_PUBLIC; ?>wolf/admin/javascripts/cp-datepicker.js"></script> -->
        <script type="text/javascript" src="<?php echo PATH_PUBLIC; ?>wolf/admin/javascripts/wolf.js"></script>
        <script type="text/javascript" src="<?php echo PATH_PUBLIC; ?>wolf/admin/javascripts/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo PATH_PUBLIC; ?>wolf/admin/javascripts/jquery.ui.nestedSortable.js"></script>
        <script type="text/javascript" src="<?php echo PATH_PUBLIC; ?>wolf/admin/markitup/jquery.markitup.js"></script>

        <?php Observer::notify('view_backend_layout_head', CURRENT_PATH); ?>

        <link rel="stylesheet" type="text/css" href="<?php echo PATH_PUBLIC; ?>wolf/admin/markitup/skins/simple/style.css" />

        <?php
        foreach ( Plugin::$plugins as $plugin_id => $plugin ):
            if ( file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/' . $plugin_id . '.js') ) {
                echo '<script type = "text/javascript" charset = "utf-8" src = "' . PATH_PUBLIC . 'wolf/plugins/' . $plugin_id . '/' . $plugin_id . '.js"></script>' . PHP_EOL . "\t";
            }
            if ( file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/' . $plugin_id . '.css') ) {
                echo '<link href = "' . PATH_PUBLIC . 'wolf/plugins/' . $plugin_id . '/' . $plugin_id . '.css" media = "screen" rel = "Stylesheet" type = "text/css" />' . PHP_EOL . "\t";
            }
        endforeach;

        foreach ( Plugin::$stylesheets as $plugin_id => $stylesheet ) {
            echo '<link type="text/css" href = "' . PATH_PUBLIC . 'wolf/plugins/' . $stylesheet . '" media = "screen" rel = "stylesheet" />' . PHP_EOL . "\t";
        }
        foreach ( Plugin::$javascripts as $jscript_plugin_id => $javascript ) {
            echo '<script type="text/javascript" charset="utf-8" src="' . PATH_PUBLIC . 'wolf/plugins/' . $javascript . '"></script>' . PHP_EOL . "\t";
        }
        ?>

        <script type="text/javascript">
            // <![CDATA[
            function setConfirmUnload(on, msg) {
                window.onbeforeunload = (on) ? unloadMessage : null;
                return true;
            }

            function unloadMessage() {
                return '<?php echo __('You have modified this page.  If you navigate away from this page without first saving your data, the changes will be lost.'); ?>';
            }

            $(document).ready(function() {
                (function showMessages(e) {
                    e.fadeIn('slow')
                            .animate({opacity: 1.0}, Math.min(5000, parseInt(e.text().length * 50)))
                            .fadeOut('slow', function() {
                                if ($(this).next().hasClass('flash-message')) {
                                    showMessages($(this).next());
                                }
                                // $(this).remove();
                            });
                })($(".flash-message:first"));

                $("input:visible:enabled:first").focus();

                // Get the initial values and activate filter
                $('.filter-selector').each(function() {
                    var $this = $(this);
                    $this.data('oldValue', $this.val());

                    if ($this.val() == '') {
                        return true;
                    }
                    var elemId = $this.attr('id').slice(0, -10);
                    var elem = $('#' + elemId + '_content');
                    $this.trigger('wolfSwitchFilterIn', [$this.val(), elem]);
                });

                $(document).on('change', '.filter-selector', function() {
                    var $this = $(this);
                    var newFilter = $this.val();
                    var oldFilter = $this.data('oldValue');
                    $this.data('oldValue', newFilter);
                    var elemId = $this.attr('id').slice(0, -10);
                    var elem = $('#' + elemId + '_content');
                    $(this).trigger('wolfSwitchFilterOut', [oldFilter, elem]);
                    $(this).trigger('wolfSwitchFilterIn', [newFilter, elem]);
                });
            });
            // ]]>
        </script>
    </head>
    <body id="body_<?php echo $ctrl . '_' . Dispatcher::getAction(); ?>">
        <div id="wrap">
            <div id="header" style="display: none">
                <div class="site-links">
                    <p>
                        <?php echo __('You are currently logged in as'); ?> <a href="<?php echo get_url('user/edit/' . AuthUser::getId()); ?>"><?php echo AuthUser::getRecord()->name; ?></a>
                    </p>
                    <ul class="list-inline">
                        <li>
                            <a id="site-view-link" href="<?php echo URL_PUBLIC; ?>" target="_blank">
                                <?php echo __('View Site'); ?>
                                <span class="glyphicon glyphicon-new-window"></span> 
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_url('login/logout' . '?csrf_token=' . SecureToken::generateToken(BASE_URL . 'login/logout')); ?>">
                                <?php echo __('Log Out'); ?>
                                <span class="glyphicon glyphicon-log-out"></span> 
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="site-title">
                    <h1><a href="<?php echo get_url(); ?>"><?php echo Setting::get('admin_title'); ?></a></h1>
                </div>
            </div> <!-- #header -->
            <nav id="navigation" class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo get_url(); ?>" class="navbar-brand"><?php echo Setting::get('admin_title'); ?></a>
                </div>            
                <div class="collapse navbar-collapse">
                    <section class="nav navbar-nav">
                        <li id="page-plugin" class="<?php echo ( $ctrl == 'page' ) ? 'plugin active' : 'plugin'; ?>">
                            <a href="<?php echo get_url('page'); ?>">
                                <?php echo __('Pages'); ?>
                            </a>
                        </li>
                        <?php if ( AuthUser::hasPermission('snippet_view') ): ?>

                            <li id="snippet-plugin" class="<?php echo ( $ctrl == 'snippet' ) ? 'plugin active' : 'plugin'; ?>">
                                <a href="<?php echo get_url('snippet'); ?>">
                                    <?php echo __('MSG_SNIPPETS'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( AuthUser::hasPermission('layout_view') ): ?>

                            <li id="layout-plugin" class="<?php echo ( $ctrl == 'layout' ) ? 'plugin active' : 'plugin'; ?>">
                                <a href="<?php echo get_url('layout'); ?>">
                                    <?php echo __('Layouts'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php foreach ( Plugin::$controllers as $plugin_name => $plugin ): ?>
                            <?php if ( $plugin->show_tab && (AuthUser::hasPermission($plugin->permissions)) ): ?>
                                <?php Observer::notify('view_backend_list_plugin', $plugin_name, $plugin); ?>
                                <?php if ( !empty($plugin->label) ): ?>

                                    <li id="<?php echo $plugin_name; ?>-plugin" class="<?php echo ( $ctrl == 'plugin' && $action == $plugin_name ) ? 'plugin active' : 'plugin'; ?>">
                                        <a href="<?php echo get_url('plugin/' . $plugin_name); ?>">
                                            <?php echo $plugin->label; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </section>
                    <section class="nav navbar-nav navbar-right">
                        <li class="dropdown<?php echo ( $ctrl == 'setting' || $ctrl == 'user' ) ? ' active' : ''; ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="navbar-settings">
                                    <?php echo __('Settings'); ?> <b class="caret"></b>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ( AuthUser::hasPermission('admin_edit') ): ?>
                                    <li class="<?php echo ( $ctrl == 'setting' ) ? ' active' : ''; ?>">
                                        <a href="<?php echo get_url('setting'); ?>"><span class="glyphicon glyphicon-cog"></span> <?php echo __('Administration'); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ( AuthUser::hasPermission('user_view') ): ?>
                                    <li class="<?php echo ( $ctrl == 'user' ) ? ' active' : ''; ?>">
                                        <a href="<?php echo get_url('user'); ?>"><span class="glyphicon glyphicon-user"></span> <?php echo __('Users'); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="navbar-username">
                                    <?php echo AuthUser::getRecord()->name; ?>
                                </span>
                                <?php
                                use_helper('Gravatar');
                                echo Gravatar::img(AuthUser::getRecord()->email, array( 'align' => 'middle', 'alt' => 'user icon', 'class' => 'navbar-user-gravatar' ), '32', URL_PUBLIC . 'wolf/admin/images/user.png', 'g', USE_HTTPS);
                                ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo get_url('user/edit/' . AuthUser::getId()); ?>">
                                        <span class="glyphicon glyphicon-user"></span> 
                                        <?php echo __('Edit user'); ?>
                                    </a>
                                <li>
                                    <a id="site-view-link" href="<?php echo URL_PUBLIC; ?>" target="_blank">
                                        <?php echo __('View Site'); ?>
                                        <span class="glyphicon glyphicon-new-window"></span> 
                                    </a>
                                </li>
                                <li role="presentation" class="divider"></li>
                                <li>
                                    <a href="<?php echo get_url('login/logout' . '?csrf_token=' . SecureToken::generateToken(BASE_URL . 'login/logout')); ?>">
                                        <span class="glyphicon glyphicon-log-out"></span> 
                                        <?php echo __('Log Out'); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>                        
                    </section>
                </div>
            </nav> <!-- #navigation.navbar -->
            <div id="flash-messages">
                <?php if ( Flash::get('error') !== null ): ?>
                    <div id="error" class="alert alert-danger alert-dismissable flash-message">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo Flash::get('error'); ?>
                    </div>
                <?php endif; ?>
                <?php if ( Flash::get('success') !== null ): ?>
                    <div id="success" class="alert alert-success alert-dismissable flash-message">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo Flash::get('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if ( Flash::get('info') !== null ): ?>
                    <div id="info" class="alert alert-info alert-dismissable flash-message">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo Flash::get('info'); ?>
                    </div>
                <?php endif; ?>
            </div><!--  #flash-messages -->
            <div id="main">
                <div id="content-wrapper">
                    <div id="content">
                        <!-- content -->
                        <?php echo $content_for_layout; ?>
                        <!-- end content -->
                    </div>
                </div>
                <?php if ( isset($sidebar) ): ?>
                    <div id="sidebar-wrapper">
                        <aside id="sidebar">
                            <div class="visible-xs"><hr/><h2><?php echo __('Sidebar'); ?></h2></div>
                            <!-- sidebar -->
                            <?php echo $sidebar; ?>
                            <!-- end sidebar --> 
                        </aside>
                    </div>
                <?php endif; ?> 
            </div><!--  #main -->
        </div><!-- #wrap -->
        <div id="footer">
            <div class="debug-info">
                <?php if ( DEBUG ): ?>                
                    <p class="stats">
                        <span><?php echo __('Page rendered in'); ?> <?php echo execution_time(); ?> <?php echo __('seconds'); ?></span>
                        |
                        <span><?php echo __('Memory usage:'); ?> <?php echo memory_usage(); ?></span>
                        <!--
                        ======= TEMPORARY ========
                        -->
                    <div class="form-group has-error" style="max-width: 200px; display: inline-block;">
                        <select class="form-control input-sm" style="display: inline;" id="setting_theme_debug">
                            <?php
                            // $current_theme = Setting::get('theme');
                            foreach ( Setting::getThemes() as $code => $label ):
                                ?>
                                <option value="<?php echo $code; ?>"<?php if ( $code == $current_theme ) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
                            <?php endforeach; ?>
                        </select>                    
                    </div>
                    <!--
                    ======= TEMPORARY ========
                    -->
                    </p>
                <?php endif; ?>
            </div>
            <div class="version-info">
                <p>
                    <?php echo __('Thank you for using'); ?> <a href="http://www.wolfcms.org/" target="_blank">Wolf CMS</a> <?php echo CMS_VERSION; ?>
                </p>
                <ul class="list-inline">
                    <li><a href="http://forum.wolfcms.org/" target="_blank"><?php echo __('Feedback'); ?></a></li>
                    <li><a href="http://wiki.wolfcms.org/" target="_blank"><?php echo __('Documentation'); ?></a></li>
                </ul>
            </div>
        </div><!--  #footer -->
        <!--
        ======= TEMPORARY ========


        <div class="container" style="padding-bottom: 50px;">
            <hr/>
            <div class="col-xs-12 text-center">
                <p class="text-success text-center">
        <?php if ( defined('LESS_DEBUG') && (LESS_DEBUG == true) ): ?>
                                            Using <b class="text-danger">LESS.js</b> for live stylesheeet compilation: 
                                            <code>
            <?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo $current_theme; ?>/styles.less
                                            </code>
        <?php else: ?>
                                            Using <b class="text-danger">static preprocessed CSS</b> stylesheet: 
                                            <code>
            <?php echo PATH_PUBLIC; ?>wolf/admin/themes/<?php echo $current_theme; ?>/styles.css
                                            </code>
                                            <br/>
                                            To use <b>*.less</b> version set <code>LESS_DEBUG=true</code> in <code>config.php</code>
        <?php endif; ?>
                </p>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <select class="form-control input-sm" id="setting_theme_debug">
        <?php
        $current_theme = Setting::get('theme');
        foreach ( Setting::getThemes() as $code => $label ):
            ?>
                                                    <option value="<?php echo $code; ?>"<?php if ( $code == $current_theme ) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-sm btn-default btn-block" data-toggle="collapse" data-target="#querylog">
                            Record::getQueryLog() toggle
                        </button>
                    </div>
                </div>
                <div id="querylog" class="collapse<?php echo (isset($_COOKIE['showquerylog'])) ? ' in' : ''; ?>">
                    <pre class="text-left" style="font-size: 11px;"><?php
        print_r(Record::getQueryLog())
        ?></pre>
                </div>

            </div>
        </div>
        <!--
        ======= TEMPORARY ========
        -->
        <script>
            $(document).ready(function() {
                $('#querylog').on('hide.bs.collapse', function() {
                    document.cookie = 'showquerylog=0; expires=Sat, 25 Dec 2010 06:07:00 UTC; path=/';
                    console.log('collapse');
                });
                $('#querylog').on('show.bs.collapse', function() {
                    document.cookie = 'showquerylog=1; expires=1 Jan 2020 01:00:00 UTC; path=/';
                    console.log('show');
                });
                $('#setting_theme_debug').change(function() {
                    var theme = '<?php echo PATH_PUBLIC; ?>wolf/admin/themes/' + this.value + '/styles.<?php
        echo ( defined('LESS_DEBUG') && LESS_DEBUG ) ? 'less' : 'css';
        ?>';
                    $('#css_theme').attr({"href": theme});
                    document.cookie = 'tmp_theme=' + encodeURIComponent(this.value) + '; path=/';
                });
            });
        </script>
        <script src="<?php echo PATH_PUBLIC; ?>wolf/admin/javascripts/bootstrap.min.js"></script>
    </body>
</html>
