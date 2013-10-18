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
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Philippe Archambault, 2008
 * @copyright Martijn van der Kleijn, 2009-2010
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<h1><?php echo __(ucfirst($action) . ' snippet'); ?></h1>

<form action="<?php echo $action == 'edit' ? get_url('snippet/edit/' . $snippet->id) : get_url('snippet/add'); ?>" method="post">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <div class="settings-pane">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label setting-2col-label" for="snippet_name">
                    <?php echo __('Name'); ?>
                </label>
                <div class="setting-2col-value-narrow">
                    <input class="form-control" id="snippet_name" maxlength="100" name="snippet[name]" type="text" value="<?php echo $snippet->name; ?>" />
                </div>
            </div>                
        </div>
    </div>
    <h4><?php echo __('Body'); ?></h4>
    <div class="settings-pane">
        <div class="form-horizontal filter-toolbar">
            <div class="form-group">
                <label class="control-label filter-label" for="snippet_filter_id">
                    <?php echo __('Filter'); ?>
                </label>
                <div class="filter-select">
                    <select class="form-control filter-selector" id="snippet_filter_id" name="snippet[filter_id]">
                        <option value=""<?php if ( $snippet->filter_id == '' ) echo ' selected="selected"'; ?>>&#8212; <?php echo __('none'); ?> &#8212;</option>
                        <?php foreach ( $filters as $filter ): ?>
                            <option value="<?php echo $filter; ?>"<?php if ( $snippet->filter_id == $filter ) echo ' selected="selected"'; ?>><?php echo Inflector::humanize($filter); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-more form-inline">

                </div>
            </div>
        </div>
        <div class="form-group">
            <textarea class="form-control markitup" id="snippet_content" name="snippet[content]" rows="20"><?php echo htmlentities($snippet->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
        </div>
    </div>
    <?php if ( isset($snippet->updated_on) ): ?>
        <div class="form-group">
            <p class="last-modified-info">
                <?php echo __('Last updated by'); ?> <?php echo $snippet->updated_by_name; ?> <?php echo __('on'); ?> <?php echo date('D, j M Y', strtotime($snippet->updated_on)); ?>
            </p>
        </div>
    <?php endif; ?>
    <div class="form-group form-inline">
        <?php if ( ($action == 'edit' && AuthUser::hasPermission('snippet_edit')) || ($action == 'add' && AuthUser::hasPermission('snippet_add')) ): ?>
            <button class="btn btn-primary" name="commit" type="submit" accesskey="s"><?php echo __('Save'); ?></button>
            <button class="btn btn-primary" name="continue" type="submit" accesskey="e"><?php echo __('Save and Continue Editing'); ?></button>
            <?php echo __('or'); ?> 
        <?php else: ?>
            <?php echo ($action == 'add') ? __('You do not have permission to add snippets!') : __('You do not have permission to edit snippets!'); ?> 
        <?php endif; ?>
        <a href="<?php echo get_url('snippet'); ?>"><?php echo __('Cancel'); ?></a>
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
    document.getElementById('snippet_name').focus();
// ]]>
</script>