/**
 * HADIYAH - ANIMATIONS & INTERACTIONS
 * Creative animations and interactive effects for the website
 */

class HadiyahAnimations {
    constructor() {
        this.init();
    }

    init() {
        this.setupScrollAnimations();
        this.setupNavbarAnimations();
        this.setupButtonAnimations();
        this.setupFormAnimations();
        this.setupCardAnimations();
        this.setupCounterAnimations();
        this.setupParallaxEffects();
        this.setupTypingEffect();
        this.setupParticleSystem();
        this.setupLoadingStates();
        this.setupSuccessAnimations();
        this.setupHoverEffects();
        this.setupClickEffects();
    }

    // ===== SCROLL ANIMATIONS =====
    setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    
                    // Add staggered animation for children
                    const children = entry.target.querySelectorAll('.animate-child');
                    children.forEach((child, index) => {
                        setTimeout(() => {
                            child.classList.add('animated');
                        }, index * 100);
                    });
                }
            });
        }, observerOptions);

        // Observe all elements with animate-on-scroll class
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Add scroll-based navbar background
        window.addEventListener('scroll', this.throttle(() => {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        }, 100));
    }

    // ===== NAVBAR ANIMATIONS =====
    setupNavbarAnimations() {
        const navbar = document.querySelector('.navbar');
        if (!navbar) return;

        // Add hover effects to nav links
        const navLinks = navbar.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                link.style.transform = 'translateY(-2px)';
            });
            
            link.addEventListener('mouseleave', () => {
                link.style.transform = 'translateY(0)';
            });
        });

        // Mobile menu toggle animation
        const navbarToggler = navbar.querySelector('.navbar-toggler');
        if (navbarToggler) {
            navbarToggler.addEventListener('click', () => {
                navbarToggler.classList.toggle('active');
            });
        }
    }

    // ===== BUTTON ANIMATIONS =====
    setupButtonAnimations() {
        const buttons = document.querySelectorAll('.btn');
        
        buttons.forEach(button => {
            // Ripple effect
            button.addEventListener('click', (e) => {
                this.createRippleEffect(e, button);
            });

            // Hover effects
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-3px)';
            });

            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0)';
            });
        });
    }

    // ===== FORM ANIMATIONS =====
    setupFormAnimations() {
        const formControls = document.querySelectorAll('.form-control');
        
        formControls.forEach(control => {
            // Focus animations
            control.addEventListener('focus', () => {
                control.style.transform = 'scale(1.02)';
                control.style.borderColor = '#4a90e2';
            });

            control.addEventListener('blur', () => {
                control.style.transform = 'scale(1)';
                if (!control.value) {
                    control.style.borderColor = '#e9ecef';
                }
            });

            // Input validation animations
            control.addEventListener('input', () => {
                if (control.checkValidity()) {
                    control.style.borderColor = '#28a745';
                } else {
                    control.style.borderColor = '#dc3545';
                }
            });
        });

        // Form submission animations
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
        });
    }

    // ===== CARD ANIMATIONS =====
    setupCardAnimations() {
        const cards = document.querySelectorAll('.card, .package-card, .feature-card, .stat-card');
        
        cards.forEach(card => {
            // Hover animations
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px) scale(1.02)';
                card.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
                card.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.1)';
            });

            // Click animations
            card.addEventListener('mousedown', () => {
                card.style.transform = 'translateY(-8px) scale(1.01)';
            });

            card.addEventListener('mouseup', () => {
                card.style.transform = 'translateY(-10px) scale(1.02)';
            });
        });
    }

    // ===== COUNTER ANIMATIONS =====
    setupCounterAnimations() {
        const counters = document.querySelectorAll('.stats-counter, .counter');
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });
    }

    animateCounter(element) {
        const target = parseInt(element.textContent.replace(/,/g, ''));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    }

    // ===== PARALLAX EFFECTS =====
    setupParallaxEffects() {
        const parallaxElements = document.querySelectorAll('.parallax-section');
        
        window.addEventListener('scroll', this.throttle(() => {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const rate = scrolled * -0.5;
                element.style.transform = `translateY(${rate}px)`;
            });
        }, 10));
    }

    // ===== TYPING EFFECT =====
    setupTypingEffect() {
        const typingElements = document.querySelectorAll('.typing-effect');
        
        typingElements.forEach(element => {
            const text = element.textContent;
            element.textContent = '';
            element.style.borderRight = '2px solid #4a90e2';
            
            let i = 0;
            const typeWriter = () => {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                } else {
                    element.style.borderRight = 'none';
                }
            };
            
            // Start typing when element is visible
            const typingObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        typeWriter();
                        typingObserver.unobserve(entry.target);
                    }
                });
            });
            
            typingObserver.observe(element);
        });
    }

    // ===== PARTICLE SYSTEM =====
    setupParticleSystem() {
        const particleContainers = document.querySelectorAll('.particle-container');
        
        particleContainers.forEach(container => {
            this.createParticles(container);
        });
    }

    createParticles(container) {
        const particleCount = 50;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.cssText = `
                position: absolute;
                width: 2px;
                height: 2px;
                background: rgba(74, 144, 226, 0.5);
                border-radius: 50%;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
                animation-delay: ${Math.random() * 2}s;
            `;
            container.appendChild(particle);
        }
    }

    // ===== LOADING STATES =====
    setupLoadingStates() {
        // Add loading states to async operations
        const asyncButtons = document.querySelectorAll('[data-async]');
        
        asyncButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.add('loading');
                button.disabled = true;
                
                // Simulate async operation
                setTimeout(() => {
                    button.classList.remove('loading');
                    button.disabled = false;
                }, 2000);
            });
        });
    }

    // ===== SUCCESS ANIMATIONS =====
    setupSuccessAnimations() {
        // Show success animation for form submissions
        const successMessages = document.querySelectorAll('.alert-success');
        
        successMessages.forEach(message => {
            message.style.animation = 'slideInDown 0.5s ease-out';
            
            // Add checkmark animation
            const checkmark = document.createElement('div');
            checkmark.className = 'success-checkmark';
            checkmark.innerHTML = `
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark__check" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            `;
            message.appendChild(checkmark);
        });
    }

    // ===== HOVER EFFECTS =====
    setupHoverEffects() {
        // Icon hover effects
        const icons = document.querySelectorAll('.icon-animated');
        
        icons.forEach(icon => {
            icon.addEventListener('mouseenter', () => {
                icon.style.transform = 'scale(1.2) rotate(5deg)';
                icon.style.color = '#4a90e2';
            });
            
            icon.addEventListener('mouseleave', () => {
                icon.style.transform = 'scale(1) rotate(0deg)';
                icon.style.color = '';
            });
        });

        // Table row hover effects
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.backgroundColor = 'rgba(74, 144, 226, 0.05)';
                row.style.transform = 'scale(1.01)';
            });
            
            row.addEventListener('mouseleave', () => {
                row.style.backgroundColor = '';
                row.style.transform = 'scale(1)';
            });
        });
    }

    // ===== CLICK EFFECTS =====
    setupClickEffects() {
        // Add click effects to interactive elements
        const clickableElements = document.querySelectorAll('.clickable, .btn, .card');
        
        clickableElements.forEach(element => {
            element.addEventListener('click', (e) => {
                this.createClickEffect(e, element);
            });
        });
    }

    // ===== UTILITY FUNCTIONS =====
    createRippleEffect(event, element) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    createClickEffect(event, element) {
        const effect = document.createElement('div');
        const rect = element.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        
        effect.style.cssText = `
            position: absolute;
            width: 20px;
            height: 20px;
            left: ${x - 10}px;
            top: ${y - 10}px;
            background: radial-gradient(circle, rgba(74, 144, 226, 0.5) 0%, transparent 70%);
            border-radius: 50%;
            transform: scale(0);
            animation: clickEffect 0.3s ease-out;
            pointer-events: none;
            z-index: 1000;
        `;
        
        element.style.position = 'relative';
        element.appendChild(effect);
        
        setTimeout(() => {
            effect.remove();
        }, 300);
    }

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }
}

// ===== ADDITIONAL CSS ANIMATIONS =====
const additionalStyles = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @keyframes clickEffect {
        to {
            transform: scale(3);
            opacity: 0;
        }
    }
    
    .particle {
        pointer-events: none;
    }
    
    .navbar-toggler.active .navbar-toggler-icon {
        transform: rotate(45deg);
    }
    
    .navbar-toggler.active .navbar-toggler-icon::before {
        transform: rotate(90deg);
        top: 0;
    }
    
    .navbar-toggler.active .navbar-toggler-icon::after {
        opacity: 0;
    }
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// ===== INITIALIZE ANIMATIONS =====
document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.HadiyahAnimationsInstance === 'undefined') {
        window.HadiyahAnimationsInstance = new HadiyahAnimations();
    }
});

// ===== EXPORT FOR MODULE USAGE =====
if (typeof module !== 'undefined' && module.exports) {
    module.exports = HadiyahAnimations;
}
