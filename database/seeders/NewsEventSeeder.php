<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsEvent;
use Carbon\Carbon;

class NewsEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsEvents = [
            [
                'title' => 'New Healthcare Package Launched for Rural Areas',
                'content' => '<p>We are excited to announce the launch of our new specialized healthcare package designed specifically for rural communities. This comprehensive package includes preventive care, emergency services, and regular health check-ups at affordable rates.</p><p>Our team has worked tirelessly to ensure that quality healthcare reaches every corner of our service area. The package includes:</p><ul><li>Annual health check-ups</li><li>24/7 emergency consultation</li><li>Discounted medication</li><li>Free health awareness sessions</li></ul>',
                'published_at' => Carbon::now()->subDays(2),
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Health Awareness Campaign - February 2024',
                'content' => '<p>Join us for our monthly health awareness campaign focusing on preventive care and healthy lifestyle habits. This month, we will be covering topics such as:</p><ul><li>Nutrition and balanced diet</li><li>Exercise and physical fitness</li><li>Mental health and stress management</li><li>Common seasonal diseases and prevention</li></ul><p>Free health screening will be available at all our centers. Register now to secure your spot!</p>',
                'published_at' => Carbon::now()->subDays(5),
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Mobile Health Clinic Schedule - March 2024',
                'content' => '<p>Our mobile health clinic will be visiting various districts throughout March 2024. We will provide free consultation, basic health check-ups, and medication distribution to underserved communities.</p><p><strong>Schedule:</strong></p><ul><li>Week 1: Dhaka Division</li><li>Week 2: Chittagong Division</li><li>Week 3: Sylhet Division</li><li>Week 4: Rajshahi Division</li></ul><p>Please check our website for detailed location and timing information.</p>',
                'published_at' => Carbon::now()->subDays(7),
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Partnership with Leading Hospitals Announced',
                'content' => '<p>We are thrilled to announce our strategic partnership with 15 leading hospitals across Bangladesh. This partnership will enable our members to access world-class healthcare facilities at discounted rates.</p><p>Benefits include:</p><ul><li>20% discount on all procedures</li><li>Priority appointment scheduling</li><li>Direct billing facility</li><li>Dedicated customer support</li></ul><p>This initiative is part of our commitment to providing comprehensive healthcare solutions to all our members.</p>',
                'published_at' => Carbon::now()->subDays(10),
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Free COVID-19 Vaccination Drive',
                'content' => '<p>In collaboration with the Ministry of Health, we are organizing a free COVID-19 vaccination drive for our members and their families. The drive will be conducted at all our district offices.</p><p><strong>Date:</strong> February 15-28, 2024</p><p><strong>Time:</strong> 9:00 AM - 5:00 PM</p><p>Vaccines available: Pfizer, Moderna, and AstraZeneca. Please bring your national ID and previous vaccination records if applicable.</p>',
                'published_at' => Carbon::now()->subDays(12),
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($newsEvents as $newsEvent) {
            NewsEvent::create($newsEvent);
        }
    }
}
