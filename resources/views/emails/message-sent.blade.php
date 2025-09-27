<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نسخة من رسالتك - هدية</title>
    <style>
        body {
            font-family: 'Cairo', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .message-box {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .message-box h3 {
            color: #495057;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .message-text {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
            font-size: 16px;
            line-height: 1.8;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        .info-value {
            color: #6c757d;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .badge {
            background: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        .success-icon {
            text-align: center;
            margin: 20px 0;
        }
        .success-icon i {
            font-size: 48px;
            color: #28a745;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            .header, .content {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ تم إرسال رسالتك</h1>
            <p>تطبيق هدية - العمرة الإلكترونية</p>
        </div>
        
        <div class="content">
            <h2>مرحباً {{ $sender->name }}،</h2>
            <p>تم إرسال رسالتك بنجاح إلى <strong>{{ $receiver->name }}</strong></p>
            
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <div class="message-box">
                <h3>
                    <i class="fas fa-paper-plane"></i> 
                    @if($messageData->subject)
                        {{ $messageData->subject }}
                    @else
                        رسالتك المرسلة
                    @endif
                </h3>
                <div class="message-text">
                    {{ $messageData->message }}
                </div>
            </div>
            
            <div class="info-row">
                <span class="info-label">المستقبل:</span>
                <span class="info-value">{{ $receiver->name }} ({{ $receiver->email }})</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">تاريخ الإرسال:</span>
                <span class="info-value">{{ $messageData->created_at->format('Y-m-d H:i') }}</span>
            </div>
            
            @if($messageData->order)
            <div class="info-row">
                <span class="info-label">الطلب:</span>
                <span class="info-value">
                    <span class="badge">{{ $messageData->order->order_number }}</span>
                </span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="info-label">نوع الرسالة:</span>
                <span class="info-value">
                    @switch($messageData->type)
                        @case('text')
                            <i class="fas fa-font"></i> نص
                            @break
                        @case('image')
                            <i class="fas fa-image"></i> صورة
                            @break
                        @case('video')
                            <i class="fas fa-video"></i> فيديو
                            @break
                        @case('file')
                            <i class="fas fa-file"></i> ملف
                            @break
                    @endswitch
                </span>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/messages') }}" class="btn">
                    <i class="fas fa-envelope"></i> عرض جميع الرسائل
                </a>
            </div>
            
            <div style="background: #d4edda; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0; color: #155724;">
                    <strong>✅ تأكيد:</strong> تم إرسال نسخة من هذه الرسالة إلى بريد المستقبل الإلكتروني.
                </p>
            </div>
            
            <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0; color: #856404;">
                    <strong>💡 ملاحظة:</strong> يمكنك متابعة جميع رسائلك والردود عليها من خلال تطبيق هدية.
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p>
                <strong>هدية - تطبيق العمرة الإلكتروني</strong><br>
                جمعية هدية الحاج والمعتمر الخيرية<br>
                📧 <a href="mailto:info@hadiyah.org.sa">info@hadiyah.org.sa</a> | 
                📞 <a href="tel:+966125401111">0125401111</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                هذه رسالة تلقائية، يرجى عدم الرد عليها مباشرة.
            </p>
        </div>
    </div>
</body>
</html>
