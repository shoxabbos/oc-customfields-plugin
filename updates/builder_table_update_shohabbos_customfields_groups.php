<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsGroups extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->dropColumn('description');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->text('description')->nullable();
        });
    }
}
