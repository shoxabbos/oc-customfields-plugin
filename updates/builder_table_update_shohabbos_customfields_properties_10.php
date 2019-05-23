<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsProperties10 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->dropColumn('value');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->text('value');
        });
    }
}
