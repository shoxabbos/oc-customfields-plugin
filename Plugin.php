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
        Page::extend(function($model) {
            $model->addDynamicMethod('getCustomfieldsAttribute', function() use ($model) {
                $pageId = str_replace(".htm", "", $model->fileName);
                $group = Group::where('page', $pageId)->first();
                $customfields = isset($group->properties) ? $group->properties : [];
                return $customfields;
            });


            $model->bindEvent('model.afterFetch', function() use ($model) {
                $translatable = $model->translatable;

                foreach ($model->customfields as $key => $value) {
                    $translatable[] = "custom_".$value->name;
                }

                $model->addDynamicProperty('translatable', $translatable);
            });
        });

    	\Event::listen('backend.form.extendFieldsBefore', function ($widget) {
            if (!$widget->model instanceof \Cms\Classes\Page) {
                return;
            }

            if (!($theme = Theme::getEditTheme())) {
                throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
            }

            $customfields = $widget->model->customfields;
    	 	
            if (empty($customfields)) {
                return;
            }

            $fields = [];

            foreach ($customfields as $key => $value) {
                $widget->tabs['fields']["settings[custom_{$value->name}]"] = [
                    'label'     => $value->label,
                    'type'      => $value->type,
                    'comment'   => $value->comment,
                    'default'   => $value->default,
                ];
            }
        });

    }


    
}
