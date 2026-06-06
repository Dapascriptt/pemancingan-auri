<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Participant;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pemancinganauri.com'],
            [
                'name' => 'Admin Pemancingan AURI',
                'password' => Hash::make('password'),
            ]
        );

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Pemancingan Galatama AURI',
                'meta_title' => 'Pemancingan Galatama AURI | Tempat Pemancingan Keluarga',
                'meta_description' => 'Pemancingan Galatama AURI menyediakan kolam terawat, fasilitas lengkap, dan area nyaman untuk keluarga maupun komunitas.',
                'meta_keywords' => 'Pemancingan Galatama Auri, Tempat Pemancingan, Pemancingan Keluarga, Wisata Pemancingan',
                'hero_eyebrow' => 'Pemancingan harian yang tertata rapi',
                'hero_title' => 'Tempat Mancing Nyaman dengan Fasilitas Lengkap',
                'hero_subtitle' => 'Kolam terawat, area saung, kantin, dan fasilitas pendukung agar aktivitas memancing terasa tenang dan aman untuk semua kalangan.',
                'hero_cta_text' => 'Lihat Paket',
                'hero_cta_link' => '#paket',
                'hero_secondary_text' => 'Lihat Lokasi',
                'hero_secondary_link' => '#kontak',
                'hero_image' => 'https://images.unsplash.com/photo-1742302678202-97e046bc5880?auto=format&fit=crop&w=1200&q=70',
                'about_title' => 'Pemenang Galatama Harian Pemancingan Galatama AURI',
                'about_description' => 'Update pemenang galatama harian Pemancingan Galatama AURI ditampilkan sebagai apresiasi untuk pemancing dengan hasil terbaik. Informasi ini dapat dikelola dari CMS agar pengumuman tetap rapi, cepat diperbarui, dan mudah dilihat pengunjung.',
                'about_image' => 'https://images.unsplash.com/photo-1641494348078-8ce940c15364?auto=format&fit=crop&w=900&q=70',
                'highlights' => [
                    ['label' => 'Jam operasional', 'value' => '19.00 - 00.00 WITA'],
                    ['label' => 'Jenis ikan', 'value' => 'Nila, Lele, Patin, Gurame'],
                    ['label' => 'Lokasi', 'value' => 'Balikpapan Selatan'],
                ],
            ]
        );

        Contact::query()->updateOrCreate(
            ['id' => 1],
            [
                'address' => 'Balikpapan Selatan, Kalimantan Timur',
                'whatsapp' => '6281234567890',
                'phone' => '+62 812-3456-7890',
                'email' => 'halo@pemancinganauri.com',
                'opening_hours' => '19.00 - 00.00 WITA',
                'maps_embed' => 'https://maps.google.com/maps?q=Balikpapan%20Selatan&t=&z=13&ie=UTF8&iwloc=&output=embed',
                'maps_url' => 'https://maps.google.com',
                'instagram' => 'https://instagram.com',
                'facebook' => 'https://facebook.com',
                'tiktok' => 'https://tiktok.com',
            ]
        );

        $facilities = [
            ['Kolam Bersih', 'Area memancing terjaga dengan kontrol kualitas air rutin.'],
            ['Saung & Gazebo', 'Spot teduh dengan meja dan kursi untuk kenyamanan.'],
            ['Kantin', 'Menu makan dan minuman hangat untuk menemani.'],
            ['Parkir Luas', 'Area parkir aman untuk mobil dan motor.'],
            ['Mushola', 'Tempat ibadah bersih dan mudah dijangkau.'],
        ];

        foreach ($facilities as $index => [$title, $description]) {
            Facility::query()->updateOrCreate(
                ['title' => $title],
                ['description' => $description, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $galleryImages = [
            ['Kolam pemancingan', 'https://images.unsplash.com/photo-1641494348078-8ce940c15364?auto=format&fit=crop&w=900&q=70'],
            ['Spot mancing', 'https://images.unsplash.com/photo-1742302678202-97e046bc5880?auto=format&fit=crop&w=900&q=70'],
            ['Area santai', 'https://images.unsplash.com/photo-1642888374445-7029efbf85ec?auto=format&fit=crop&w=900&q=70'],
        ];

        foreach ($galleryImages as $index => [$caption, $image]) {
            Gallery::query()->updateOrCreate(
                ['caption' => $caption],
                ['image' => $image, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }

        Package::query()->delete();
        Package::query()->create([
            'name' => 'Galatama Harian',
            'price' => 'Rp50.000',
            'description' => 'Harga tiket galatama harian yang dapat diperbarui sesuai jadwal dan ketentuan kolam.',
            'features' => ['Update harga harian', 'Sesi malam', 'Pendaftaran via admin'],
            'sort_order' => 1,
            'is_featured' => true,
            'is_active' => true,
        ]);

        $participants = [
            ['Andi Saputra', 'Meja 01'],
            ['Budi Santoso', 'Meja 02'],
            ['Rizky Maulana', 'Meja 03'],
            ['Dedi Kurniawan', 'Meja 04'],
            ['Arman Hidayat', 'Meja 05'],
            ['Fajar Nugroho', 'Meja 06'],
            ['Yoga Pratama', 'Meja 07'],
            ['Agus Salim', 'Meja 08'],
            ['Hendra Wijaya', 'Meja 09'],
        ];

        foreach ($participants as $index => [$name, $note]) {
            Participant::query()->updateOrCreate(
                ['name' => $name],
                ['note' => $note, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }
    }
}
