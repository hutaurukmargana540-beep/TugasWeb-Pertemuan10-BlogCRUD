<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 15 post supaya pagination (6 per halaman) langsung terlihat.
        Post::factory(15)->create();
    }
}
