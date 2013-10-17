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
?>

<div class="btn-group btn-group-vertical btn-block">
    <a class="btn btn-primary btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <span class="glyphicon glyphicon-gift"></span>
        <?php echo __('Glyphicon Button'); ?> 1
    </a>
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <span class="glyphicon glyphicon-list-alt"></span>
        <?php echo __('Glyphicon Button'); ?> 2
    </a>
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <span class="glyphicon glyphicon-leaf"></span>
        <?php echo __('Glyphicon Button'); ?> 3
    </a>
</div>    
<div class="btn-group btn-group-vertical btn-block">
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <img src="<?php echo ICONS_PATH; ?>documentation-32.png" alt="documentation icon" />
        <?php echo __('Image Button'); ?> 1
    </a>
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <img src="<?php echo ICONS_PATH; ?>action-approve-32.png" alt="documentation icon" />
        <?php echo __('Image Button'); ?> 2
    </a>
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <img src="<?php echo ICONS_PATH; ?>action-deny-32.png" alt="documentation icon" />
        <?php echo __('Image Button'); ?> 3
    </a>
</div>
<div class="btn-group btn-group-vertical btn-block">
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <img src="<?php echo ICONS_PATH; ?>documentation-16.png" alt="documentation icon" />
        <?php echo __('Image Button'); ?> 1 - small
    </a>
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <img src="<?php echo ICONS_PATH; ?>action-approve-16.png" alt="documentation icon" />
        <?php echo __('Image Button'); ?> 2 - small
    </a>
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/skeleton'); ?>">
        <img src="<?php echo ICONS_PATH; ?>action-deny-16.png" alt="documentation icon" />
        <?php echo __('Image Button'); ?> 3 - small
    </a>
</div>

<div class="well well-sm">
    <h2><?php echo __('A sidebar'); ?></h2>
    <p>
        <?php echo __('Put something here, or leave out the sidebar entirely.') ?>
    </p>
</div>
