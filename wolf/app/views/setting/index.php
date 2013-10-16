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
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @copyright Martijn van der Kleijn, 2009-2010
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
$current_language = Setting::get('language');
?>

<h1><?php echo __('Administration'); ?></h1>

<div id="admin-area">

    <ul class="nav nav-tabs setting-tabs">
        <li class="active"><a href="#plugins" data-toggle="tab"><?php echo __('Plugins'); ?></a></li>
        <li><a href="#settings" data-toggle="tab"><?php echo __('Settings'); ?></a></li>
    </ul>            

    <div class="tab-content setting-contents">      
        <div class="tab-pane active settings-tab-pane" id="plugins">
            <div id="plugins" class="page">
                <table class="table table-hover table-striped table-responsive">
                    <thead>

                    <th class="plugin-list-name"><?php echo __('Plugin'); ?></th>
                    <th class="plugin-list-settings"><?php echo __('Settings'); ?></th>
                    <th class="plugin-list-website"><?php echo __('Website'); ?></th>
                    <th class="plugin-list-version"><?php echo __('Version'); ?></th>
                    <th class="plugin-list-latest"><?php echo __('Latest'); ?></th>
                    <th class="plugin-list-enabled"><?php echo __('Enabled'); ?></th>
                    <th class="plugin-list-uninst"><?php echo __('Uninstall'); ?></th>

                    </thead>
                    <tbody>
                        <?php
                        $loaded_plugins   = Plugin::$plugins;
                        $loaded_filters   = Filter::$filters;
                        foreach ( Plugin::findAll() as $plugin ):
                            $errors   = array();
                            $disabled = !Plugin::hasPrerequisites($plugin, $errors);
                            $rowClass = '';
                            if ( $disabled === true ) {
                                $rowClass = 'danger';
                            } elseif ( isset($loaded_plugins[$plugin->id]) ) {
                                $rowClass = 'success';
                            }
                            ?>
                            <tr<?php echo (!empty($rowClass)) ? ' class="' . $rowClass . '"' : ''; ?>>
                                <td class="plugin-list-name">
                                    <h4 class="plugin-list-title">
                                        <?php if ( isset($loaded_plugins[$plugin->id]) && Plugin::hasDocumentationPage($plugin->id) ): ?>
                                            <a href="<?php echo get_url('plugin/' . $plugin->id . '/documentation'); ?>"><?php echo $plugin->title; ?></a>
                                        <?php else: ?>
                                            <?php echo $plugin->title; ?>
                                        <?php endif; ?>
                                        <span class="plugin-list-author">
                                            <?php if ( isset($plugin->author) ) echo ' ' . __('by') . ' ' . $plugin->author; ?>
                                        </span>
                                    </h4>
                                    <p class="plugin-list-description">
                                        <?php echo $plugin->description; ?>
                                    </p>
                                    <div class="notes">
                                        <?php if ( $disabled === true ) echo '<span class="notes">' . __('This plugin CANNOT be enabled!<br/>') . implode('<br/>', $errors) . '</span>'; ?>
                                    </div>
                                </td>
                                <td class="plugin-list-settings">
                                    <?php if ( isset($loaded_plugins[$plugin->id]) && Plugin::hasSettingsPage($plugin->id) ): ?>
                                        <a href="<?php echo get_url('plugin/' . $plugin->id . '/settings'); ?>"><?php echo __('Settings'); ?></a>
                                    <?php else: ?>
                                        <?php echo __('n/a'); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="plugin-list-website">
                                    <a href="<?php echo $plugin->website; ?>" target="_blank"><?php echo __('Website') ?></a>
                                </td>
                                <td class="plugin-list-version">
                                    <?php echo $plugin->version; ?>
                                </td>
                                <td class="plugin-list-latest">
                                    <?php echo Plugin::checkLatest($plugin); ?>
                                </td>
                                <td class="plugin-list-enabled enabled">
                                    <input type="checkbox" name="enabled_<?php echo $plugin->id; ?>" value="<?php echo $plugin->id; ?>"<?php if ( isset($loaded_plugins[$plugin->id]) ) echo ' checked="checked"'; if ( $disabled ) echo ' disabled="disabled"'; ?> />
                                </td>
                                <td class="plugin-list-uninst">
                                    <a href="<?php echo get_url('setting'); ?>" name="uninstall_<?php echo $plugin->id; ?>"><?php echo __('Uninstall'); ?></a>
                                </td>

                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>    
        <div class="tab-pane settings-tab-pane" id="settings">
            <div id="settings">
                <form action="<?php echo get_url('setting'); ?>" method="post">
                    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="setting-3col-label">
                                <label class="control-label" for="setting_admin_title">
                                    <?php echo __('Admin Site title'); ?>
                                </label>
                            </div>
                            <div class="setting-3col-value">
                                <input class="form-control" id="setting_admin_title" maxlength="255" name="setting[admin_title]" type="text" value="<?php echo htmlentities(Setting::get('admin_title'), ENT_COMPAT, 'UTF-8'); ?>" />
                            </div>
                            <div class="setting-3col-help">
                                <p class="form-control-static">
                                    <?php echo __('By using <strong>&lt;img src="img_path" /&gt;</strong> you can set your company logo instead of a title.'); ?>        
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="setting-3col-label">
                                <label class="control-label" for="setting_admin_email">
                                    <?php echo __('Site email'); ?>
                                </label>
                            </div>
                            <div class="setting-3col-value">
                                <input class="form-control" id="setting_admin_email" maxlength="255" name="setting[admin_email]" type="text" value="<?php echo Setting::get('admin_email'); ?>" />
                            </div>
                            <div class="setting-3col-help">
                                <p class="form-control-static">
                                    <?php echo __('When emails are sent by Wolf CMS, this email address will be used as the sender. Default: do-not-reply@wolfcms.org'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="setting-3col-label">
                                <label class="control-label" for="setting_language">
                                    <?php echo __('Language'); ?>
                                </label>
                            </div>
                            <div class="setting-3col-value">
                                <select class="form-control" id="setting_language" name="setting[language]">
                                    <?php foreach ( Setting::getLanguages() as $code => $label ): ?>
                                        <option value="<?php echo $code; ?>"<?php if ( $code == $current_language ) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="setting-3col-help">
                                <p class="form-control-static">
                                    <?php echo __('This will set your language for the backend.'); ?><br /><?php echo __('Help us <a href=":url">translate Wolf</a>!', array( ':url' => 'http://www.wolfcms.org/wiki/translator_notes' )); ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="setting-3col-label">
                                <label class="control-label" for="setting_theme">
                                    <?php echo __('Administration Theme'); ?>
                                </label>
                            </div>
                            <div class="setting-3col-value">
                                <select class="form-control" id="setting_theme" name="setting[theme]">
                                    <?php
                                    $current_theme = Setting::get('theme');
                                    foreach ( Setting::getThemes() as $code => $label ):
                                        ?>
                                        <option value="<?php echo $code; ?>"<?php if ( $code == $current_theme ) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="setting-3col-help">
                                <p class="form-control-static">
                                    <?php echo __('This will change your Administration theme.'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="setting-3col-label">
                                <label class="control-label" for="setting_default_tab">
                                    <?php echo __('Default tab'); ?>
                                </label>
                            </div>
                            <div class="setting-3col-value">
                                <select class="form-control" id="setting_default_tab" name="setting[default_tab]">
                                    <?php $current_default_tab = Setting::get('default_tab'); ?>
                                    <option value="page"<?php if ( $current_default_tab == 'page' ) echo ' selected="selected"'; ?>><?php echo __('Pages'); ?></option>
                                    <option value="snippet"<?php if ( $current_default_tab == 'snippet' ) echo ' selected="selected"'; ?>><?php echo __('MSG_SNIPPETS'); ?></option>
                                    <option value="layout"<?php if ( $current_default_tab == 'layout' ) echo ' selected="selected"'; ?>><?php echo __('Layouts'); ?></option>
                                    <option value="user"<?php if ( $current_default_tab == 'user' ) echo ' selected="selected"'; ?>><?php echo __('Users'); ?></option>
                                    <option value="setting"<?php if ( $current_default_tab == 'setting' ) echo ' selected="selected"'; ?>><?php echo __('Administration'); ?></option>
                                    <?php
                                    foreach ( Plugin::$controllers as $key => $controller ):
                                        if ( Plugin::isEnabled($key) && $controller->show_tab === true ) {
                                            ?>
                                            <option value="plugin/<?php echo $key; ?>"<?php if ( 'plugin/' . $key == $current_default_tab ) echo ' selected="selected"'; ?>><?php echo $controller->label; ?></option>
                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="setting-3col-help">
                                <p class="form-control-static">
                                    <?php echo __('This allows you to specify which tab (controller) you will see by default after login.'); ?>
                                </p>
                            </div>
                        </div>
                        <h3><?php echo __('Page options'); ?></h3>
                        <div class="form-group">
                            <div class="setting-3col-label">
                            </div>
                            <div class="setting-3col-value">
                                <div class="checkbox">
                                    <input type="checkbox" id="setting_allow_html_title" name="setting[allow_html_title]" <?php if ( Setting::get('allow_html_title') == 'on' ) echo ' checked="checked"'; ?> />
                                    <?php echo __('Allow HTML in Title'); ?>
                                </div>
                            </div>
                            <div class="setting-3col-help">
                                <p class="form-control-static">
                                    <?php echo __('Determines whether or not HTML code is allowed in a page\'s title.'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="setting-3col-label">
                                <label class="control-label">
                                    <?php echo __('Default Status'); ?>
                                </label>
                            </div>
                            <div class="setting-3col-value">

                                <select class="form-control" id="setting_default_filter_id" name="setting[default_status_id]">
                                    <option value="<?php echo Page::STATUS_DRAFT; ?>"<?php if ( Setting::get('default_status_id') == Page::STATUS_DRAFT ) echo ' selected="selected"'; ?>>
                                        <?php echo __('Draft'); ?> 
                                    </option>
                                    <option value="<?php echo Page::STATUS_PUBLISHED; ?>"<?php if ( Setting::get('default_status_id') == Page::STATUS_PUBLISHED ) echo ' selected="selected"'; ?>>
                                        <?php echo __('Published'); ?>
                                    </option>
                                </select>

                            </div>
                            <div class="setting-3col-help">
                                &nbsp;
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="setting-3col-label">
                                <label class="control-label" for="setting_default_filter_id">
                                    <?php echo __('Default Filter'); ?>
                                </label>
                            </div>
                            <div class="setting-3col-value">
                                <select class="form-control" id="setting_default_filter_id" name="setting[default_filter_id]">
                                    <?php $current_default_filter_id = Setting::get('default_filter_id'); ?>
                                    <option value=""<?php if ( $current_default_filter_id == '' ) echo ' selected="selected"'; ?>>&#8212; <?php echo __('none'); ?> &#8212;</option>
                                    <?php
                                    foreach ( Filter::findAll() as $filter_id ):
                                        if ( isset($loaded_filters[$filter_id]) ):
                                            ?>
                                            <option value="<?php echo $filter_id; ?>"<?php if ( $filter_id == $current_default_filter_id ) echo ' selected="selected"'; ?>><?php echo Inflector::humanize($filter_id); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="setting-3col-help">
                                <p class="form-control-static">
                                    <?php echo __('Only for filter in pages, NOT in snippets'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-inline">
                        <button  class="btn btn-primary" name="commit" type="submit" accesskey="s"><?php echo __('Save'); ?></button>
                    </div>                    
                </form>
            </div>
        </div>    
    </div>    

</div>

<script type="text/javascript">
// <![CDATA[

    function toSentenceCase(s) {
        return s.toLowerCase().replace(/^(.)|\s(.)/g,
                function($1) {
                    return $1.toUpperCase();
                });
    }

    function toLabelCase(s) {
        return s.toLowerCase().replace(/^(.)|\s(.)|_(.)/g,
                function($1) {
                    return $1.toUpperCase();
                });
    }


    $(document).ready(function() {

        // Dynamically change look-and-feel
        $('#setting_theme').change(function() {
            var theme = '<?php echo PATH_PUBLIC; ?>/wolf/admin/themes/' + this.value + '/styles.css';
            alert(theme);
            $('#css_theme').attr({"href": theme});
        });

        // Dynamically change enabled state
        $('.plugin-list-enabled input').change(function() {
            $.get('<?php echo get_url('setting'); ?>' + (this.checked ? '/activate_plugin/' : '/deactivate_plugin/') + this.value, function() {
                location.reload(true);
            });
        });

        // Dynamically uninstall
        $('.plugin-list-uninst a').click(function(e) {
            if (confirm('<?php echo jsEscape(__('Are you sure you wish to uninstall this plugin?')); ?>')) {
                var pluginId = this.name.replace('uninstall_', '');
                $.get('<?php echo get_url('setting/uninstall_plugin/'); ?>' + pluginId, function() {
                    location.reload(true);
                });
            }
            e.preventDefault();
        });

    });

// ]]>
</script>
