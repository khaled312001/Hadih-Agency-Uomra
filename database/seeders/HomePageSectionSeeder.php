<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\HomePageSection;

class HomePageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section
        HomePageSection::create([
            'type' => 'hero',
            'title_ar' => 'هدية',
            'title_en' => 'Hadiyah',
            'subtitle_ar' => 'تطبيق العمرة الإلكتروني - كوسيط موثوق بين المستفيدين ومزودي الخدمة المؤهلين شرعياً',
            'subtitle_en' => 'Electronic Umrah App - A trusted intermediary between beneficiaries and religiously qualified service providers',
            'video_url' => 'https://www.youtube.com/embed/AvfQb6BI8o8',
            'button_text_ar' => 'اطلب عمرة الآن',
            'button_text_en' => 'Request Umrah Now',
            'button_link' => '/orders/create',
            'order' => 1,
        ]);

        // About Section
        HomePageSection::create([
            'type' => 'about',
            'title_ar' => 'من نحن',
            'title_en' => 'About Us',
            'subtitle_ar' => 'هدية هو تطبيق العمرة الإلكتروني الأول من نوعه في المملكة العربية السعودية، يهدف إلى ربط أصحاب الرخص الشرعية مع مزودي الخدمة المؤهلين شرعياً من طلبة العلم وحَمَلة كتاب الله من سكان مكة المكرمة.',
            'subtitle_en' => 'Hadiyah is the first e-Umrah app of its kind in Saudi Arabia, aiming to connect Shariah license holders with religiously qualified service providers.',
            'image' => 'https://omra.site/assets/images/3.png',
            'order' => 2,
        ]);

        // Stats Section
        HomePageSection::create([
            'type' => 'stats',
            'title_ar' => 'إحصائيات التطبيق',
            'title_en' => 'App Statistics',
            'subtitle_ar' => 'أرقام تتحدث عن نجاحنا في خدمة ضيوف الرحمن',
            'subtitle_en' => 'Numbers that speak of our success in serving the guests of Allah',
            'order' => 3,
        ]);

        // Features Section
        HomePageSection::create([
            'type' => 'features',
            'title_ar' => 'لماذا هدية؟',
            'title_en' => 'Why Hadiyah?',
            'subtitle_ar' => 'مميزات تجعلنا الخيار الأمثل لخدمة العمرة',
            'subtitle_en' => 'Features that make us the ideal choice for Umrah service',
            'content_ar' => [
                ['icon' => 'fas fa-user-graduate', 'title' => 'مزودو خدمة مؤهلون', 'text' => 'طلبة علم وحَمَلة كتاب الله من سكان مكة المكرمة، مؤهلون شرعياً لأداء العمرة بالنيابة'],
                ['icon' => 'fas fa-video', 'title' => 'توثيق شامل', 'text' => 'متابعة جميع مناسك العمرة بالفيديو والصوت، مع إرسال التسجيلات لحساب المستفيد'],
                ['icon' => 'fas fa-shield-alt', 'title' => 'أمان وموثوقية', 'text' => 'نظام أمان متقدم مع ضمانات كاملة لجميع المعاملات والخدمات المقدمة'],
            ],
            'content_en' => [
                ['icon' => 'fas fa-user-graduate', 'title' => 'Qualified Providers', 'text' => 'Knowledge seekers and Quran memorizers from Mecca, religiously qualified to perform Umrah on behalf of others'],
                ['icon' => 'fas fa-video', 'title' => 'Comprehensive Documentation', 'text' => 'Following all Umrah rituals via video and audio, with recordings sent to the beneficiary account'],
                ['icon' => 'fas fa-shield-alt', 'title' => 'Safety and Reliability', 'text' => 'Advanced security system with full guarantees for all transactions and provided services'],
            ],
            'order' => 4,
        ]);
    }
}
