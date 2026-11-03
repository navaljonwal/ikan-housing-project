/**
 * ============================================================================
 * I KAN HOUSING - MODERN ANIMATION ENGINE & INTERACTION SCRIPTS
 * Features:
 *  - Scroll Progress Bar
 *  - Number / Statistics Counting Animation (Counter-Up via IntersectionObserver)
 *  - Interactive Back-To-Top Button with Smooth Scroll
 *  - AOS Settings Optimization
 *  - Card Shine / Interactive Micro-Interactions
 * ============================================================================
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        initScrollProgress();
        initStatsCounter();
        initBackToTop();
        initCardEnhancements();
    });

    /**
     * 1. Dynamic Scroll Progress Bar
     */
    function initScrollProgress() {
        let progressBar = document.getElementById('ikan-scroll-progress');
        if (!progressBar) {
            progressBar = document.createElement('div');
            progressBar.id = 'ikan-scroll-progress';
            document.body.prepend(progressBar);
        }

        let ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                    const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                    progressBar.style.width = scrollPercent + '%';
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

    /**
     * 2. Number Counter-Up Animation
     * Automatically counts numbers up when scrolled into view
     */
    function initStatsCounter() {
        // Collect candidates: .stat-number, elements with data-counter, or specific stats headings
        const counterSelectors = [
            '.stat-number',
            '.stats-number',
            '[data-counter]',
            '.experience-stat-number'
        ];

        const targets = document.querySelectorAll(counterSelectors.join(','));
        if (!targets.length) return;

        const observerOptions = {
            threshold: 0.3
        };

        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumber(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        targets.forEach(el => counterObserver.observe(el));

        function animateNumber(element) {
            const rawText = element.textContent.trim();
            // Parse numeric part and prefix/suffix (e.g. "14+", "5000+", "15+")
            const match = rawText.match(/^([^\d]*)(\d+[\d,.]*)([^\d]*)$/);
            if (!match) return;

            const prefix = match[1] || '';
            const numStr = match[2].replace(/,/g, '');
            const suffix = match[3] || '';
            const targetNumber = parseFloat(numStr);

            if (isNaN(targetNumber)) return;

            const duration = 1800; // ms
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Ease out cubic
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const currentVal = Math.floor(easeOut * targetNumber);

                element.textContent = prefix + currentVal.toLocaleString() + suffix;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = rawText; // Ensure exact final representation
                }
            }

            requestAnimationFrame(updateCounter);
        }
    }

    /**
     * 3. Back-To-Top Button
     */
    function initBackToTop() {
        let btn = document.getElementById('ikan-back-to-top');
        if (!btn) {
            btn = document.createElement('button');
            btn.id = 'ikan-back-to-top';
            btn.setAttribute('aria-label', 'Back to top');
            btn.innerHTML = '<i class="fa fa-chevron-up"></i>';
            document.body.appendChild(btn);
        }

        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 400) {
                btn.classList.add('show');
            } else {
                btn.classList.remove('show');
            }
        }, { passive: true });

        btn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * 4. Card Micro-Interactions (Dynamic hover shine effect)
     */
    function initCardEnhancements() {
        const cards = document.querySelectorAll('.property-card-minimal, .service-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.willChange = 'transform, box-shadow';
            });
            card.addEventListener('mouseleave', function () {
                this.style.willChange = 'auto';
            });
        });
    }
})();
