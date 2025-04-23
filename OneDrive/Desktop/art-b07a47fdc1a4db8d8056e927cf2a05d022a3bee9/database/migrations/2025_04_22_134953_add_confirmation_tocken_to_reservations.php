<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ajouter le champ confirmation_token à la table des réservations
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('confirmation_token', 40)->nullable()->after('status');
        });

        // Ajouter le champ confirmation_token à la table des commandes personnalisées
        Schema::table('custom_orders', function (Blueprint $table) {
            $table->string('confirmation_token', 40)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('confirmation_token');
        });

        Schema::table('custom_orders', function (Blueprint $table) {
            $table->dropColumn('confirmation_token');
        });
    }
};