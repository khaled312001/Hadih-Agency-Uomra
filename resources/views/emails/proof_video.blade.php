<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Cairo', sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; background-color: #f8fafc; padding: 20px; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; text-align: right; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .button { display: inline-block; padding: 12px 25px; background-color: #6366f1; color: #ffffff !important; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>هدية - فيديو إثبات العمرة</h2>
        </div>
        <div class="content">
            <p>أهلاً {{ $order->customer_name }},</p>
            <p>نود إعلامكم بأنه تم رفع فيديو إثبات أداء مناسك العمرة لطلبكم رقم <strong>{{ $order->order_number }}</strong> والمخصص للمستفيد <strong>{{ $order->beneficiary_name }}</strong>.</p>
            <p>يمكنكم الآن مشاهدة الفيديو من خلال حسابكم على الموقع عبر الرابط التالي:</p>
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('orders.show', $order) }}" class="button">مشاهدة فيديو الإثبات</a>
            </div>
            <p>تقبل الله منا ومنكم صالح الأعمال.</p>
        </div>
        <div class="footer">
            <p>هذا البريد تم إرساله آلياً من منصة هدية.</p>
        </div>
    </div>
</body>
</html>
