<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Policy;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $policies = [
            [
                'title' => 'Memorandum of Association',
                'category' => 'Legal',
                'description' => 'The Memorandum of Association is the fundamental document that defines the constitution and scope of Prottoy Healthcare\'s activities.',
                'content' => '<h5>Key Provisions:</h5>
                    <ul>
                        <li><strong>Name Clause:</strong> Formally establishes "Prottoy Healthcare" as our registered name</li>
                        <li><strong>Registered Office Clause:</strong> Specifies the location of our head office in Bangladesh</li>
                        <li><strong>Objects Clause:</strong> Defines our primary objective to provide comprehensive healthcare management services</li>
                        <li><strong>Liability Clause:</strong> Establishes the extent of members\' liability</li>
                        <li><strong>Capital Clause:</strong> Details the authorized capital and share structure</li>
                        <li><strong>Subscription Clause:</strong> Lists founding members and their commitments</li>
                    </ul>

                    <h5>Objectives:</h5>
                    <ul>
                        <li>To provide accessible and affordable healthcare services to citizens of Bangladesh</li>
                        <li>To establish and maintain a comprehensive healthcare network across all divisions</li>
                        <li>To facilitate efficient healthcare claims processing and management</li>
                        <li>To promote healthcare awareness and preventive care practices</li>
                        <li>To collaborate with healthcare providers and government agencies</li>
                        <li>To maintain highest standards of service quality and ethical practices</li>
                    </ul>',
                'icon' => 'bi-file-earmark-text',
                'color' => '#667eea',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'category' => 'Privacy',
                'description' => 'Prottoy Healthcare is committed to protecting the privacy and security of our customers\' personal and health information.',
                'content' => '<h5>Information We Collect:</h5>
                    <ul>
                        <li>Personal identification information (name, address, phone number, email)</li>
                        <li>Healthcare information and medical history</li>
                        <li>Claims and service utilization data</li>
                        <li>Payment and transaction information</li>
                    </ul>

                    <h5>How We Use Your Information:</h5>
                    <ul>
                        <li>To provide healthcare services and process claims</li>
                        <li>To communicate important updates and notifications</li>
                        <li>To improve service quality and customer experience</li>
                        <li>To comply with legal and regulatory requirements</li>
                    </ul>

                    <h5>Data Security:</h5>
                    <ul>
                        <li>Industry-standard encryption for all data transmission</li>
                        <li>Secure storage with regular backups and access controls</li>
                        <li>Compliance with Bangladesh Data Protection regulations</li>
                        <li>Regular security audits and vulnerability assessments</li>
                    </ul>

                    <h5>Your Rights:</h5>
                    <ul>
                        <li>Right to access your personal data</li>
                        <li>Right to correct inaccurate information</li>
                        <li>Right to request data deletion</li>
                        <li>Right to withdraw consent</li>
                    </ul>',
                'icon' => 'bi-shield-lock',
                'color' => '#28a745',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Terms of Service',
                'category' => 'Terms',
                'description' => 'These Terms of Service govern your use of Prottoy Healthcare services. By registering as a customer or using our services, you agree to be bound by these terms.',
                'content' => '<h5>Service Agreement:</h5>
                    <ul>
                        <li>Eligibility criteria for healthcare services</li>
                        <li>Service coverage and limitations</li>
                        <li>Payment terms and conditions</li>
                        <li>Claim submission procedures and timelines</li>
                        <li>Customer responsibilities and obligations</li>
                    </ul>

                    <h5>Service Modifications:</h5>
                    <ul>
                        <li>Right to modify services with prior notice</li>
                        <li>Updates to terms and conditions</li>
                        <li>Changes in pricing or coverage</li>
                    </ul>

                    <h5>Termination:</h5>
                    <ul>
                        <li>Conditions under which services may be terminated</li>
                        <li>Notice requirements for termination</li>
                        <li>Refund policies upon termination</li>
                        <li>Post-termination obligations</li>
                    </ul>

                    <h5>Limitation of Liability:</h5>
                    <ul>
                        <li>Scope of our liability for service interruptions</li>
                        <li>Force majeure provisions</li>
                        <li>Dispute resolution procedures</li>
                        <li>Governing law and jurisdiction</li>
                    </ul>',
                'icon' => 'bi-file-earmark-ruled',
                'color' => '#dc3545',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Refund & Cancellation Policy',
                'category' => 'Financial',
                'description' => 'Our comprehensive refund and cancellation policy ensures transparency and fairness in all financial transactions.',
                'content' => '<h5>Refund Eligibility:</h5>
                    <ul>
                        <li>Services not provided within the stipulated timeframe</li>
                        <li>Duplicate or erroneous charges</li>
                        <li>Cancellation within the cooling-off period</li>
                        <li>Service discontinuation by Prottoy Healthcare</li>
                    </ul>

                    <h5>Refund Process:</h5>
                    <ul>
                        <li>Submit refund request through customer portal</li>
                        <li>Provide necessary documentation and proof</li>
                        <li>Allow 7-14 business days for processing</li>
                        <li>Refunds processed to original payment method</li>
                    </ul>

                    <h5>Cancellation Terms:</h5>
                    <ul>
                        <li>7-day cooling-off period for new subscriptions</li>
                        <li>30-day notice required for service cancellation</li>
                        <li>No fees for cancellation within cooling-off period</li>
                        <li>Prorated refunds for annual subscriptions</li>
                    </ul>

                    <h5>Non-Refundable Items:</h5>
                    <ul>
                        <li>Services already rendered or utilized</li>
                        <li>Administrative and processing fees</li>
                        <li>Third-party charges and fees</li>
                        <li>Promotional or discounted services</li>
                    </ul>',
                'icon' => 'bi-cash-coin',
                'color' => '#ffc107',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($policies as $policyData) {
            Policy::create($policyData);
        }
    }
}
