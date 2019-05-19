<?php namespace Shohabbos\Customfields\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Groups extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'manage_groups' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Shohabbos.Customfields', 'customfields', 'customfields-groups');
    }
}
