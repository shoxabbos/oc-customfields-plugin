<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsProperties9 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->text('value');
            $table->string('label')->change();
            $table->string('comment')->change();
            $table->string('default')->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->dropColumn('value');
            $table->string('label', 191)->change();
            $table->string('comment', 191)->change();
            $table->string('default', 191)->change();
        });
    }
}
