// Custom JavaScript for Laravel App

// Axios configuration (loaded via CDN)
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF Token setup for Axios
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// WhatsApp Floating Button Functionality
document.addEventListener('DOMContentLoaded', function() {
    // WhatsApp button click handler
    const whatsappButton = document.getElementById('whatsapp-float');
    
    if (whatsappButton) {
        whatsappButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the phone number from the data attribute or use default
            const phoneNumber = this.getAttribute('data-phone') || '966501234567';
            const message = this.getAttribute('data-message') || 'مرحباً، أريد الاستفسار عن خدماتكم';
            
            // Create WhatsApp URL
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            
            // Open WhatsApp in new tab
            window.open(whatsappUrl, '_blank');
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
        
        // Add scroll effect - hide button when scrolling down, show when scrolling up
        let lastScrollTop = 0;
        let isScrolling = false;
        
        window.addEventListener('scroll', function() {
            if (!isScrolling) {
                window.requestAnimationFrame(function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const whatsappButton = document.getElementById('whatsapp-float');
                    
                    if (whatsappButton) {
                        if (scrollTop > lastScrollTop && scrollTop > 100) {
                            // Scrolling down
                            whatsappButton.style.transform = 'translateY(100px)';
                            whatsappButton.style.opacity = '0.7';
                        } else {
                            // Scrolling up
                            whatsappButton.style.transform = 'translateY(0)';
                            whatsappButton.style.opacity = '1';
                        }
                    }
                    
                    lastScrollTop = scrollTop;
                    isScrolling = false;
                });
            }
            isScrolling = true;
        });
    }
});

// Add any custom JavaScript here
