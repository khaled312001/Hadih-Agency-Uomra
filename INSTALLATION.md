# دليل التثبيت والتشغيل - تطبيق هدية

## المتطلبات الأساسية

### 1. متطلبات الخادم
- **PHP**: الإصدار 8.1 أو أحدث
- **Composer**: لإدارة تبعيات PHP
- **MySQL**: الإصدار 5.7 أو أحدث
- **Apache/Nginx**: خادم ويب
- **OpenSSL PHP Extension**
- **PDO PHP Extension**
- **Mbstring PHP Extension**
- **Tokenizer PHP Extension**
- **XML PHP Extension**
- **Ctype PHP Extension**
- **JSON PHP Extension**
- **BCMath PHP Extension**

### 2. متطلبات التطوير (اختيارية)
- **Node.js**: للتجميع والتطوير
- **NPM/Yarn**: لإدارة حزم JavaScript

## خطوات التثبيت

### الخطوة 1: تحضير البيئة

#### على Windows:
```bash
# تحميل وتثبيت XAMPP أو WAMP
# تشغيل Apache و MySQL

# تثبيت Composer
# تحميل من: https://getcomposer.org/download/
```

#### على Linux/Mac:
```bash
# تثبيت PHP و MySQL
sudo apt update
sudo apt install php8.1 php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl
sudo apt install mysql-server
sudo apt install composer
```

### الخطوة 2: إعداد المشروع

```bash
# الانتقال إلى مجلد المشروع
cd tafweed-app

# تثبيت التبعيات
composer install

# نسخ ملف البيئة
cp .env.example .env

# توليد مفتاح التطبيق
php artisan key:generate
```

### الخطوة 3: إعداد قاعدة البيانات

#### إنشاء قاعدة البيانات:
```sql
CREATE DATABASE tafweed_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### تحديث ملف .env:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tafweed_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### الخطوة 4: تشغيل Migration

```bash
# تشغيل Migration لإنشاء الجداول
php artisan migrate

# إضافة البيانات التجريبية
php artisan db:seed --class=UmrahPackageSeeder
php artisan db:seed --class=AdminUserSeeder
```

### الخطوة 5: إعداد الصلاحيات

```bash
# إعطاء صلاحيات الكتابة لمجلدات التخزين
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# على Windows، تأكد من أن المجلدات قابلة للكتابة
```

### الخطوة 6: تشغيل التطبيق

```bash
# تشغيل خادم التطوير
php artisan serve

# التطبيق سيكون متاحاً على: http://localhost:8000
```

## إعداد الإنتاج

### الخطوة 1: تحسين الأداء

```bash
# تحسين التحميل التلقائي
composer install --optimize-autoloader --no-dev

# تحسين التكوين
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### الخطوة 2: إعداد الخادم

#### Apache (.htaccess):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/tafweed-app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### الخطوة 3: إعداد SSL

```bash
# استخدام Let's Encrypt
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d your-domain.com
```

## الحسابات الافتراضية

### حساب الإدارة
- **البريد الإلكتروني**: admin@tafweed.com
- **كلمة المرور**: password

> ⚠️ **تحذير**: قم بتغيير كلمة المرور فوراً في بيئة الإنتاج!

## استكشاف الأخطاء

### مشاكل شائعة:

#### 1. خطأ في قاعدة البيانات:
```bash
# التحقق من اتصال قاعدة البيانات
php artisan migrate:status

# إعادة تشغيل Migration
php artisan migrate:fresh --seed
```

#### 2. مشاكل الصلاحيات:
```bash
# إصلاح صلاحيات المجلدات
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

#### 3. مشاكل التخزين المؤقت:
```bash
# مسح التخزين المؤقت
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### 4. مشاكل Composer:
```bash
# إعادة تثبيت التبعيات
rm -rf vendor
composer install
```

## النسخ الاحتياطي

### نسخ احتياطي لقاعدة البيانات:
```bash
# إنشاء نسخة احتياطية
mysqldump -u root -p tafweed_db > backup_$(date +%Y%m%d_%H%M%S).sql

# استعادة النسخة الاحتياطية
mysql -u root -p tafweed_db < backup_file.sql
```

### نسخ احتياطي للملفات:
```bash
# نسخ احتياطي للمشروع
tar -czf tafweed_backup_$(date +%Y%m%d_%H%M%S).tar.gz tafweed-app/
```

## التحديثات

### تحديث التطبيق:
```bash
# جلب التحديثات
git pull origin main

# تحديث التبعيات
composer install

# تشغيل Migration الجديدة
php artisan migrate

# مسح التخزين المؤقت
php artisan cache:clear
```

## المراقبة والصيانة

### مراقبة الأداء:
```bash
# عرض سجلات الأخطاء
tail -f storage/logs/laravel.log

# مراقبة استخدام الذاكرة
php artisan tinker
>>> memory_get_usage(true)
```

### تنظيف دوري:
```bash
# تنظيف الملفات المؤقتة
php artisan cache:clear
php artisan queue:clear

# تنظيف سجلات قديمة
php artisan log:clear
```

## الدعم الفني

في حالة مواجهة أي مشاكل:

1. **تحقق من السجلات**: `storage/logs/laravel.log`
2. **تحقق من المتطلبات**: `php artisan about`
3. **تواصل مع الدعم**: info@hadiyah.org.sa

---

**ملاحظة**: هذا الدليل مخصص للتثبيت الأساسي. للحصول على دعم متقدم، يرجى التواصل مع فريق التطوير.
