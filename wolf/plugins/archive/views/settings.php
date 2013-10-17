<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2011 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * The Archive plugin provides an Archive pagetype behaving similar to a blog or news archive.
 *
 * @package Plugins
 * @subpackage archive
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2011
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
/* Security measure */
if ( !defined('IN_CMS') ) {
    exit();
}
?>
<h1><?php echo __('Settings'); ?></h1>

<form action="<?php echo get_url('plugin/archive/save'); ?>" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="control-label setting-3col-label" for="setting_use_dates">
            <?php echo __('Generate dates'); ?>
        </label>            
        <div class="setting-3col-value">
            <select class="form-control" name="settings[use_dates]" id="setting_use_dates">
                <option value="1" <?php if ( $settings['use_dates'] == "1" ) echo 'selected ="";' ?>><?php echo __('Yes'); ?></option>
                <option value="0" <?php if ( $settings['use_dates'] == "0" ) echo 'selected ="";' ?>><?php echo __('No'); ?></option>
            </select>
        </div>
        <p class="form-control-static setting-3col-help">
            <?php echo __('Do you want to generate dates for the URLs?'); ?>
        </p>
    </div>

    <div class="form-group form-inline">
        <button class="btn btn-primary" name="commit" type="submit" accesskey="s"><?php echo __('Save'); ?></button>
    </div>

</form>

<script type="text/javascript">
// <![CDATA[
    $(document).ready(function() {
        // Prevent accidentally navigating away
        $(':input').bind('change', function() {
            setConfirmUnload(true);
        });
        $('form').submit(function() {
            setConfirmUnload(false);
            return true;
        });
    });
// ]]>
</script>