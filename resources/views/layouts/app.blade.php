<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Qaramasha')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- ملف CSS الرئيسي --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="page-wrapper">
        @yield('content')
    </div>

    {{-- زرار العودة للأعلى --}}
    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى" title="العودة للأعلى">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    {{-- ملف JavaScript --}}
    <script src="{{ asset('js/filter.js') }}"></script>

    <script>
        // زرار العودة للأعلى - يظهر ويختفي بانسيابية
        (function() {
            const backToTopBtn = document.getElementById('backToTop');
            const scrollThreshold = 300; // يظهر بعد scroll 300px

            function toggleBackToTop() {
                if (window.pageYOffset > scrollThreshold) {
                    backToTopBtn.classList.add('visible');
                } else {
                    backToTopBtn.classList.remove('visible');
                }
            }

            // تحقق من موضع التمرير
            window.addEventListener('scroll', toggleBackToTop);
            
            // تحقق عند تحميل الصفحة
            toggleBackToTop();

            // وظيفة العودة للأعلى بانسيابية
            backToTopBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        })();

        // معرض الصور
        const gallery = document.getElementById('gallery-scroll');
        
        if (gallery) {
            // نكرر الصور عشان نعمل loop لا نهائي
            const originalHTML = gallery.innerHTML;
            gallery.innerHTML = originalHTML + originalHTML + originalHTML + originalHTML + originalHTML + originalHTML
                + originalHTML + originalHTML + originalHTML + originalHTML + originalHTML
                + originalHTML + originalHTML + originalHTML + originalHTML + originalHTML;

            let scrollSpeed = -1.5; // السرعة
            let autoScrollInterval;
            let isUserScrolling = false;
            let scrollTimeout;

            function startAutoScroll() {
                // لو المستخدم بيسكرول يدوياً، ما نبدأش
                if (autoScrollInterval || isUserScrolling) return;
                
                autoScrollInterval = setInterval(() => {
                    if (!isUserScrolling && gallery) {
                        gallery.scrollLeft += scrollSpeed;
                        if (gallery.scrollLeft >= gallery.scrollWidth / 2) {
                            gallery.scrollLeft = 0;
                        }
                    }
                }, 15);
            }

            function stopAutoScroll() {
                if (autoScrollInterval) {
                    clearInterval(autoScrollInterval);
                    autoScrollInterval = null;
                }
            }

            function handleUserInteraction() {
                isUserScrolling = true;
                stopAutoScroll();
                
                // نخلي timeout علشان نرجع نبدأ الـ auto-scroll بعد ما المستخدم يخلص
                clearTimeout(scrollTimeout);
            }

            function handleUserInteractionEnd() {
                // بعد 3 ثواني من آخر تفاعل، نرجع نبدأ الـ auto-scroll
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    isUserScrolling = false;
                    startAutoScroll();
                }, 3000);
            }

            // نتحقق من نوع الجهاز
            const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
            const isMobile = window.innerWidth <= 768;

            // على الموبايل: نوقف لما المستخدم يلمس
            if (isTouchDevice || isMobile) {
                gallery.addEventListener('touchstart', handleUserInteraction, { passive: true });
                gallery.addEventListener('touchmove', handleUserInteraction, { passive: true });
                gallery.addEventListener('touchend', handleUserInteractionEnd, { passive: true });
            } else {
                // على الديسكتوب بس: نوقف لما الماوس يدخل
                gallery.addEventListener('mouseenter', stopAutoScroll);
                gallery.addEventListener('mouseleave', () => {
                    if (!isUserScrolling) {
                        startAutoScroll();
                    }
                });
            }

            // نتتبع أي scroll يدوي (على جميع الأجهزة)
            let scrollTimeout2;
            gallery.addEventListener('scroll', () => {
                // نتحقق إذا كان الـ scroll من المستخدم ولا من الـ auto-scroll
                // لو الـ scroll حصل بس المستخدم مش بيسكرول (يعني من auto-scroll)
                // ما نوقفش
                if (!isUserScrolling) {
                    // ده auto-scroll، ما نعملش حاجة
                    return;
                }
                
                clearTimeout(scrollTimeout2);
                scrollTimeout2 = setTimeout(handleUserInteractionEnd, 150);
            }, { passive: true });

            // نبدأ الـ auto-scroll على جميع الأجهزة
            startAutoScroll();
        }
    </script>



</body>
</html>
