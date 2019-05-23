<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsGroups2 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->boolean('is_repeator')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->dropColumn('is_repeator');
        });
    }
}
