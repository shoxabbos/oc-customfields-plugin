<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsProperties extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('page')->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->string('page', 191)->change();
        });
    }
}
