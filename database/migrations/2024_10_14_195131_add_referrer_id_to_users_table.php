<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Проверка, какая база данных используется
        if (DB::connection()->getDriverName() === 'sqlite') {
            // Для SQLite
            Schema::table('users', function (Blueprint $table) {
                // Проверяем, существует ли колонка
                if (!Schema::hasColumn('users', 'referrer_id')) {
                    $table->unsignedBigInteger('referrer_id')->nullable()->after('id');
                }
            });
        } else {
            // Для MySQL и PostgreSQL
            Schema::table('users', function (Blueprint $table) {
                // Добавляем колонку и внешний ключ
                $table->unsignedBigInteger('referrer_id')->nullable()->after('id');
                $table->foreign('referrer_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        // Проверка, какая база данных используется
        if (DB::connection()->getDriverName() === 'sqlite') {
            // Для SQLite
            Schema::table('users', function (Blueprint $table) {
                // Удаляем колонку без внешнего ключа
                if (Schema::hasColumn('users', 'referrer_id')) {
                    $table->dropColumn('referrer_id');
                }
            });
        } else {
            // Для MySQL и PostgreSQL
            Schema::table('users', function (Blueprint $table) {
                // Удаляем внешний ключ
                if (Schema::hasColumn('users', 'referrer_id')) {
                    $table->dropForeign(['referrer_id']);
                    $table->dropColumn('referrer_id');
                }
            });
        }
    }
};
