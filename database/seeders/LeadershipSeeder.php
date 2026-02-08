<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leadership;

class LeadershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaders = [
            [
                'name' => 'Dr. Mohammad Karim',
                'designation' => 'Chief Executive Officer & Founder',
                'bio' => '<p>Dr. Mohammad Karim is a visionary healthcare leader with over 25 years of experience in healthcare management and administration. He founded Prottoy Healthcare with the mission of making quality healthcare accessible to every citizen of Bangladesh.</p>
                    <p>Before founding Prottoy Healthcare, Dr. Karim served as the Director of Healthcare Operations at Bangladesh Medical Council and held senior leadership positions at several renowned healthcare institutions. He holds an MBBS from Dhaka Medical College, an MBA in Healthcare Management from IBA, and a Masters in Public Health from Johns Hopkins University.</p>
                    <p>Under his leadership, Prottoy Healthcare has grown from a small startup to one of the most trusted healthcare management organizations in Bangladesh, serving over 500,000 members across all divisions.</p>',
                'email' => 'dr.karim@prottoyhealthcare.com',
                'phone' => '+880 1711-123456',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Ms. Fatima Rahman',
                'designation' => 'Chief Operating Officer',
                'bio' => '<p>Ms. Fatima Rahman brings over 20 years of operational excellence and strategic planning expertise to Prottoy Healthcare. She oversees all day-to-day operations, ensuring seamless service delivery across our nationwide network.</p>
                    <p>Prior to joining Prottoy Healthcare, Fatima was the VP of Operations at Square Health Network and held senior management roles in several Fortune 500 healthcare companies. She holds an MBA from North South University and is a certified Six Sigma Black Belt.</p>
                    <p>Her data-driven approach and commitment to operational efficiency have been instrumental in reducing claim processing times by 60% and improving customer satisfaction scores significantly.</p>',
                'email' => 'fatima.rahman@prottoyhealthcare.com',
                'phone' => '+880 1712-234567',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Ahmed Hassan',
                'designation' => 'Chief Medical Officer',
                'bio' => '<p>Dr. Ahmed Hassan is a highly respected physician and healthcare policy expert who leads our clinical operations and quality assurance initiatives. He ensures that all medical services meet the highest standards of care and compliance.</p>
                    <p>Dr. Hassan is a specialist in Internal Medicine with over 18 years of clinical practice. He completed his MBBS from Chittagong Medical College, MD from Bangabandhu Sheikh Mujib Medical University, and a fellowship in Healthcare Quality from Harvard Medical School.</p>
                    <p>He has published numerous research papers on healthcare quality improvement and serves on the advisory board of the Bangladesh Healthcare Quality Council.</p>',
                'email' => 'dr.hassan@prottoyhealthcare.com',
                'phone' => '+880 1713-345678',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Mr. Rahim Uddin',
                'designation' => 'Chief Technology Officer',
                'bio' => '<p>Mr. Rahim Uddin is a technology innovator passionate about leveraging digital solutions to transform healthcare delivery. He leads our technology strategy and oversees the development of our cutting-edge healthcare management platform.</p>
                    <p>Rahim has over 15 years of experience in healthcare IT and digital transformation. Before joining Prottoy Healthcare, he was the Head of Digital Innovation at Grameenphone Health and worked as a senior architect at multiple tech startups.</p>
                    <p>He holds a BSc in Computer Science from BUET and an MS in Health Informatics from University of Waterloo. Under his leadership, Prottoy Healthcare has won multiple awards for technological innovation in healthcare.</p>',
                'email' => 'rahim.uddin@prottoyhealthcare.com',
                'phone' => '+880 1714-456789',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Ms. Nasrin Akter',
                'designation' => 'Chief Financial Officer',
                'bio' => '<p>Ms. Nasrin Akter is a seasoned financial executive responsible for all financial planning, risk management, and strategic investments at Prottoy Healthcare. Her prudent financial management has enabled sustainable growth and expansion.</p>
                    <p>With over 16 years of experience in healthcare finance, Nasrin previously served as Finance Director at BRAC Health Programme and held senior positions at PwC Bangladesh. She is a chartered accountant (CA) and holds an MBA in Finance from Dhaka University.</p>
                    <p>Her expertise in healthcare economics and financial modeling has been crucial in developing our affordable package pricing strategy that benefits hundreds of thousands of members.</p>',
                'email' => 'nasrin.akter@prottoyhealthcare.com',
                'phone' => '+880 1715-567890',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Sharmin Sultana',
                'designation' => 'Director of Quality & Compliance',
                'bio' => '<p>Dr. Sharmin Sultana ensures that Prottoy Healthcare maintains the highest standards of quality, safety, and regulatory compliance. She oversees all quality assurance programs and compliance initiatives across our organization.</p>
                    <p>Dr. Sultana has 14 years of experience in healthcare quality management and regulatory affairs. She holds an MBBS from Sir Salimullah Medical College, an MPH from BRAC University, and certifications in Healthcare Quality Management from ISQua.</p>
                    <p>Her leadership has helped Prottoy Healthcare achieve multiple quality certifications and maintain a flawless record of regulatory compliance with all government healthcare authorities.</p>',
                'email' => 'dr.sultana@prottoyhealthcare.com',
                'phone' => '+880 1716-678901',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($leaders as $leaderData) {
            Leadership::create($leaderData);
        }
    }
}
