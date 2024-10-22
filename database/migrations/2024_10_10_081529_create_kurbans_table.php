<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurbansTable extends Migration
{
    public function up()
    {
        Schema::create('kurbans', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name'); // Bağışçı Adı
            $table->string('animal_type'); // Kurban Türü (örneğin, koyun, inek)
            $table->date('sacrifice_date'); // Kurban Kesim Tarihi
            $table->decimal('amount', 8, 2)->default(50); // Bağış Miktarı (varsayılan 50)
            $table->string('status')->default('Ödenmedi'); // Durum (Ödendi, Ödenmedi)
            $table->string('Notes')->nullable(); // Notlar (isteğe bağlı)
            $table->string('payment_type')->nullable(); // Ödeme Türü (isteğe bağlı)
            $table->string('association')->nullable(); // Kurban Derneği (isteğe bağlı)
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('kurbans');
    }
}
