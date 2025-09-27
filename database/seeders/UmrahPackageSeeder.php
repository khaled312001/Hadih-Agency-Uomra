<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmrahPackage;

class UmrahPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name_ar' => 'عمرة رمضان',
                'name_en' => 'Ramadan Umrah',
                'description_ar' => 'عمرة مباركة في شهر رمضان الكريم مع خدمات متكاملة وتوثيق شامل',
                'description_en' => 'Blessed Umrah during the holy month of Ramadan with comprehensive services and documentation',
                'price' => 950.00,
                'currency' => 'SAR',
                'duration' => '7 أيام',
                'features' => [
                    'تأمين شامل',
                    'وجبات إفطار وسحور',
                    'مواصلات مريحة',
                    'مرشد ديني متخصص',
                    'توثيق بالفيديو',
                    'متابعة مستمرة'
                ],
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name_ar' => 'عمرة عاجلة',
                'name_en' => 'Urgent Umrah',
                'description_ar' => 'عمرة سريعة للمحتاجين مع معالجة فورية للطلب',
                'description_en' => 'Fast Umrah for those in need with immediate request processing',
                'price' => 1100.00,
                'currency' => 'SAR',
                'duration' => '3 أيام',
                'features' => [
                    'خدمة سريعة',
                    'تأمين شامل',
                    'مواصلات فورية',
                    'مرشد ديني',
                    'توثيق بالفيديو',
                    'دعم فني 24/7'
                ],
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name_ar' => 'عمرة باقي أيام العام',
                'name_en' => 'Regular Umrah',
                'description_ar' => 'عمرة عادية لبقية أيام السنة مع خدمات أساسية',
                'description_en' => 'Regular Umrah for the rest of the year with basic services',
                'price' => 550.00,
                'currency' => 'SAR',
                'duration' => '5 أيام',
                'features' => [
                    'تأمين أساسي',
                    'مواصلات مريحة',
                    'مرشد ديني',
                    'توثيق بالفيديو',
                    'متابعة دورية'
                ],
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name_ar' => 'عمرة الأشهر الحرم',
                'name_en' => 'Sacred Months Umrah',
                'description_ar' => 'عمرة في الأشهر الحرم مع خدمات متميزة',
                'description_en' => 'Umrah during the sacred months with premium services',
                'price' => 750.00,
                'currency' => 'SAR',
                'duration' => '6 أيام',
                'features' => [
                    'تأمين شامل',
                    'وجبات مريحة',
                    'مواصلات مريحة',
                    'مرشد ديني متخصص',
                    'توثيق بالفيديو',
                    'هدايا تذكارية'
                ],
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name_ar' => 'عمرة دولار',
                'name_en' => 'Dollar Umrah',
                'description_ar' => 'حزمة عمرة بالدولار الأمريكي للمقيمين الأجانب.',
                'description_en' => 'Umrah package in US Dollar for foreign residents.',
                'price' => 250.00,
                'currency' => 'USD',
                'duration' => '5 أيام',
                'features' => ['تأمين شامل', 'مواصلات مريحة', 'مرشد ديني', 'توثيق بالفيديو'],
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name_ar' => 'عمرة يورو',
                'name_en' => 'Euro Umrah',
                'description_ar' => 'حزمة عمرة باليورو للزوار الأوروبيين.',
                'description_en' => 'Umrah package in Euro for European visitors.',
                'price' => 200.00,
                'currency' => 'EUR',
                'duration' => '4 أيام',
                'features' => ['تأمين أساسي', 'مواصلات مريحة', 'مرشد ديني', 'توثيق بالفيديو'],
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name_ar' => 'عمرة درهم',
                'name_en' => 'Dirham Umrah',
                'description_ar' => 'حزمة عمرة بالدرهم الإماراتي للزوار من الإمارات.',
                'description_en' => 'Umrah package in UAE Dirham for visitors from UAE.',
                'price' => 900.00,
                'currency' => 'AED',
                'duration' => '5 أيام',
                'features' => ['تأمين شامل', 'مواصلات مريحة', 'مرشد ديني', 'توثيق بالفيديو'],
                'is_active' => true,
                'sort_order' => 7
            ]
        ];

        foreach ($packages as $package) {
            UmrahPackage::create($package);
        }
    }
}