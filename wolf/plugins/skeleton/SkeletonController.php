<?php

/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * The skeleton plugin serves as a basic plugin template.
 *
 * This skeleton plugin makes use/provides the following features:
 * - A controller without a tab
 * - Three views (sidebar, documentation and settings)
 * - A documentation page
 * - A sidebar
 * - A settings page (that does nothing except display some text)
 * - Code that gets run when the plugin is enabled (enable.php)
 *
 * Note: to use the settings and documentation pages, you will first need to enable
 * the plugin!
 *
 * @package Plugins
 * @subpackage skeleton
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
/* Security measure */
if ( !defined('IN_CMS') ) {
    exit();
}


/**
 * Use this SkeletonController and this skeleton plugin as the basis for your
 * new plugins if you want.
 */
class SkeletonController extends PluginController {

    public function __construct() {
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/skeleton/views/sidebar'));

    }


    public function index() {
        $this->documentation();

    }


    public function test_page() {
        $this->display('skeleton/views/test_page');

    }


    public function documentation() {
        $this->display('skeleton/views/documentation');

    }


    function settings() {
        /** You can do this...
          $tmp = Plugin::getAllSettings('skeleton');
          $settings = array('my_setting1' => $tmp['setting1'],
          'setting2' => $tmp['setting2'],
          'a_setting3' => $tmp['setting3']
          );
          $this->display('comment/views/settings', $settings);
         *
         * Or even this...
         */
        $this->display('skeleton/views/settings', Plugin::getAllSettings('skeleton'));

    }


    /*
     * Callback for
     * Observer::observe('view_page_edit_tab_links');
     */

    public static function callback_view_backend_list_plugin(&$plugin_name, &$plugin) {
        if ( $plugin_name == 'skeleton' ) {
            $plugin->label = '';
            $params        = Dispatcher::getParams();
            $params        = (!empty($params)) ? $params : array( '' );
            echo
            '
      <li class="dropdown' . (( Dispatcher::getController() == 'plugin' && Dispatcher::getAction() == 'skeleton' ) ? ' active' : '') . '">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Skeleton <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li class="dropdown-header">Menu header</li>
          <li' . (( Dispatcher::getController() == 'plugin' && Dispatcher::getAction() == 'skeleton' && $params[0] == 'documentation') ? ' class="active"' : '') . '><a href="' . get_url('plugin', 'skeleton', 'documentation') . '"><span class="glyphicon glyphicon-question-sign"></span> Documentation</a></li>
          <li class="divider"></li>
          <li' . (( Dispatcher::getController() == 'plugin' && Dispatcher::getAction() == 'skeleton' && $params[0] == 'test_page') ? ' class="active"' : '') . '><a href="' . get_url('plugin', 'skeleton', 'test_page') . '"><span class="glyphicon glyphicon-cutlery"></span> HTML Test page</a></li>
          <li><a href="http://getbootstrap.com/components/#glyphicons"><span class="glyphicon glyphicon-list"></span> Glyphicons list</a></li>
        </ul>
      </li>
';
        }

    }


    /*
     * Callback for
     * Observer::observe('view_page_edit_tab_links');
     */

    public static function callback_view_page_edit_tab_links($page) {
        echo '<li><a href="#skeleton-content" data-toggle="tab">Skeleton</a></li>';

    }


    /*
     * Callback for
     * Observer::observe('view_page_edit_tabs');
     * 
     * Responsible for Page Edit tab generation
     * This callback creates "Skeleton" tab
     */

    public static function callback_view_page_edit_tabs($page) {
        $prevPage = $page->previous();
        $nextPage = $page->next();
        echo '<div id="skeleton-content" class="tab-pane settings-tab-pane">';
        echo '  <dl class="dl-horizontal">';
        echo '      <dt>This page level</dt>';
        echo '      <dd>' . $page->level() . '</dd>';
        echo '      <dt>This page url</dt>';
        echo '      <dd>' . $page->url(false) . '</dd>';
        echo '  </dl>';
        echo '<ul class="pager">';
        if ( $prevPage ) {
            echo '  <li>';
            echo '      <a href="' . $prevPage->id() . '">&larr;' . $prevPage->title() . '</a>';
            echo '  </li>';
        }
        if ( $nextPage ) {
            echo '  <li>';
            echo '      <a href="' . $nextPage->id() . '">&rarr;' . $nextPage->title() . '</a>';
            echo '  </li>';
        }
        echo '</ul>';
        echo '</div>';

    }


    /*
     * Callback for
     * Observer::observe('view_page_after_edit_tabs');
     */

    public static function callback_view_page_after_edit_tabs($page) {
        echo '<div class="well">';

        echo 'Skeleton-made using: <code>Observer::observe(\'view_page_after_edit_tabs\')</code>';

        echo '</div>';

    }


    /*
     * Callback for
     * Observer::observe('view_page_edit_plugins');
     */

    public static function callback_view_page_edit_plugins($page) {
        echo '<label class="control-label">';
        echo 'Skeleton select';
        echo '</label>';
        echo '<select class="form-control">';
        echo '<option>Skeleton option 1</option>';
        echo '<option>Skeleton option 2</option>';
        echo '</select>';

    }


    /*
     * Callback for
     * Observer::observe('user_edit_view_after_details');
     */

    public static function callback_user_edit_view_after_details($user) {
        echo '<div class="well">';
        echo '<h3>Skeleton-made user permissions list</h3>';
        $roles = Role::findByUserId($user->id);

        // Read all permissions from user's roles
        foreach ( $roles as $role ) {
            $role->permissions();
            echo '<h4><b>' . ucfirst($role->name) . '</b>\'s permissions</h4>';
            if ( !empty($role->permissions) ) {
                echo '<div>';
                foreach ( $role->permissions as $permission ) {
                    echo '<span class="label label-default">' . $permission->name . '</span> ';
                }
                echo '</div>';
            } else {
                echo 'Role <b>' . $role->name . '</b> has <b>no permisssions</b> assigned.';
            }
        }
        echo '</div> <!-- well -->';

    }


}

