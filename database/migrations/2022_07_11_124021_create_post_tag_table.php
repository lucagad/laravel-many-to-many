<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            
            // creo la colonna per la FK per i posts
            $table->unsignedBigInteger('post_id');
            
            // creo la FK per la colonna appena creata
            $table->foreign('post_id')
                    ->references ('id')
                    ->on('posts')
                    ->onDelete ('cascade' ); 

            //creo la colonna per la FK di tags
            $table->unsignedBigInteger('tag_id');

            // creo la FK per la colonna appena creata
            $table->foreign('tag_id')
            ->references ('id')
            ->on('tags')
            ->onDelete( 'cascade' );
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
