<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * The FileManager allows users to upload and manipulate files.
 *
 * @package Plugins
 * @subpackage file-manager
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Philippe Archambault & Martijn van der Kleijn, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
/* Security measure */
if ( !defined('IN_CMS') ) {
    exit();
}

$out          = '';
$progres_path = '';
$paths        = explode('/', $dir);
$nb_path      = count($paths) - 1; // -1 to didn't display current dir as a link
foreach ( $paths as $i => $path ) {
    if ( $i + 1 == $nb_path ) {
        $out .= '<li class="active">' . $path . '</li>' . PHP_EOL;
    } else if ( $path != '' ) {
        $progres_path .= $path . '/';
        $out .= '<li><a href="' . get_url('plugin/file_manager/browse/' . rtrim($progres_path, '/')) . '">' . $path . '</a></li>' . PHP_EOL;
    }
}
?>
<ol class="breadcrumb file-mgr-breadcrumb">
    <li><a href="<?php echo get_url('plugin/file_manager'); ?>">public</a></li>
        <?php echo $out; ?>
</ol>
<table id="file-mgr-list" class="table table-hover table-condensed table-striped table-responsive">
    <thead>
        <tr>
            <th class="file-mgr-list-name"><?php echo __('File'); ?></th>
            <th class="file-mgr-list-size"><?php echo __('Size'); ?></th>
            <th class="file-mgr-list-perms"><?php echo __('Permissions'); ?></th>
            <th class="file-mgr-list-mtime"><?php echo __('Modified'); ?></th>
            <th class="file-mgr-list-modify"><?php echo __('Modify'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $files as $file ): ?>
            <tr>
                <td class="file-mgr-list-name">
                    <?php if ( preg_match('/\.(jpg|jpeg|pjpeg|png|gif|ico)$/i', $file->name) ) : ?>
                        <img class="thumb" src="<?php echo PATH_PUBLIC; ?>public/<?php echo $dir . $file->name; ?>"/>
                    <?php else: ?>
                        <img src="<?php echo ICONS_PATH; ?>file-<?php echo $file->type ?>-16.png" align="top" />
                    <?php endif ?>
                    <?php echo $file->link; ?>
                </td>
                <td class="file-mgr-list-size">
                    <?php echo $file->size; ?>
                </td>
                <td class="file-mgr-list-perms">
                    <?php echo $file->perms; ?> (<a href="#" onclick="toggle_chmod_popup('<?php echo $dir . $file->name; ?>', '<?php echo $file->chmod; ?>');
                                return false;" title="<?php echo __('Change mode'); ?>"><?php echo $file->chmod; ?></a>)
                </td>
                <td class="file-mgr-list-mtime">
                    <?php echo $file->mtime; ?>
                </td>
                <td class="file-mgr-list-modify">
                    <a href="#" onclick="toggle_rename_popup('<?php echo $dir . $file->name; ?>', '<?php echo $file->name; ?>');
                            return false;" title="<?php echo __('Rename'); ?>">
                        <img src="<?php echo ICONS_PATH; ?>action-rename-16.png" alt="rename icon" />
                    </a>
                    <a href="<?php echo get_url('plugin/file_manager/delete/' . $dir . $file->name . '?csrf_token=' . SecureToken::generateToken(BASE_URL . 'plugin/file_manager/delete/' . $dir . $file->name)); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete?'); ?> <?php echo $file->name; ?>?');">
                        <img src="<?php echo ICONS_PATH; ?>action-delete-16.png" alt="<?php echo __('delete file icon'); ?>" title="<?php echo __('Delete file'); ?>" />
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div id="popups">

    <div class="modal fade static" id="chmod-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><?php echo __('Change mode'); ?>
                        <span id="busy" class="busy" style="display: none;">
                            <img alt="Spinner" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/spinner.gif" />
                        </span>
                    </h3>
                </div>
                <form action="<?php echo get_url('plugin/file_manager/chmod'); ?>" method="post"> 
                    <div class="modal-body">
                        <input id="csrf-token" name="csrf_token" type="hidden" value="<?php echo SecureToken::generateToken(BASE_URL . 'plugin/file_manager/chmod'); ?>" />
                        <input id="chmod-file-name" name="file[name]" type="hidden" value="" />
                        <input class="form-control" id="chmod-file-mode" maxlength="4" name="file[mode]" type="text" value="" />                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button type="submit" class="btn btn-primary" id="chmod-file-button" name="commit" ><?php echo __('Change mode'); ?></button>
                    </div>
                </form>            
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade static" id="rename-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><?php echo __('Rename'); ?>
                        <span id="busy" class="busy" style="display: none;">
                            <img alt="Spinner" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/spinner.gif" />
                        </span>
                    </h3>
                </div>
                <form action="<?php echo get_url('plugin/file_manager/rename'); ?>" method="post">
                    <div class="modal-body">
                        <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo SecureToken::generateToken(BASE_URL . 'plugin/file_manager/rename'); ?>" />
                        <input id="rename_file_current_name" name="file[current_name]" type="hidden" value="" />
                        <input class="form-control" id="rename_file_new_name" maxlength="50" name="file[new_name]" type="text" value="" /> 
                        <input id="rename_file_button" name="commit" type="submit" value="<?php echo __('Rename'); ?>" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button class="btn btn-primary" id="create_file_button" name="commit" type="submit"><?php echo __('Rename'); ?></button>
                    </div>
                </form>          
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->      
</div>

<div id="boxes">

    <div class="modal fade static" id="create-file-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><?php echo __('Create new file'); ?>
                        <span id="busy" class="busy" style="display: none;">
                            <img alt="Spinner" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/spinner.gif" />
                        </span>
                    </h3>
                </div>
                <form action="<?php echo get_url('plugin/file_manager/create_file'); ?>" method="post">
                    <div class="modal-body">
                        <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo SecureToken::generateToken(BASE_URL . 'plugin/file_manager/create_file'); ?>" />
                        <input id="create_file_path" name="file[path]" type="hidden" value="<?php echo ($dir == '') ? '/' : $dir; ?>" />
                        <input id="create_file_name" class="form-control" maxlength="255" name="file[name]" type="text" value="" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button class="btn btn-primary" id="create_file_button" name="commit" type="submit"><?php echo __('Create'); ?></button>
                    </div>
                </form>          
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->    

    <div class="modal fade static" id="create-directory-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><?php echo __('Create new directory'); ?>
                        <span id="busy" class="busy" style="display: none;">
                            <img alt="Spinner" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/spinner.gif" />
                        </span>
                    </h3>
                </div>
                <form action="<?php echo get_url('plugin/file_manager/create_directory'); ?>" method="post">
                    <div class="modal-body">
                        <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo SecureToken::generateToken(BASE_URL . 'plugin/file_manager/create_directory'); ?>" />
                        <input id="create_directory_path" name="directory[path]" type="hidden" value="<?php echo ($dir == '') ? '/' : $dir; ?>" />
                        <input id="create_directory_name" class="form-control" maxlength="255" name="directory[name]" type="text" value="" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button class="btn btn-primary" id="create_file_button" name="commit" type="submit"><?php echo __('Create'); ?></button>
                    </div>
                </form>          
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->    

    <div class="modal fade static" id="upload-file-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><?php echo __('Upload file'); ?>
                        <span id="busy" class="busy" style="display: none;">
                            <img alt="Spinner" src="<?php echo PATH_PUBLIC; ?>wolf/admin/images/spinner.gif" />
                        </span>
                    </h3>
                </div>
                <form action="<?php echo get_url('plugin/file_manager/upload'); ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo SecureToken::generateToken(BASE_URL . 'plugin/file_manager/upload'); ?>" />
                        <input id="upload_path" name="upload[path]" type="hidden" value="<?php echo ($dir == '') ? '/' : $dir; ?>" />
                        <div class="checkbox">
                            <label>
                                <input id="upload_overwrite" name="upload[overwrite]" type="checkbox" value="1" />
                                <?php echo __('overwrite it?'); ?>
                            </label>
                        </div>
                        <input id="upload_file" name="upload_file" type="file" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button class="btn btn-primary" id="upload_file_button" name="commit" type="submit"><?php echo __('Upload'); ?></button>
                    </div>
                </form>          
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->      

</div>
