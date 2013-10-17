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
        <a href="<?php echo get_url('user/add'); ?>" class="popupLink btn btn-default btn-block">
            <img src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/user.png" alt="user icon" /> 
            <?php echo __('New User'); ?>
        </a>
    </div>
<?php elseif ( isset($user) ): 
        use_helper('Gravatar');
        echo Gravatar::img($user->email, array( 'align' => 'middle', 'alt' => 'user icon', 'class' => 'img-responsive user-gravatar' ), '256', URL_PUBLIC . 'wolf/admin/images/user.png', 'g', USE_HTTPS);
 endif; ?>
<div class="well well-sm">
    <h2><?php echo __('Where do the avatars come from?'); ?></h2>
    <p><?php echo __('The avatars are automatically linked for those with a <a href="http://www.gravatar.com/" target="_blank">Gravatar</a> (a free service) account.'); ?></p>
</div>