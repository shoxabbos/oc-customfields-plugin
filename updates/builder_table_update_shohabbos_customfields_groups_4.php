<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsGroups4 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->string('position', 20);
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_groups', function($table)
        {
            $table->dropColumn('position');
        });
    }
}
