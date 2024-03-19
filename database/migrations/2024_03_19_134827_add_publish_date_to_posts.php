<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->date('publish_date')
                ->after('promo_image')
                ->default(now());
        });

        // since we previously used created_at for this, copy that data
        // TODO: this can be done in one SQL statement but since there is only one user of nimbus at this point (me) and
        //  the total data set is like 5 rows, not worth spending more time on this
        DB::table('posts')->select(['id', 'created_at'])->get()->each(function ($row) {
            DB::table('posts')->where('id', $row->id)->update(['publish_date' => $row->created_at]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('publish_date');
        });
    }
};
