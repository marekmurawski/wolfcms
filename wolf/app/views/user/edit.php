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
$user_roles = ($user instanceof User) ? $user->roles() : array();
?>
<h1><?php echo __(ucfirst($action) . ' user'); ?></h1>

<form action="<?php
echo $action == 'edit' ? get_url('user/edit/' . $user->id) : get_url('user/add');
?>" method="post">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <div class="form-horizontal">
        <div class="form-group">
            <label class="control-label setting-3col-label" for="user_name">
                <?php echo __('Name'); ?>
            </label>
            <div class="setting-3col-value">
                <input class="form-control" id="user_name" maxlength="100" name="user[name]" type="text" value="<?php echo $user->name; ?>" />
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('Required.'); ?>
            </p>
        </div>
        <div class="form-group">
            <label class="control-label setting-3col-label optional" for="user_email">
                <?php echo __('E-mail'); ?>
            </label>
            <div class="setting-3col-value">
                <input class="form-control" id="user_email" maxlength="255" name="user[email]" type="text" value="<?php echo $user->email; ?>" />
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('Optional. Please use a valid e-mail address.'); ?>
            </p>
        </div>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="user_username">
                <?php echo __('Username'); ?>
            </label>
            <div class="setting-3col-value">
                <input class="form-control" id="user_username" maxlength="40" name="user[username]" type="text" value="<?php echo $user->username; ?>" <?php echo $action == 'edit' ? 'disabled="disabled" ' : ''; ?>/>
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('At least 3 characters. Must be unique.'); ?>
            </p>
        </div>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="user_password">
                <?php echo __('Password'); ?>
            </label>
            <div class="setting-3col-value">
                <input class="form-control" id="user_password" maxlength="40" name="user[password]" type="password" value="" />
            </div>
            <p class="form-control-static setting-3col-help">
                <?php echo __('At least 5 characters.'); ?> 
                <?php echo ( $action == 'edit' ) ? __('Leave password blank for it to remain unchanged.') : ''; ?>
            </p>
        </div>
        <div class="form-group">
            <label class="control-label setting-3col-label" for="user_confirm">
                <?php echo __('Confirm Password'); ?>
            </label>
            <div class="setting-3col-value">            
                <input class="form-control" id="user_confirm" maxlength="40" name="user[confirm]" type="password" value="" />
            </div>
        </div>
        <?php if ( AuthUser::hasPermission('user_edit') ): ?>
            <div class="form-group">
                <label class="control-label setting-3col-label">
                    <?php echo __('Roles'); ?>
                </label>
                <div class="setting-3col-value">            
                    <?php foreach ( $roles as $role ): ?>
                        <span class="checkbox">
                            <input<?php if ( in_array($role->name, $user_roles) ) echo ' checked="checked"'; ?>  id="user_role-<?php echo $role->name; ?>" name="user_role[<?php echo $role->name; ?>]" type="checkbox" value="<?php echo $role->id; ?>" />
                            <?php
                            $roleLabel = __(ucwords($role->name));
                            if ( $roleLabel == 'MISSING_DEFAULT_STRING' ) {
                                $roleLabel = ucwords($role->name);
                            }
                            ?>
                            <label for="user_role-<?php echo $role->name; ?>"><?php echo $roleLabel ?></label>
                        </span>
                    <?php endforeach; ?>
                </div>
                <p class="form-control-static setting-3col-help">  
                    <?php echo __('Roles restrict user privileges and turn parts of the administrative interface on or off.'); ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label class="control-label setting-3col-label" for="user_language">
                <?php echo __('Language'); ?>
            </label>
            <div class="setting-3col-value">  
                <select class="form-control" id="user_language" name="user[language]">
                    <?php foreach ( Setting::getLanguages() as $code => $label ): ?>
                        <option value="<?php echo $code; ?>"<?php if ( $code == $user->language ) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <p class="form-control-static setting-3col-help">  
                <?php echo __('This will set your preferred language for the backend.'); ?>
            </p>
        </div>

    </div>

    <?php Observer::notify('user_edit_view_after_details', $user); ?>

    <fieldset class="buttons form-inline">
        <button class="btn btn-primary" name="commit" type="submit" accesskey="s">
            <?php echo __('Save'); ?>
        </button>
        <a class="btn btn-default edit-cancel" href="<?php echo (AuthUser::hasPermission('user_view')) ? get_url('user') : get_url(); ?>"><?php echo __('Cancel'); ?></a>
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
// ]]>
</script>
