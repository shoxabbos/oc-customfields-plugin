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
                return Group::where('page', $pageId)->get();
            });

            $model->bindEvent('model.afterFetch', function() use ($model) {
                $translatable = $model->translatable;

                foreach ($model->customfields as $value) {
                    if ($value->is_repeater) {
                        $translatable[] = $value->code;
                        continue;
                    }

                    foreach ($value->properties as $property) {
                        $translatable[] = $value->code."_".$property->name;
                    }
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

            if ($widget->isNested) {
                return;
            }

            $customfields = $widget->model->customfields;
    	 	
            if (empty($customfields)) {
                return;
            }

            foreach ($customfields as $value) {
                if ($value->is_repeater) {
                    $repeater = [
                        'label'     => $value->name,
                        'type'      => 'repeater',
                        'comment'   => "{{ this.page.{$value->code} }}",
                        'tab'       => $value->name,
                        'form'      => ['fields' => []]
                    ];

                    foreach ($value->properties as $property) {
                        $repeater['form']['fields'][$property->name] = [
                            'label'     => $property->label,
                            'type'      => $property->type,
                            'comment'   => $property->comment,
                            'default'   => $property->default,
                        ];
                    }

                    $widget->tabs['fields']["settings[{$value->code}]"] = $repeater;
                    continue;
                }

                foreach ($value->properties as $property) {
                    $widget->tabs['fields']["settings[{$value->code}_{$property->name}]"] = [
                        'label'     => $property->label,
                        'type'      => $property->type,
                        'comment'   => $property->comment." - {{ this.page.{$value->code}_{$property->name} }}",
                        'default'   => $property->default,
                        'tab'       => $value->name
                    ];
                }
            }
        });

    }


    
}
