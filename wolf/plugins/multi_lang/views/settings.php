<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * The multi lang plugin redirects users to a page with content in their language.
 *
 * The redirect only occurs when a user's indicated preferred language is
 * available. There are multiple methods to determine the desired language.
 * These are:
 *
 * - HTTP_ACCEPT_LANG header
 * - URI based language hint (for example: http://www.example.com/en/page.html
 * - Preferred language setting of logged in users
 *
 * @package Plugins
 * @subpackage multi-lang
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2010
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
/* Security measure */
if ( !defined('IN_CMS') ) {
    exit();
}
?>

<h1>
    <?php echo __('Multiple Language Settings'); ?>
</h1>
<form action="<?php echo get_url('plugin/multi_lang/save'); ?>" method="post">
    <fieldset class="form-horizontal">
        <legend>
            <?php echo __('General'); ?>
        </legend>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="settings[style]">
                <?php echo __('Style'); ?>
            </label>
            <div class="setting-3col-value">
                <select class="form-control" name="settings[style]">
                    <option value="tab" <?php if ( $settings['style'] == "tab" ) echo 'selected ="";' ?>>
                        <?php echo __('Translations as tab'); ?>
                    </option>
                    <option value="page" <?php if ( $settings['style'] == "page" ) echo 'selected ="";' ?>>
                        <?php echo __('Translations as page copy'); ?>
                    </option>
                </select>
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('Do you want to create a translated version of a page as a tab of the same page or as a copy of the page in a language specific subtree? (i.e. Home->nl->About as a Dutch translation of Home->About)'); ?>
            </p>
        </div>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="settings[langsource]">
                <?php echo __('Language source'); ?>
            </label>
            <div class="setting-3col-value">
                <select class="form-control" name="settings[langsource]">
                    <option value="header" <?php if ( $settings['langsource'] == "header" ) echo 'selected ="";' ?>>
                        <?php echo __('HTTP_ACCEPT_LANG header'); ?>
                    </option>
                    <option value="uri" <?php if ( $settings['langsource'] == "uri" ) echo 'selected ="";' ?>>
                        <?php echo __('URI'); ?>
                    </option>
                    <option value="preferences" <?php if ( $settings['langsource'] == "preferences" ) echo 'selected ="";' ?>>
                        <?php echo __('Wolf CMS user preferences'); ?>
                    </option>
                </select>
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('Get the language preference from the HTTP header (default), the uri (/nl/about.html for the Dutch version of about.html) or from the stored preference of a logged in user.'); ?>
            </p>
        </div>
    </fieldset>

    <div class="form-group form-inline">
        <button class="btn btn-primary" name="commit" type="submit" accesskey="s" /><?php echo __('Save'); ?></button>
    </div>
</form>

<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        // Prevent accidentally navigating away
        $(':input').on('change', function() {
            setConfirmUnload(true);
        });
        $('form').submit(function() {
            setConfirmUnload(false);
            return true;
        });
    });
    // ]]>
</script>