// Custom JavaScript for Hadih App

// WhatsApp Floating Button Functionality
document.addEventListener('DOMContentLoaded', function() {
    const whatsappButton = document.getElementById('whatsapp-float');

    if (whatsappButton) {
        whatsappButton.addEventListener('click', function(e) {
            e.preventDefault();

            const phoneNumber = this.getAttribute('data-phone') || '966501234567';
            const message = this.getAttribute('data-message') || 'مرحباً، أريد الاستفسار عن خدماتكم';
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

            window.open(whatsappUrl, '_blank');

            this.style.transform = 'scale(0.95)';
            setTimeout(() => { this.style.transform = 'scale(1)'; }, 150);
        });

        // Hide/show button on scroll
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            window.requestAnimationFrame(function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    whatsappButton.style.transform = 'translateY(100px)';
                    whatsappButton.style.opacity = '0.7';
                } else {
                    whatsappButton.style.transform = 'translateY(0)';
                    whatsappButton.style.opacity = '1';
                }
                lastScrollTop = scrollTop;
            });
        });
    }
});
