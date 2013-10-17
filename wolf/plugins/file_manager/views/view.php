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
$paths        = explode('/', $filename);
$nb_path      = count($paths); // -1 to didn't display current dir as a link
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
<?php if ( preg_match('/\.(jpg|jpeg|pjpeg|png|gif|ico)$/i', $filename) ): ?>
    <img src="<?php echo BASE_FILES_DIR . '/' . $filename; ?>" />
<?php else: ?>
    <form method="post" action="<?php echo get_url('plugin/file_manager/save'); ?>">
        <input type="hidden" name="file[name]" value="<?php echo $filename; ?>" />
        <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
        <div class="form-group">
            <textarea class="form-control" id="file_content" name="file[content]"><?php echo htmlentities($content, ENT_COMPAT, 'UTF-8'); ?></textarea>
        </div>
        <div class="form-group form-inline">
            <button class="btn btn-primary" name="commit" type="submit" accesskey="s"><?php echo __('Save'); ?></button>
            <button class="btn btn-primary" name="continue" type="submit" accesskey="e"><?php echo __('Save and Continue Editing'); ?></button>
            <?php echo __('or'); ?> <a href="<?php echo get_url('plugin/file_manager/browse/' . $progres_path); ?>"><?php echo __('Cancel'); ?></a>
        </div>
    </form>
<?php endif; ?>
