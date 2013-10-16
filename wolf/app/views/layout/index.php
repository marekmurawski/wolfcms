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
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<h1><?php echo __('Layouts'); ?></h1>

<div id="layouts" class="panel panel-default">
    <div class="panel-heading">
        <div class="layout-list-item">
            <div class="layout-list-name">
                <?php echo __('Layout'); ?> <span class="btn btn-default btn-xs" id="reorder-toggle"><?php echo __('reorder'); ?></span>
            </div>
            <div class="layout-list-modify"><?php echo __('Modify'); ?></div>
        </div>
    </div>

    <div class="panel-body layout-list">
        <?php foreach ( $layouts as $layout ): ?>
            <div id="layout_<?php echo $layout->id; ?>" class="layout-list-item">
                <div class="layout-list-name">
                    <img alt="layout-icon" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/layout.png" />
                    <a href="<?php echo get_url('layout/edit/' . $layout->id); ?>"><?php echo $layout->name; ?></a>
                    <img class="reorder-handle" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/drag.gif" alt="<?php echo __('Drag and Drop'); ?>"/>
                </div>
                <div class="layout-list-modify">
                    <div class="remove">
                        <?php if ( AuthUser::hasPermission('layout_delete') ): ?>        
                            <a class="remove" href="<?php echo get_url('layout/delete/' . $layout->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete?'); ?> <?php echo $layout->name; ?>?');"><img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/icon-remove.gif" alt="<?php echo __('delete layout icon'); ?>" title="<?php echo __('Delete layout'); ?>" /></a>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
// <![CDATA[
    jQuery.fn.sortableSetup = function sortableSetup() {
        this.sortable({
            disabled: true,
            tolerance: 'intersect',
            containment: '#layouts',
            placeholder: 'flat-list-placeholder',
            revert: true,
            handle: '.reorder-handle',
            cursor: 'move',
            distance: '5',
            stop: function(e, ui) {
                var order = $(ui.item.parent()).sortable('serialize', {key: 'layouts[]'});
                $.post('<?php echo get_url('layout/reorder/'); ?>', {data: order});
            }
        }).disableSelection();
        return this;
    };

    $(document).ready(function() {
        $('div.layout-list').sortableSetup();
        $('#reorder-toggle').click(function() {
            $(this).data('reorder', !$(this).data('reorder'));
            if ($(this).data('reorder')) {
                $('div.layout-list').sortable('option', 'disabled', false);
                $('.reorder-handle').show();
                $('#reorder-toggle').text('<?php echo __('disable reorder'); ?>');
            } else {
                $('div.layout-list').sortable('option', 'disabled', true);
                $('.reorder-handle').hide();
                $('#reorder-toggle').text('<?php echo __('reorder'); ?>');
            }
        });

    });

// ]]>
</script>
