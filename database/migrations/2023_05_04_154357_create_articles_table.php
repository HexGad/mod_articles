<?php

use HexGad\Permissions\Providers\PermissionsServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('content');


            if (app()->providerIsLoaded(\HexGad\Users\Providers\UsersServiceProvider::class))
                $table->foreignIdFor(\HexGad\Users\Models\User::class)
                    ->constrained()->restrictOnDelete();

            if (app()->providerIsLoaded(\HexGad\Categories\Providers\CategoriesServiceProvider::class))
                $table->foreignIdFor(\HexGad\Categories\Models\Category::class)
                    ->nullable()->default(null)->constrained()->nullOnDelete();

            if (app()->providerIsLoaded(\HexGad\Forms\Providers\FormsServiceProvider::class))
                $table->foreignIdFor(\HexGad\Forms\Models\Form::class)
                    ->nullable()->default(null)->constrained()->nullOnDelete();

            if (app()->providerIsLoaded(\HexGad\Pixels\Providers\PixelsServiceProvider::class))
                $table->foreignIdFor(\HexGad\Pixels\Models\Pixel::class)
                   ->nullable()->default(null)->constrained()->nullOnDelete();

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
        Schema::dropIfExists('articles');
    }
};
