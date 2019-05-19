<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsProperties2 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->renameColumn('page', 'name');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->renameColumn('name', 'page');
        });
    }
}
