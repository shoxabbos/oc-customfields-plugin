<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosCustomfieldsGroups extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_customfields_groups', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->string('page');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_customfields_groups');
    }
}
