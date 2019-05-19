<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsProperties3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->boolean('active');
            $table->string('slug');
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('type');
            $table->text('settings')->nullable();
            $table->integer('sort_order')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->dropColumn('active');
            $table->dropColumn('slug');
            $table->dropColumn('code');
            $table->dropColumn('description');
            $table->dropColumn('type');
            $table->dropColumn('settings');
            $table->dropColumn('sort_order');
        });
    }
}
