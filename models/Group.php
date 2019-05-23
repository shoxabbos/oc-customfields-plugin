<?php namespace Shohabbos\Customfields\Models;

use Model;
use Cms\Classes\Page;

/**
 * Model
 */
class Group extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['code' => 'name'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_customfields_groups';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    public $hasMany = [
        'properties' => Property::class
    ];

}