<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('room_types')->truncate();

        $roomTypes = [
            [
                'id' => 1,
                'hall_id' => 1,
                'name' => 'Adibasi',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'hall_id' => 1,
                'name' => 'Political',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'hall_id' => 1,
                'name' => 'Press Room',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        RoomType::insert($roomTypes);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
