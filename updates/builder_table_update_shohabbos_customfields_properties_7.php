<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsProperties7 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('label')->change();
            $table->string('comment')->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->string('label', 191)->change();
            $table->string('comment', 191)->change();
        });
    }
}
