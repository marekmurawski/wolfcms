<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2012-2013 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * The Comment plugin provides an interface to enable adding and moderating page comments.
 *
 * @package Plugins
 * @subpackage archive
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2012-2013
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
/* Security measure */
if ( !defined('IN_CMS') ) {
    exit();
}
?>
<div class="btn-group btn-group-vertical btn-block">
    <a class="btn btn-default btn-block" href="<?php echo get_url('plugin/archive/settings'); ?>">
        <img src="<?php echo ICONS_PATH; ?>settings-32-ns.png" alt="page icon" /> <?php echo __('Settings'); ?>
    </a>
</div>