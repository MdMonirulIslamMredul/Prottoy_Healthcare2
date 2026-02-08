<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInfo::create([
            'address' => 'House #123, Road #12, Dhanmondi, Dhaka-1205, Bangladesh',
            'phone' => '+880 2-9876543, +880 1711-123456',
            'email' => 'info@prottoyhealthcare.com',
            'facebook' => 'https://facebook.com/prottoyhealthcare',
            'twitter' => 'https://twitter.com/prottoyhealthbd',
            'linkedin' => 'https://linkedin.com/company/prottoy-healthcare',
            'instagram' => 'https://instagram.com/prottoyhealthcare',
            'working_hours' => 'Saturday - Thursday: 9:00 AM - 6:00 PM (Friday Closed)',
            'is_active' => true,
        ]);
    }
}
