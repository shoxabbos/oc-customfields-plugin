<?php namespace Shohabbos\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosCustomfieldsProperties extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_customfields_properties', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('page');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_customfields_properties');
    }
}
