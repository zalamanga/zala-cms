<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('eyebrow')->nullable()->after('slug');
            $table->string('hero_title')->nullable()->after('eyebrow');
            $table->text('hero_subtitle')->nullable()->after('hero_title');
            $table->text('excerpt')->nullable()->after('hero_subtitle');
            $table->string('template')->default('default')->after('excerpt');
            $table->string('featured_image')->nullable()->after('template');
            $table->string('cta_label')->nullable()->after('featured_image');
            $table->string('cta_url')->nullable()->after('cta_label');
            $table->boolean('show_in_nav')->default(true)->after('cta_url');
            $table->unsignedInteger('sort_order')->default(0)->after('show_in_nav');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'eyebrow',
                'hero_title',
                'hero_subtitle',
                'excerpt',
                'template',
                'featured_image',
                'cta_label',
                'cta_url',
                'show_in_nav',
                'sort_order',
            ]);
        });
    }
};
