<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        \App\Models\User::create([
            'name'     => 'Admin Amikom',
            'email'    => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        \App\Models\User::create([
            'name'     => 'illham',
            'email'    => 'illham@gmail.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        \App\Models\User::create([
            'name'     => 'nur',
            'email'    => 'nur@gmail.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        \App\Models\User::create([
            'name'     => 'muhammad',
            'email'    => 'muhammad@gmail.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        // 2. Insert Kategori Event 
        $category1 = \App\Models\Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $category2 = \App\Models\Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        $category3 = \App\Models\Category::create([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        // 3. Insert 6 Events
        \App\Models\Event::create([
            'category_id' => $category1->id,
            'title'       => 'Festival Batik Nusantara',
            'description' => 'Pameran dan lomba batik dari seluruh penjuru nusantara yang mempertemukan pengrajin dan pecinta budaya.',
            'date'        => '2026-06-15 09:00:00',
            'location'    => 'Alun-Alun Yogyakarta',
            'price'       => 25000,
            'stock'       => 200,
            'poster_path' => 'posters/event-1.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title'       => 'Jazz Night 2026',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu bersama musisi ternama.',
            'date'        => '2026-05-20 19:00:00',
            'location'    => 'Amikom Kampus 2',
            'price'       => 50000,
            'stock'       => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category1->id,
            'title'       => 'Seminar Teknologi AI 2026',
            'description' => 'Seminar nasional membahas perkembangan kecerdasan buatan dan dampaknya bagi dunia industri.',
            'date'        => '2026-06-01 08:00:00',
            'location'    => 'Cinema',
            'price'       => 75000,
            'stock'       => 150,
            'poster_path' => 'posters/event-3.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title'       => 'E-Sport U-Champ 2026',
            'description' => 'Turnamen e-sport antar universitas se-DIY memperebutkan total hadiah jutaan rupiah.',
            'date'        => '2026-06-10 10:00:00',
            'location'    => 'Citra 2',
            'price'       => 0,
            'stock'       => 300,
            'poster_path' => 'posters/event-4.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title'       => 'UI/UX Masterclass',
            'description' => 'Workshop intensif desain UI/UX bersama praktisi industri, dari wireframe hingga prototype interaktif.',
            'date'        => '2026-06-20 08:00:00',
            'location'    => 'Lab Komputer G.2.4.1',
            'price'       => 35000,
            'stock'       => 60,
            'poster_path' => 'posters/event-5.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title'       => 'Workshop Digital Marketing',
            'description' => 'Belajar strategi pemasaran digital bersama praktisi berpengalaman untuk mengembangkan bisnis Anda.',
            'date'        => '2026-07-05 08:30:00',
            'location'    => 'Lab Komputer G.2.4.2',
            'price'       => 100000,
            'stock'       => 80,
            'poster_path' => 'posters/event-6.png',
        ]);
    }
}