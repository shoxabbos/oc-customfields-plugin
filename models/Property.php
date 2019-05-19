<?php namespace Shohabbos\Customfields\Models;

use Model;
use Cms\Classes\Page;

/**
 * Model
 */
class Property extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_customfields_properties';


    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    public $belongsTo = [
        'group' => Group::class
    ];

}
