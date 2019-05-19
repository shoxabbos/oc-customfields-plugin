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
    	 
    	// Double event hook that affects user #2 only
        Page::extend(function($model) {


            $model->bindEvent('model.afterFetch', function() use ($model) {
            	$model->addDynamicProperty('customfields', null);

                $model->addDynamicMethod('getCustomfieldsAttribute', function() use ($model) {
			        if (isset($this->customfields) && $this->customfields) {
			            return $this->customfields;
			        } else {
			            return $this->customfields = time().rand();
			        }
			    });

                $model->addDynamicMethod('setCustomfieldsAttribute', function() use ($model) {
                    if (isset($this->customfields) && $this->customfields) {
                        return $this->customfields;
                    } else {
                        return $this->customfields = time().rand();
                    }
                });

                $model->addDynamicMethod('getCustomfield', function() use ($model) {
			        return $this->customfields;
			    });

            });
        });


    	\Event::listen('backend.form.extendFields', function ($widget) {
            if (!$widget->model instanceof \Cms\Classes\Page) {
                return;
            }

            if (!($theme = Theme::getEditTheme())) {
                throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
            }
    	 	
            $pageId = str_replace(".htm", "", $widget->model->fileName);
            $group = Group::where('page', $pageId)->first();

            $fields = [];

            foreach ($group->properties as $key => $value) {
                $fields["fields[{$value->name}]"] = [
                    'label'   => $value->label,
                    'type'    => $value->type,
                    'tab'     => $value->tab,
                ];
            }

            $widget->addFields($fields, 'primary');
        });

    	

    }
    
}
