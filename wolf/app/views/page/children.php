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
<ul<?php
if ( $level == 1 )
    echo ' id="site-map" class="sortable tree-root"';
else
    echo ' class="sortable child"';
?>>
        <?php
        foreach ( $childrens as $child ):
            $viewFrontendUrl = URL_PUBLIC . ((USE_MOD_REWRITE == false) ? '?' : '') . $child->path() . (($child->path() != '') ? URL_SUFFIX : '');
            ?> 
        <li id="page_<?php echo $child->id; ?>" class="node level-<?php
        echo $level;
        if ( !$child->has_children )
            echo ' no-children';
        else if ( $child->is_expanded )
            echo ' children-visible';
        else
            echo ' children-hidden';
        ?>">
            <div class="page-list-item">
                <div class="page page-list-name">
                    <div class="indent-wrap">
                        <?php if ( $child->has_children ): ?>
                            <img align="middle" alt="toggle children" class="expander<?php if ( $child->is_expanded ) echo ' expanded'; ?>" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/<?php echo $child->is_expanded ? 'collapse' : 'expand'; ?>.png" title="" />
                        <?php else: ?>
                            <img align="middle" alt="toggle children" class="expander-placeholder" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/clear.gif" width="17" height="17" title="" />
                        <?php endif; ?>
                        <?php if ( !AuthUser::hasPermission('page_edit') || (!AuthUser::hasPermission('admin_edit') && $child->is_protected) ): ?>
                            <img align="middle" class="icon" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/page.png" alt="page icon" />
                            <span class="title protected"><?php echo $child->title; ?></span>
                            <img class="reorder-handle" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/drag_to_sort.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" />
                        <?php else: ?>
                            <a class="edit-link" href="<?php echo get_url('page/edit/' . $child->id); ?>" title="<?php echo $child->id . ' | ' . $child->slug; ?>">
                                <img align="middle" class="icon" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/page.png" alt="page icon" /> 
                                <span class="title">
                                    <?php echo $child->title; ?>
                                </span>
                            </a> 
                            <img class="reorder-handle" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/drag_to_sort.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" /> 
                        <?php endif; ?>
                        <?php if ( !empty($child->behavior_id) ): ?> 
                            <span class="behavior-id">(<?php echo Inflector::humanize($child->behavior_id); ?>)</span>
                        <?php endif; ?> 
                        <img align="middle" alt="" class="busy" id="busy-<?php echo $child->id; ?>" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/spinner.gif" title="" />
                    </div>
                </div>
                <?php
                switch ( $child->status_id ) {
                    case Page::STATUS_DRAFT: echo '<div class="page-list-status page-status-draft">' . __('Draft') . '</div>';
                        break;
                    case Page::STATUS_PREVIEW: echo '<div class="page-list-status page-status-preview">' . __('Preview') . '</div>';
                        break;
                    case Page::STATUS_PUBLISHED: echo '<div class="page-list-status page-status-published">' . __('Published') . '</div>';
                        break;
                    case Page::STATUS_HIDDEN: echo '<div class="page-list-status page-status-hidden">' . __('Hidden') . '</div>';
                        break;
                    case Page::STATUS_ARCHIVED: echo '<div class="page-list-status page-status-archived">' . __('Archived') . '</div>';
                        break;
                }
                ?>
                <div class="page-list-modify">
                    <a class="add-child-link" href="<?php echo get_url('page/add', $child->id); ?>">
                        <img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/plus.png" align="middle" title="<?php echo __('Add child'); ?>" alt="<?php echo __('Add child'); ?>" />
                    </a>
                    <?php if ( $child->is_protected && (!AuthUser::hasPermission('admin_edit')) ): ?>
                        <a class="remove" href="<?php echo get_url('page/delete/' . $child->id . '?csrf_token=' . SecureToken::generateToken(BASE_URL . 'page/delete/' . $child->id)); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $child->title; ?> <?php echo __('and its underlying pages'); ?>?');">
                            <img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/icon-remove.gif" align="middle" alt="<?php echo __('Remove page'); ?>" title="<?php echo __('Remove page'); ?>" />
                        </a>
                        <a href="#" id="copy-<?php echo $child->id; ?>" class="copy-page">
                            <img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/copy.png" align="middle" title="<?php echo __('Copy Page'); ?>" alt="<?php echo __('Copy Page'); ?>" />
                        </a>
                    <?php else: ?>
                        <a class="remove" href="<?php echo get_url('page/delete/' . $child->id . '?csrf_token=' . SecureToken::generateToken(BASE_URL . 'page/delete/' . $child->id)); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $child->title; ?> <?php echo __('and its underlying pages'); ?>?');">
                            <img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/icon-remove.gif" align="middle" alt="<?php echo __('Remove page'); ?>" title="<?php echo __('Remove page'); ?>" />
                        </a>
                        <a href="#" id="copy-<?php echo $child->id; ?>" class="copy-page">
                            <img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/copy.png" align="middle" title="<?php echo __('Copy Page'); ?>" alt="<?php echo __('Copy Page'); ?>" />
                        </a>
                    <?php endif; ?>
                    
                    <a class="view-link" href="<?php echo $viewFrontendUrl; ?>" target="_blank">
                        <img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/magnify.png" align="middle" alt="<?php echo __('View Page'); ?>" title="<?php echo __('View Page'); ?>" />
                    </a>
                </div>
            </div>
            <?php if ( $child->is_expanded ) echo $child->children_rows; ?>
        </li>
    <?php endforeach; ?>
</ul>