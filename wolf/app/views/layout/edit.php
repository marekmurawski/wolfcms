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
<h1><?php echo __(ucfirst($action) . ' layout'); ?></h1>

<form action="<?php echo $action == 'edit' ? get_url('layout/edit/' . $layout->id) : get_url('layout/add'); ?>" method="post">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <div class="settings-pane"> 
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label setting-2col-label" for="layout_name">
                    <?php echo __('Name'); ?>
                </label>
                <div class="setting-2col-value-narrow">
                    <input class="form-control" id="layout_name" maxlength="100" name="layout[name]" type="text" value="<?php echo $layout->name; ?>" />
                </div>
            </div>        
            <div class="form-group">
                <label class="control-label setting-2col-label" for="layout_content_type">
                    <label for="layout_content_type"><?php echo __('Content-Type'); ?></label>
                </label>
                <div class="setting-2col-value-narrow">
                    <input class="form-control" id="layout_content_type" maxlength="40" name="layout[content_type]" type="text" value="<?php echo $layout->content_type; ?>" />
                </div>
            </div>        
        </div>
    </div>
    <div class="settings-pane">
        <div class="form-group">
            <label for="layout_content">
                <?php echo __('Body'); ?>
            </label>
        </div>
        <div class="form-group">
            <textarea class="form-control" id="layout_content" name="layout[content]" rows="20"><?php echo htmlentities($layout->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
        </div>

    </div>

    <div class="form-group form-inline">
        <?php if ( isset($layout->updated_on) ): ?>
            <p class="last-modified-info">
                <?php echo __('Last updated by'); ?> <?php echo $layout->updated_by_name; ?> <?php echo __('on'); ?> <?php echo date('D, j M Y', strtotime($layout->updated_on)); ?>
            </p>
        <?php endif; ?>
    </div>

    <fieldset class="buttons form-inline smart">
        <?php if ( ($action == 'edit' && AuthUser::hasPermission('layout_edit')) || ($action == 'add' && AuthUser::hasPermission('layout_add')) ): ?>
            <button class="btn btn-primary" name="commit" type="submit" accesskey="s"><?php echo __('Save'); ?></button>
            <button class="btn btn-primary" name="continue" type="submit" accesskey="e"><?php echo __('Save and Continue Editing'); ?></button>
        <?php else: ?>
            <span class="text-danger">
                <?php echo ($action == 'add') ? __('You do not have permission to add layouts!') : __('You do not have permission to edit layouts!'); ?> 
            </span>
        <?php endif; ?>        
        <a class="btn btn-default edit-cancel" href="<?php echo get_url('layout'); ?>"><span class="glyphicon glyphicon-remove"></span> <?php echo __('Cancel'); ?></a>
    </fieldset>
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
    document.getElementById('layout_name').focus();
    // ]]>
</script>