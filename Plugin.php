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
                        $pageId = str_replace(".htm", "", $model->fileName);
                        $group = Group::where('page', $pageId)->first();

			            return $this->customfields = isset($group->properties) ? $group->properties : [];
			        }
			    });


                $model->addDynamicMethod('getCustomfield', function($name) use ($model) {
			        return $this->customfields;
			    });

                $model->addDynamicMethod('setCustomfield', function($name, $value) use ($model) {
                    $pageId = str_replace(".htm", "", $model->fileName);
                    $group = Group::where('page', $pageId)->first();

                    if (!$group) {
                        return;
                    }

                    return Property::where('group_id', $group->id)->where('name', $name)->update([
                        'value' => $value
                    ]);
                });


                $model->bindEvent('model.beforeSave', function() use ($model) {
                    $customfields = $model->customfields;

                    foreach (post('customfields') as $key => $value) {
                        $model->setCustomfield($key, $value);                        
                    }
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
    	 	
            $customfields = $widget->model->getCustomfieldsAttribute();
            if (empty($customfields)) {
                return;
            }

            $fields = [];

            foreach ($customfields as $key => $value) {
                $fields["customfields[{$value->name}]"] = [
                    'label'   => $value->label,
                    'type'    => $value->type,
                    'comment'     => $value->comment,
                    'default'     => $value->default,
                    'value'     => $value->value,
                ];
            }

            $widget->addFields($fields, 'primary');
        });

    	

    }
    
}
