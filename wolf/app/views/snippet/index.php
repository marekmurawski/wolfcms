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
<h1><?php echo __('MSG_SNIPPETS'); ?></h1>


<!-- <ul id="snippets" class="index"> -->
<div id="snippets" class="panel panel-default">
    <div class="panel-heading">
        <div id="snippet_<?php echo $snippet->id; ?>" class="snippet-list-item">
            <div class="snippet-list-name">
                <?php echo __('Snippet'); ?> <span class="btn btn-default btn-xs" id="reorder-toggle"><?php echo __('reorder'); ?></span>
            </div>
            <div class="snippet-list-modify"><?php echo __('Modify'); ?></div>
        </div>
    </div>

    <div class="panel-body snippet-list">
        <?php foreach ( $snippets as $snippet ): ?>
            <div id="snippet_<?php echo $snippet->id; ?>" class="snippet-list-item">
                <div class="snippet-list-name">
                    <img alt="snippet-icon" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/snippet.png" />
                    <a href="<?php echo get_url('snippet/edit/' . $snippet->id); ?>"><?php echo $snippet->name; ?></a>
                    <img class="reorder-handle" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/drag.gif" alt="<?php echo __('Drag and Drop'); ?>"/>
                </div>
                <div class="snippet-list-modify">
                    <div class="remove">
                        <?php if ( AuthUser::hasPermission('snippet_delete') ): ?>        
                            <a class="remove" href="<?php echo get_url('snippet/delete/' . $snippet->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete?'); ?> <?php echo $snippet->name; ?>?');"><img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/icon-remove.gif" alt="<?php echo __('delete snippet icon'); ?>" title="<?php echo __('Delete snippet'); ?>" /></a>
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
            containment: '#snippets',
            placeholder: 'flat-list-placeholder',
            revert: true,
            handle: '.reorder-handle',
            cursor: 'move',
            distance: '5',
            stop: function(e, ui) {
                var order = $(ui.item.parent()).sortable('serialize', {key: 'snippets[]'});
                $.post('<?php echo get_url('snippet/reorder/'); ?>', {data: order});
            }
        }).disableSelection();
        return this;
    };

    $(document).ready(function() {
        $('div.snippet-list').sortableSetup();
        $('#reorder-toggle').click(function() {
            $(this).data('reorder', !$(this).data('reorder'));
            if ($(this).data('reorder')) {
                $('div.snippet-list').sortable('option', 'disabled', false);
                $('.reorder-handle').show();
                $('#reorder-toggle').text('<?php echo __('disable reorder'); ?>');
            } else {
                $('div.snippet-list').sortable('option', 'disabled', true);
                $('.reorder-handle').hide();
                $('#reorder-toggle').text('<?php echo __('reorder'); ?>');
            }
        });

    });

// ]]>
</script>
