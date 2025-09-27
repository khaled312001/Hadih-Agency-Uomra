<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UmrahPackage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Message;
use App\Models\Video;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مقدم خدمة وهمي (سيتم إنشاؤه بعد إنشاء المستخدمين)

        // إنشاء حزم العمرة الوهمية
        $packages = [
            [
                'name_ar' => 'حزمة العمرة المميزة',
                'name_en' => 'Premium Umrah Package',
                'description_ar' => 'حزمة عمرة شاملة مع أفضل الخدمات والفنادق',
                'description_en' => 'Comprehensive Umrah package with best services and hotels',
                'price' => 3500.00,
                'currency' => 'SAR',
                'duration' => 7,
                'features' => ['فندق 5 نجوم', 'وجبات شاملة', 'نقل مريح', 'مرشد سياحي'],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_ar' => 'حزمة العمرة الاقتصادية',
                'name_en' => 'Economy Umrah Package',
                'description_ar' => 'حزمة عمرة اقتصادية مع خدمات جيدة',
                'description_en' => 'Economy Umrah package with good services',
                'price' => 2500.00,
                'currency' => 'SAR',
                'duration' => 5,
                'features' => ['فندق 3 نجوم', 'وجبات أساسية', 'نقل جماعي'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name_ar' => 'حزمة العمرة الفاخرة',
                'name_en' => 'Luxury Umrah Package',
                'description_ar' => 'حزمة عمرة فاخرة مع أفضل الفنادق والخدمات',
                'description_en' => 'Luxury Umrah package with best hotels and services',
                'price' => 5500.00,
                'currency' => 'SAR',
                'duration' => 10,
                'features' => ['فندق 7 نجوم', 'وجبات فاخرة', 'نقل خاص', 'مرشد شخصي', 'خدمات VIP'],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name_ar' => 'حزمة العمرة العائلية',
                'name_en' => 'Family Umrah Package',
                'description_ar' => 'حزمة عمرة مخصصة للعائلات',
                'description_en' => 'Umrah package designed for families',
                'price' => 4200.00,
                'currency' => 'SAR',
                'duration' => 8,
                'features' => ['غرف عائلية', 'أنشطة للأطفال', 'وجبات متنوعة', 'نقل مريح'],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name_ar' => 'حزمة العمرة السريعة',
                'name_en' => 'Quick Umrah Package',
                'description_ar' => 'حزمة عمرة سريعة لمدة 3 أيام',
                'description_en' => 'Quick Umrah package for 3 days',
                'price' => 1800.00,
                'currency' => 'SAR',
                'duration' => 3,
                'features' => ['إقامة قصيرة', 'نقل سريع', 'خدمات أساسية'],
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($packages as $packageData) {
            UmrahPackage::create($packageData);
        }

        // إنشاء مستخدمين وهميين
        $users = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'phone' => '+966501234567',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'فاطمة علي',
                'email' => 'fatima@example.com',
                'phone' => '+966502345678',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'محمد عبدالله',
                'email' => 'mohammed@example.com',
                'phone' => '+966503456789',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'نورا السعد',
                'email' => 'nora@example.com',
                'phone' => '+966504567890',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'خالد الحسن',
                'email' => 'khalid@example.com',
                'phone' => '+966505678901',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'مريم أحمد',
                'email' => 'mariam@example.com',
                'phone' => '+966506789012',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'عبدالرحمن محمد',
                'email' => 'abdulrahman@example.com',
                'phone' => '+966507890123',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'سارة عبدالله',
                'email' => 'sara@example.com',
                'phone' => '+966508901234',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'يوسف العتيبي',
                'email' => 'yousef@example.com',
                'phone' => '+966509012345',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'هند القحطاني',
                'email' => 'hind@example.com',
                'phone' => '+966500123456',
                'country_code' => 'SA',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // إنشاء طلبات وهمية
        $statuses = ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'];
        $beneficiaryTypes = ['deceased', 'sick', 'elderly', 'disabled'];
        
        for ($i = 0; $i < 50; $i++) {
            $user = User::inRandomOrder()->first();
            $package = UmrahPackage::inRandomOrder()->first();
            $status = $statuses[array_rand($statuses)];
            $beneficiaryType = $beneficiaryTypes[array_rand($beneficiaryTypes)];
            
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'umrah_package_id' => $package->id,
                'beneficiary_name' => fake('ar_SA')->name(),
                'beneficiary_phone' => '+966' . fake()->numerify('########'),
                'beneficiary_address' => fake('ar_SA')->address(),
                'beneficiary_type' => $beneficiaryType,
                'beneficiary_details' => fake('ar_SA')->sentence(),
                'total_amount' => $package->price + fake()->numberBetween(100, 500),
                'currency' => 'SAR',
                'status' => $status,
                'notes' => fake('ar_SA')->sentence(),
                'assigned_at' => $status !== 'pending' ? fake()->dateTimeBetween('-30 days', 'now') : null,
                'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-20 days', 'now') : null,
                'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
            ]);

            // إنشاء مدفوعات للطلبات المكتملة والمؤكدة
            if (in_array($status, ['assigned', 'in_progress', 'completed'])) {
                Payment::create([
                    'order_id' => $order->id,
                    'payment_id' => 'PAY-' . fake()->uuid(),
                    'amount' => $order->total_amount,
                    'currency' => 'SAR',
                    'status' => $status === 'completed' ? 'completed' : 'pending',
                    'payment_method' => fake()->randomElement(['credit_card', 'bank_transfer', 'wallet']),
                    'gateway_response' => ['transaction_id' => fake()->uuid()],
                    'notes' => fake('ar_SA')->sentence(),
                    'paid_at' => $status === 'completed' ? fake()->dateTimeBetween('-20 days', 'now') : null,
                    'created_at' => $order->created_at,
                ]);
            }

            // إنشاء رسائل للطلبات
            if (fake()->boolean(70)) { // 70% من الطلبات لها رسائل
                Message::create([
                    'order_id' => $order->id,
                    'sender_id' => $user->id,
                    'receiver_id' => 1, // Admin user
                    'message' => fake('ar_SA')->sentence(),
                    'is_read' => fake()->boolean(80),
                    'created_at' => fake()->dateTimeBetween($order->created_at, 'now'),
                ]);
            }

            // إنشاء فيديوهات للطلبات المكتملة
            if ($status === 'completed' && fake()->boolean(60)) { // 60% من الطلبات المكتملة لها فيديوهات
                $serviceProvider = ServiceProvider::first();
                if ($serviceProvider) {
                    Video::create([
                        'order_id' => $order->id,
                        'service_provider_id' => $serviceProvider->id,
                    'title' => fake('ar_SA')->sentence(3),
                    'description' => fake('ar_SA')->paragraph(),
                    'video_path' => 'videos/' . fake()->uuid() . '.mp4',
                    'thumbnail' => 'thumbnails/' . fake()->uuid() . '.jpg',
                    'duration' => fake()->numberBetween(30, 300),
                    'file_size' => fake()->numberBetween(1024, 10240) . ' MB',
                    'ritual_type' => fake()->randomElement(['tawaf', 'saee', 'dua', 'other']),
                    'is_approved' => fake()->boolean(80),
                    'admin_notes' => fake()->boolean(30) ? fake('ar_SA')->sentence() : null,
                    'created_at' => fake()->dateTimeBetween($order->completed_at, 'now'),
                    ]);
                }
            }
        }

        $this->command->info('تم إنشاء البيانات الوهمية بنجاح!');
        $this->command->info('- ' . UmrahPackage::count() . ' حزمة عمرة');
        $this->command->info('- ' . User::count() . ' مستخدم');
        $this->command->info('- ' . Order::count() . ' طلب');
        $this->command->info('- ' . Payment::count() . ' دفعة');
        $this->command->info('- ' . Message::count() . ' رسالة');
        $this->command->info('- ' . Video::count() . ' فيديو');
    }
}