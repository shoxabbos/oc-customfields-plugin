<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosCustomfieldsProperties5 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->string('label');
            $table->string('comment');
            $table->integer('group_id')->unsigned()->change();
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('active');
            $table->dropColumn('slug');
            $table->dropColumn('code');
            $table->dropColumn('description');
            $table->dropColumn('settings');
            $table->dropColumn('sort_order');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_customfields_properties', function($table)
        {
            $table->dropColumn('label');
            $table->dropColumn('comment');
            $table->integer('group_id')->unsigned(false)->change();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->boolean('active');
            $table->string('slug', 191);
            $table->string('code', 191)->nullable();
            $table->string('description', 191)->nullable();
            $table->text('settings')->nullable();
            $table->integer('sort_order')->nullable();
        });
    }
}
