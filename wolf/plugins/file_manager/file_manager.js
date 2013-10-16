/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

function toggle_chmod_popup(filename) {
    var popup = $('#chmod-popup');
    $('#chmod_file_name').val(filename);
    popup.modal('show');
    $("#chmod_file_mode").focus();
}

function toggle_rename_popup(file, filename) {
    var popup = $('#rename-popup');
    $('#rename_file_current_name').val(file);
    $('#rename_file_new_name').val(filename);
    popup.modal('show');
    $('#rename_file_new_name').focus();
}


$(document).ready(function() {
    // Make all modal dialogs draggable
    $("#boxes .window").draggable({
        addClasses: false,
        containment: 'window',
        scroll: false,
        handle: '.titlebar'
    });
});