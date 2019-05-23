<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsGroups3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->renameColumn('is_repeator', 'is_repeater');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->renameColumn('is_repeater', 'is_repeator');
        });
    }
}
