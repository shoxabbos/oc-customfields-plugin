<?php namespace Shohabbos\Customfields;

use System\Classes\PluginBase;
use Cms\Classes\Page;
use Cms\Classes\Theme;

use Shohabbos\Customfields\Models\Group;
use Shohabbos\Customfields\Models\Property;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function register() {
    	\Event::listen('backend.form.extendFields', function ($widget) {
            if (!$widget->model instanceof \Cms\Classes\Page) {
                return;
            }

            if (!($theme = Theme::getEditTheme())) {
                throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
            }

            $pageId = str_replace(".htm", "", $widget->model->fileName);
            $group = Group::where('page', $pageId)->first();
            $customfields = isset($group->properties) ? $group->properties : [];
    	 	
            if (empty($customfields)) {
                return;
            }

            $fields = [];

            foreach ($customfields as $key => $value) {
                $fields["settings[custom_{$value->name}]"] = [
                    'label'     => $value->label,
                    'type'      => $value->type,
                    'comment'   => $value->comment,
                    'default'   => $value->default,
                ];
            }

            $widget->addFields($fields, 'primary');
        });


    }
    
}
