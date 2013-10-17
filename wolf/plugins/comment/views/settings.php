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
 * The Comment plugin provides an interface to enable adding and moderating page comments.
 *
 * @package Plugins
 * @subpackage comment
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Bebliuc George <bebliuc.george@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Philippe Archambault, Bebliuc George & Martijn van der Kleijn, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
/* Security measure */
if ( !defined('IN_CMS') ) {
    exit();
}
?>
<h1><?php echo __('Comments Plugin'); ?></h1>

<form action="<?php echo get_url('plugin/comment/save'); ?>" method="post" class="form-horizontal">
    <fieldset>
        <legend><?php echo __('Comments settings'); ?></legend>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="autoapprove">
                <?php echo __('Auto approve'); ?>
            </label>
            <div class="setting-3col-value">
                <select class="form-control" name="autoapprove">
                    <option value="1" <?php if ( $approve == "1" ) echo 'selected ="";' ?>><?php echo __('Yes'); ?></option>
                    <option value="0" <?php if ( $approve == "0" ) echo 'selected ="";' ?>><?php echo __('No'); ?></option>
                </select>	
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('Choose yes if you want your comments to be auto approved. Otherwise, they will be placed in the moderation queue.'); ?>
            </p>
        </div>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="captcha">
                <?php echo __('Use captcha'); ?>
            </label>
            <div class="setting-3col-value">
                <select class="form-control" name="captcha">
                    <option value="1" <?php if ( $captcha == "1" ) echo 'selected ="";' ?>><?php echo __('Yes'); ?></option>
                    <option value="2" <?php if ( $captcha == "2" ) echo 'selected ="";' ?>><?php echo __('No'); ?></option>
                </select>	
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('Choose yes if you want to use a captcha to protect yourself against spammers.'); ?>
            </p>
        </div>	
        <div class="form-group">
            <label class="control-label setting-3col-label" for="rowspage">
                <?php echo __('Comments per page'); ?>
            </label>
            <div class="setting-3col-value">
                <input class="form-control" type="number" min="1" step="1" value="<?php echo $rowspage; ?>" name="rowspage" />
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('Sets the number of comments to be displayed per page in the backend.'); ?>
            </p>
        </div>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="numlabel">
                <?php echo __('Enhance comments tab'); ?>
            </label>
            <div class="setting-3col-value">
                <select class="form-control" name="numlabel">
                    <option value="1" <?php if ( $numlabel == "1" ) echo 'selected ="";' ?>><?php echo __('Yes'); ?></option>
                    <option value="0" <?php if ( $numlabel == "0" ) echo 'selected ="";' ?>><?php echo __('No'); ?></option>
                </select>
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __("Choose yes if you want to display the number of to-be-moderated &amp; total number of comment in the tab of the Comment plugin."); ?>
            </p>
        </div>

    </fieldset>

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
