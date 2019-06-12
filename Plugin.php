<?php namespace Shohabbos\Customfields;

use System\Classes\PluginBase;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Cms\Classes\Layout;
use Cms\Controllers\Index as IndexController;
use October\Rain\Parse\Syntax\Parser as SyntaxParser;

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
        IndexController::extend(function($controller) {
            $controller->addCss('/plugins/shohabbos/customfields/assets/css/main.css');
        });

        Page::extend(function($model) {
            // add method
            $model->addDynamicMethod('getCustomfieldsAttribute', function() use ($model) {
                $pageId = str_replace(".htm", "", $model->fileName);
                return Group::where('page', $pageId)->get();
            });

            // add method
            $model->addDynamicMethod('listLayoutSyntaxFields', function() use ($model) {
                $layout = $model->layout;

                if (!$layout) {
                    $layouts = $model->getLayoutOptions();
                    $layout = count($layouts) ? array_keys($layouts)[0] : null;
                }

                if (!$layout) {
                    return [];
                }

                $layout = Layout::load($model->theme, $layout);
                if (!$layout) {
                    return [];
                }

                $syntax = SyntaxParser::parse($layout->markup, ['tagPrefix' => 'page:']);
                $result = $syntax->toEditor();

                return $result;
            });

            // add translatable fields
            $model->bindEvent('model.afterFetch', function() use ($model) {
                $translatable = $model->translatable;

                foreach ($model->customfields as $value) {
                    if ($value->is_repeater) {
                        $translatable[] = $value->code;
                        continue;
                    }

                    foreach ($value->properties as $property) {
                        if ($property->is_translatable) {
                            $translatable[] = $value->code."_".$property->name;
                        }
                    }
                }

                foreach ($model->listLayoutSyntaxFields() as $fieldCode => $fieldConfig) {
                    $translatable[] = "layout_".$fieldCode;
                }

                $model->addDynamicProperty('translatable', $translatable);
            });

            $model->bindEvent('model.beforeSave', function () use ($model) {
                
                if ($model->markup != $model->original['markup']) {
                    $model->markup == $model->original['markup'];
                }

                if ($model->code != $model->original['code']) {
                    $model->code == $model->original['code'];
                }

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

            // add layout syntax fields
            $fields = $widget->model->listLayoutSyntaxFields();
            foreach ($fields as $fieldCode => $fieldConfig) {
                if ($fieldConfig['type'] == 'fileupload') continue;

                if ($fieldConfig['type'] == 'repeater') {
                    $fieldConfig['form']['fields'] = array_get($fieldConfig, 'fields', []);
                    unset($fieldConfig['fields']);
                }

                $fieldConfig['comment'] = isset($fieldConfig['comment']) 
                    ? $fieldConfig['comment']."{{ this.page.layout_{$fieldCode} }}" 
                    : "{{ this.page.layout_{$fieldCode} }}"; 

                $widget->tabs['fields']['settings[layout_' . $fieldCode . ']'] = $fieldConfig;
            }

            // add custom fields
            $customfields = $widget->model->customfields;
            if (empty($customfields)) {
                return;
            }

            foreach ($customfields as $value) {
                if ($value->is_repeater) {
                    $repeater = [
                        'label'     => $value->name,
                        'type'      => 'repeater',
                        'comment'   => "{{ viewBag.{$value->code} }}",
                        'tab'       => $value->name,
                        'form'      => ['fields' => []],
                        'cssClass'  => 'custom-field',
                    ];

                    foreach ($value->properties as $property) {
                        $repeater['form']['fields'][$property->name] = [
                            'label'     => $property->label,
                            'type'      => $property->type,
                            'comment'   => $property->comment,
                            'default'   => $property->default,
                        ];
                    }

                    if ($value->position == 'secondary') {
                        $widget->secondaryTabs['fields']["viewBag[{$value->code}]"] = $repeater;
                    } else {
                        $widget->tabs['fields']["viewBag[{$value->code}]"] = $repeater;
                    }
                    continue;
                }

                foreach ($value->properties as $property) {
                    $field = [
                        'label'     => $property->label,
                        'type'      => $property->type,
                        'comment'   => $property->comment." - {{ this.page.{$value->code}_{$property->name} }}",
                        'default'   => $property->default,
                        'tab'       => $value->name,
                        'cssClass'  => 'custom-field',
                    ];

                    if ($value->position == 'secondary') {
                        $widget->secondaryTabs['fields']["settings[{$value->code}_{$property->name}]"] = $field;
                    } else {
                        $widget->tabs['fields']["settings[{$value->code}_{$property->name}]"] = $field;
                    }
                }
            }

            // hide code content
            $user = \BackendAuth::getUser();
            if (!$user->hasAccess('manage_cms_code_content')) {
                $widget->secondaryTabs['cssClass'] = 'hidden';
            }

        });

    }


    
}
