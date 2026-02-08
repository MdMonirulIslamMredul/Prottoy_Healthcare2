<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notice;
use Carbon\Carbon;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notices = [
            [
                'title' => 'New Healthcare Package Available',
                'content' => 'We are excited to announce the launch of our new comprehensive healthcare package covering all major medical services including consultation, diagnostics, and emergency care.',
                'type' => 'announcement',
                'is_active' => true,
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Emergency Hotline Number Update',
                'content' => 'Our 24/7 emergency hotline number has been updated. Please save the new number: 09612-345678 for any urgent medical assistance.',
                'type' => 'emergency',
                'is_active' => true,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Free Health Camp - March 2026',
                'content' => 'Join us for a free health screening camp on March 15, 2026 at all our partner hospitals across Bangladesh. Services include blood pressure check, diabetes screening, and general health consultation.',
                'type' => 'event',
                'is_active' => true,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'System Maintenance Notice',
                'content' => 'Our online portal will undergo scheduled maintenance on February 15, 2026 from 2:00 AM to 6:00 AM. Services may be temporarily unavailable during this period.',
                'type' => 'general',
                'is_active' => true,
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'New Partner Hospitals Added',
                'content' => 'We have added 15 new partner hospitals across Dhaka, Chittagong, and Sylhet divisions. Check our website for the complete list of healthcare providers.',
                'type' => 'announcement',
                'is_active' => true,
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'COVID-19 Vaccination Drive',
                'content' => 'Free COVID-19 booster shots available for all registered members at designated centers. Book your appointment through our mobile app or website.',
                'type' => 'event',
                'is_active' => true,
                'published_at' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Mobile App Update Available',
                'content' => 'Download the latest version of our mobile app featuring improved user interface, faster claim processing, and real-time doctor availability status.',
                'type' => 'general',
                'is_active' => true,
                'published_at' => Carbon::now()->subDays(15),
            ],
        ];

        foreach ($notices as $notice) {
            Notice::create($notice);
        }
    }
}
