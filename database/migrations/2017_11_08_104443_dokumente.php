<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dokumente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumente', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name');
            $table->string('pfad');
            $table->string('kategorie');
            $table->text('unterkategorie');
            $table->float('groesse', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
