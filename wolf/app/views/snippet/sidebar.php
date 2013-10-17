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
if ( Dispatcher::getAction() == 'index' ):
    ?>
    <div class="btn-group btn-group-vertical btn-block">
        <?php if ( AuthUser::hasPermission('snippet_add') ): ?>
            <a href="<?php echo get_url('snippet/add'); ?>" class="popupLink btn btn-default btn-block">
                <img src="<?php echo ICONS_PATH; ?>/snippet-32.png" alt="snippet icon" />
                <?php echo __('New Snippet'); ?>
            </a>
        <?php endif; ?>
    </div>
    <div class="well well-sm">
        <h2><?php echo __('What is a Snippet?'); ?></h2>
        <p><?php echo __('Snippets are generally small pieces of content which are included in other pages or layouts.'); ?></p>
    </div>
    <div class="well well-sm">
        <h2><?php echo __('Tag to use this snippet'); ?></h2>
        <p><?php echo __('Just replace <b>snippet</b> by the snippet name you want to include.'); ?></p>
        <code><pre>&lt;?php 
$this->includeSnippet('snippet'); 
?&gt;</pre>
</code>    </div>

<?php endif; ?>