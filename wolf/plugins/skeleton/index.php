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

Plugin::setInfos(array(
            'id'                   => 'skeleton',
            'title'                => __('Skeleton'),
            'description'          => __('Provides a basic plugin implementation. (try enabling it!)'),
            'version'              => '1.1.0',
            'license'              => 'GPL',
            'author'               => 'Martijn van der Kleijn',
            'website'              => 'http://www.wolfcms.org/',
            'update_url'           => 'http://www.wolfcms.org/plugin-versions.xml',
            'require_wolf_version' => '0.5.5'
));

Plugin::addController('skeleton', __('Skeleton'), 'admin_view', true);

Observer::observe('view_backend_list_plugin', 'skeleton_display_dropdown');

function skeleton_display_dropdown(&$plugin_name, &$plugin) {
    if ( $plugin_name == 'skeleton' ) {
        $plugin->label = '';
        $params = Dispatcher::getParams();
        $params = (!empty($params)) ? $params : array('');
        echo
        '
      <li class="dropdown' . (( Dispatcher::getController() == 'plugin' && Dispatcher::getAction() == 'skeleton' ) ? ' active' : '') . '">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Skeleton <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li class="dropdown-header">Menu header</li>
          <li' . (( Dispatcher::getController() == 'plugin' && Dispatcher::getAction() == 'skeleton' && $params[0]=='documentation') ? ' class="active"' : '') . '><a href="' . get_url('plugin', 'skeleton', 'documentation') . '"><span class="glyphicon glyphicon-question-sign"></span> Documentation</a></li>
          <li class="divider"></li>
          <li' . (( Dispatcher::getController() == 'plugin' && Dispatcher::getAction() == 'skeleton' && $params[0]=='test_page') ? ' class="active"' : '') . '><a href="' . get_url('plugin', 'skeleton', 'test_page') . '"><span class="glyphicon glyphicon-cutlery"></span> Test page</a></li>
          <li><a href="http://getbootstrap.com/components/#glyphicons"><span class="glyphicon glyphicon-list"></span> Glyphicons list</a></li>
        </ul>
      </li>
';
    }

}

