<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakultasdatasTable extends Migration
{
    public function up()
    {
        Schema::create('fakultasdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('dekan')->nullable();
            $table->string('jumlahmahasiswa')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
