<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Dr. Kamal Hossain',
                'customer_designation' => 'General Physician, Dhaka Medical College',
                'customer_photo' => null,
                'testimonial' => 'Prottoy Healthcare has transformed the way we manage patient care. Their comprehensive system and nationwide network make healthcare accessible to everyone. The claim process is seamless and the support team is always responsive.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Fatema Begum',
                'customer_designation' => 'Business Owner, Chittagong',
                'customer_photo' => null,
                'testimonial' => 'I have been using Prottoy Healthcare for my family for over 2 years now. The peace of mind knowing that quality healthcare is just a call away is invaluable. Their customer service is exceptional and they truly care about their members.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Mohammad Rahman',
                'customer_designation' => 'Teacher, Sylhet',
                'customer_photo' => null,
                'testimonial' => 'As a teacher with a modest income, I always worried about healthcare expenses. Prottoy Healthcare has made quality medical care affordable for me and my family. The network of hospitals is extensive and the packages are very reasonable.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Nasrin Ahmed',
                'customer_designation' => 'IT Professional, Dhaka',
                'customer_photo' => null,
                'testimonial' => 'The digital platform is user-friendly and makes everything so convenient. From booking appointments to tracking claims, everything is available at my fingertips. Highly recommend Prottoy Healthcare to everyone!',
                'rating' => 4,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Abdul Jabbar',
                'customer_designation' => 'Retired Government Officer, Rajshahi',
                'customer_photo' => null,
                'testimonial' => 'At my age, healthcare is a major concern. Prottoy Healthcare has been a blessing. Their 24/7 support and wide network of healthcare providers give me confidence. The staff is always helpful and patient with seniors like me.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Rupa Das',
                'customer_designation' => 'Engineer, Khulna',
                'customer_photo' => null,
                'testimonial' => 'I recently had to use their emergency services and I was impressed by how quickly they responded. The coordination between the healthcare provider and Prottoy was seamless. Thank you for being there when I needed you most!',
                'rating' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
