<?php
/**
 * Build Static Site Script
 * يحول Laravel application لـ static HTML للاستضافة على GitHub Pages
 */

// بيانات المحلات (من ShopController)
$shops = [
    'Sultan_marg' => [
        'name' => 'كشري السلطان',
        'fullAddress' => 'المرج - فرع الشارع الجديد الشرفا ',
        'shortAddress' => 'المرج فرع الشارع الجديد الشرفا',
        'slug' => 'Sultan_marg',
        'image' => 'images/Sultan_marg/Sul_marg1.jpg',
        'menuImages' => [
            'images/Sultan_marg/Sul_marg4.jpg',
            'images/Sultan_marg/Sul_marg5.jpg',
        ],
        'deliveryNumbers' => ['01069113030', '01120205827','01144594460'],
    ],
    'Sul_alarb3en' => [
        'name' => 'كشري السلطان',
        'fullAddress' => ' شارع الترول سيجال متفرع من شارع الأربعين - خلف حديقة بدر',
        'shortAddress' => 'فرع ش الأربعين - سيجال',
        'slug' => 'Sul_alarb3en',
        'image' => 'images/Sultan_Alarb3en/Sul1.jpg',
        'menuImages' => [
            'images/Sultan_Alarb3en/Sul_menu.jpg',
        ],
        'deliveryNumbers' => ['01125169998', '01125193332','01101143687','01022001264','0221859512','01272927710'],
    ],
    'Especo' => [
        'name' => 'كشري السلطان',
        'fullAddress' => 'اسبيكو ',
        'shortAddress' => 'فرع اسبيكو',
        'slug' => 'Especo',
        'image' => 'images/Especo/Sul1.jpg',
        'menuImages' => [
            'images/Especo/Sul_menu.jpg',
        ],
        'deliveryNumbers' => ['01117501313', '01278535226','01026277130','22787666'],
    ],
    'Alorsha' => [
        'name' => 'كشري السلطان',
        'fullAddress' => 'المرج - فرع شارع الورشة ',
        'shortAddress' => 'فرع شارع الورشة المرج',
        'slug' => 'Alorsha',
        'image' => 'images/Alorsha/Sul1.jpg',
        'menuImages' => [
            'images/Alorsha/Sul_menu1.jpg',
            'images/Alorsha/Sul_menu2.jpg',
        ],
        'deliveryNumbers' => ['01030881563', '01501229290','01067060709','01112993924','01112111081'],
    ],
];

// إنشاء مجلد docs (GitHub Pages يستخدم docs أو root)
$outputDir = __DIR__ . '/docs';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

// إنشاء مجلد shops للصفحات الفرعية
if (!is_dir($outputDir . '/shops')) {
    mkdir($outputDir . '/shops', 0755, true);
}

// إنشاء مجلد js
if (!is_dir($outputDir . '/js')) {
    mkdir($outputDir . '/js', 0755, true);
}

// إنشاء ملف JavaScript بالبيانات
$shopsJs = 'const shopsData = ' . json_encode($shops, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . ';';
file_put_contents($outputDir . '/js/shops-data.js', $shopsJs);

// إنشاء صفحة index.html
$indexHtml = generateIndexHtml($shops);
file_put_contents($outputDir . '/index.html', $indexHtml);

// إنشاء صفحات تفاصيل المحلات
foreach ($shops as $slug => $shop) {
    $shopHtml = generateShopHtml($shop);
    file_put_contents($outputDir . '/shops/' . $slug . '.html', $shopHtml);
}

// نسخ الملفات الثابتة
copyDir(__DIR__ . '/public/images', $outputDir . '/images');
copyDir(__DIR__ . '/public/css', $outputDir . '/css');
copyFile(__DIR__ . '/public/js/filter.js', $outputDir . '/js/filter.js');
copyFile(__DIR__ . '/public/favicon.ico', $outputDir . '/favicon.ico');
copyFile(__DIR__ . '/public/robots.txt', $outputDir . '/robots.txt');

echo "✅ تم بناء الموقع بنجاح في مجلد docs/\n";
echo "📁 الملفات جاهزة للرفع على GitHub Pages\n";

function generateIndexHtml($shops) {
    $shopsList = '';
    foreach ($shops as $shop) {
        $shopsList .= '
        <article class="shop-card" data-shop-card data-shop-name="' . mb_strtolower($shop['name']) . '">
            <img src="' . $shop['image'] . '" alt="صورة تظهر أجواء مطعم ' . htmlspecialchars($shop['name']) . '" class="shop-card__image" loading="lazy">
            <div class="shop-card__body">
                <h2 class="shop-card__title">' . htmlspecialchars($shop['name']) . '</h2>
                <p class="shop-card__address">' . htmlspecialchars($shop['shortAddress']) . '</p>
                <a href="shops/' . $shop['slug'] . '.html" class="shop-card__cta" aria-label="عرض تفاصيل مطعم ' . htmlspecialchars($shop['name']) . '">
                    عرض التفاصيل
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5 5L7.5 10L12.5 15" stroke="currentColor" stroke-width="1.8"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </article>';
    }

    return '<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Qaramasha - دليل كشري مصر</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="page-wrapper">
        <header class="hero" id="top">
            <span class="hero__eyebrow">دليل كشري مصر</span>
            <h1 class="hero__title">اكتشف أشهر محلات الكشري عندها توست قرمشة في القاهرة وضواحيها</h1>
            <p class="hero__subtitle">
                لكل عاشق للكشري الأصلي، جمعنالك المحلات اللي بتقدّم تجربة مختلفة مع قرمشه…<br>
                طعْم مصري أصيل بلمسة جديدة تخلي كل لقمة مليانة نكهة، حرارة، وقرمشة لا تقاوم 🔥
            </p>

            <section class="scroll-gallery" aria-label="معرض صور قرمشة">
                <div class="scroll-gallery__container" id="gallery-scroll">
                    <div class="scroll-gallery__item"><img src="images/Toast1.jpg" alt="توست قرمشة"></div>
                    <div class="scroll-gallery__item"><img src="images/Toast2.jpg" alt="كشري بقرمشة"></div>
                    <div class="scroll-gallery__item"><img src="images/Toast3.jpg" alt="وجبة كشري"></div>
                    <div class="scroll-gallery__item"><img src="images/Toast4.jpg" alt="تغليف المنتج"></div>
                    <div class="scroll-gallery__item"><img src="images/Toast5.jpg" alt="محل قرمشة"></div>
                    <div class="scroll-gallery__item"><img src="images/Toast6.jpg" alt="محل قرمشة"></div>
                    <div class="scroll-gallery__item"><img src="images/Toast7.jpg" alt="محل قرمشة"></div>
                    <div class="scroll-gallery__item"><img src="images/Toast8.jpg" alt="محل قرمشة"></div>
                </div>
            </section>

            <div class="insight-banner">
                <span>📍</span>
                <span>مواقع دقيقة وعناوين سهلة — خلّي مشوار الكشري أقرب مما تتخيل</span>
            </div>

            <div class="hero__search">
                <input type="search" placeholder="دور على مطعمك المفضل..." aria-label="ابحث باسم محل الكشري" data-filter="shops">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z"
                          stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </header>

        <main class="shop-grid" aria-label="قائمة محلات الكشري">
' . $shopsList . '
        </main>

        <p class="insight-banner" data-empty-state hidden style="display: none;">
            😔 للأسف مفيش نتائج بالاسم ده حالياً. جرّب تهجئة مختلفة أو اسم مختصر.
        </p>

        <footer class="site-footer">
            <div>
                <p class="site-footer__brand">قرمشة</p>
                <p class="site-footer__text">
                    الكشري من غير قرمشة؟ زي السينما من غير فشار😅
                    اكتشف أحسن محلات الكشري اللي بتقدملك التجربة الكاملة — رز، صلصة، دقة، وقرمشة تفتح النفس من أول لقمة 🔥✨
                </p>
            </div>

            <div class="site-footer__contacts">
                <p class="site-footer__text">
                    🔝 <a href="#top">العودة للأعلى</a><br>
                    🌐 <a href="https://www.facebook.com/share/17nZYHi8qd/" target="_blank" rel="noopener">
                        صفحتنا على فيسبوك
                    </a><br>
                    📞 <strong>الإدارة:</strong> <a href="tel:201112615606">01112615606</a><br>
                    ☎️ <strong>خدمة العملاء:</strong> <a href="tel:201107742345">01107742345</a>
                </p>
            </div>

            <div class="site-footer__copyright">
                
                <span class="site-footer__copyright-right">
                    👨‍💻 تم التطوير بواسطة <strong>M2A For Software Solutions</strong><br>
                    📱 <a href="tel:201125400593">01125400593</a>
                | 💬 <a href="https://wa.me/201125400593" target="_blank">واتساب</a>
                </span>
                <span class="site-footer__copyright-left">
                    © ' . date('Y') . ' كل الحقوق محفوظة — <strong>قرمشة</strong>.
                </span>
                
            </div>
        </footer>
    </div>

    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى" title="العودة للأعلى">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <script src="js/filter.js"></script>
    <script>
        // زرار العودة للأعلى - يظهر ويختفي بانسيابية
        (function() {
            const backToTopBtn = document.getElementById("backToTop");
            const scrollThreshold = 300; // يظهر بعد scroll 300px

            function toggleBackToTop() {
                if (window.pageYOffset > scrollThreshold) {
                    backToTopBtn.classList.add("visible");
                } else {
                    backToTopBtn.classList.remove("visible");
                }
            }

            // تحقق من موضع التمرير
            window.addEventListener("scroll", toggleBackToTop);
            
            // تحقق عند تحميل الصفحة
            toggleBackToTop();

            // وظيفة العودة للأعلى بانسيابية
            backToTopBtn.addEventListener("click", function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        })();

        const gallery = document.getElementById("gallery-scroll");
        
        if (gallery) {
            const originalHTML = gallery.innerHTML;
            gallery.innerHTML = originalHTML + originalHTML + originalHTML + originalHTML + originalHTML + originalHTML
                + originalHTML + originalHTML + originalHTML + originalHTML + originalHTML
                + originalHTML + originalHTML + originalHTML + originalHTML + originalHTML;

            let scrollSpeed = -1.5;
            let autoScrollInterval;
            let isUserScrolling = false;
            let scrollTimeout;

            function startAutoScroll() {
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
                clearTimeout(scrollTimeout);
            }

            function handleUserInteractionEnd() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    isUserScrolling = false;
                    startAutoScroll();
                }, 3000);
            }

            // نتحقق من نوع الجهاز
            const isTouchDevice = "ontouchstart" in window || navigator.maxTouchPoints > 0;
            const isMobile = window.innerWidth <= 768;

            // على الموبايل: نوقف لما المستخدم يلمس
            if (isTouchDevice || isMobile) {
                gallery.addEventListener("touchstart", handleUserInteraction, { passive: true });
                gallery.addEventListener("touchmove", handleUserInteraction, { passive: true });
                gallery.addEventListener("touchend", handleUserInteractionEnd, { passive: true });
            } else {
                // على الديسكتوب بس: نوقف لما الماوس يدخل
                gallery.addEventListener("mouseenter", stopAutoScroll);
                gallery.addEventListener("mouseleave", () => {
                    if (!isUserScrolling) {
                        startAutoScroll();
                    }
                });
            }

            // نتتبع أي scroll يدوي (على جميع الأجهزة)
            let scrollTimeout2;
            gallery.addEventListener("scroll", () => {
                if (!isUserScrolling) {
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
</html>';
}

function generateShopHtml($shop) {
    $menuImagesHtml = '';
    if (!empty($shop['menuImages']) && is_array($shop['menuImages'])) {
        $menuImagesHtml = '<div class="menu-thumbs">';
        foreach ($shop['menuImages'] as $idx => $menuImg) {
            $menuImagesHtml .= '
            <button type="button" class="menu-thumb-btn" data-src="' . '../' . $menuImg . '" aria-label="عرض صورة المنيو ' . ($idx + 1) . '">
                <img src="' . '../' . $menuImg . '" alt="منيو ' . ($idx + 1) . '" class="menu-thumb">
            </button>';
        }
        $menuImagesHtml .= '</div>';
    }

    $deliveryNumbersHtml = '';
    foreach ($shop['deliveryNumbers'] as $number) {
        $cleanNumber = substr($number, 1); // Remove leading 0
        $deliveryNumbersHtml .= '
                    <a href="tel:+20' . $cleanNumber . '" class="delivery-number">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                        ' . $number . '
                    </a>';
    }

    return '<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تفاصيل ' . htmlspecialchars($shop['name']) . '</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .menu-thumbs{display:flex;gap:0.5rem;flex-wrap:wrap}
        .menu-thumb-btn{border:0;padding:0;background:transparent;cursor:pointer}
        .menu-thumb{width:96px;height:96px;object-fit:cover;border-radius:6px;display:block;border:1px solid #eee}
        .menu-modal{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.75);z-index:1200;padding:1rem}
        .menu-modal__content{max-width:95%;max-height:95%;position:relative}
        .menu-modal__img{max-width:100%;max-height:100%;display:block;border-radius:6px}
        .menu-modal__close{position:absolute;top:-10px;right:-10px;background:#fff;border-radius:50%;border:0;padding:6px;cursor:pointer}
    </style>
</head>
<body>
    <div class="page-wrapper">
        <a href="../index.html" class="back-link">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            العودة للرئيسية
        </a>

        <article class="shop-details">
            <div class="shop-details__image-container">
                <img src="../' . $shop['image'] . '" alt="صورة مطعم ' . htmlspecialchars($shop['name']) . '" class="shop-details__image">
            </div>

            <div class="shop-details__content">
                <h1 class="shop-details__title">' . htmlspecialchars($shop['name']) . '</h1>

                <div class="shop-details__section">
                    <h2 class="shop-details__section-title">📍 العنوان الكامل</h2>
                    <p class="shop-details__address">' . htmlspecialchars($shop['fullAddress']) . '</p>
                </div>

                <div class="shop-details__section">
                    <h2 class="shop-details__section-title">📞 أرقام الدليفري</h2>
                    <div class="shop-details__delivery-numbers">
' . $deliveryNumbersHtml . '
                    </div>
                </div>

                <div class="shop-details__section">
                    <h2 class="shop-details__section-title">🍽️ المنيو</h2>
                    <div class="shop-details__menu-container">
' . ($menuImagesHtml ?: '<p>لا يوجد منيو لعرضه حالياً.</p>') . '
                    </div>
                </div>

                <div id="menu-modal" class="menu-modal" style="display:none" role="dialog" aria-hidden="true">
                    <div class="menu-modal__content" role="document">
                        <button id="menu-modal-close" class="menu-modal__close" aria-label="إغلاق">✕</button>
                        <img id="menu-modal-img" class="menu-modal__img" src="" alt="صورة المنيو">
                    </div>
                </div>
            </div>
        </article>

        <footer class="site-footer">
            <div>
                <p class="site-footer__brand">قرمشة</p>
                <p class="site-footer__text">
                    الكشري من غير قرمشة؟ زي السينما من غير فشار 😅<br>
                    اكتشف أحسن محلات الكشري اللي بتقدملك التجربة الكاملة — رز، صلصة، دقة، وقرمشة تفتح النفس من أول لقمة 🔥✨
                </p>
            </div>

            <div class="site-footer__contacts">
                <p class="site-footer__text">
                    🔝 <a href="#top">العودة للأعلى</a><br>
                    🌐 <a href="https://www.facebook.com/share/17nZYHi8qd/" target="_blank" rel="noopener">
                        صفحتنا على فيسبوك
                    </a><br>
                    📞 <strong>الإدارة:</strong> <a href="tel:201112615606">01112615606</a><br>
                    ☎️ <strong>خدمة العملاء:</strong> <a href="tel:201107742345">01107742345</a>
                </p>
            </div>

            <p class="site-footer__copyright">
                © ' . date('Y') . ' كل الحقوق محفوظة — <strong>قرمشة</strong>.
                📱 <a href="tel:201125400593">01125400593</a>
                | 💬 <a href="https://wa.me/201125400593" target="_blank">واتساب</a>
            </p>
        </footer>
    </div>

    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى" title="العودة للأعلى">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <script>
        // زرار العودة للأعلى - يظهر ويختفي بانسيابية
        (function() {
            const backToTopBtn = document.getElementById("backToTop");
            const scrollThreshold = 300; // يظهر بعد scroll 300px

            function toggleBackToTop() {
                if (window.pageYOffset > scrollThreshold) {
                    backToTopBtn.classList.add("visible");
                } else {
                    backToTopBtn.classList.remove("visible");
                }
            }

            // تحقق من موضع التمرير
            window.addEventListener("scroll", toggleBackToTop);
            
            // تحقق عند تحميل الصفحة
            toggleBackToTop();

            // وظيفة العودة للأعلى بانسيابية
            backToTopBtn.addEventListener("click", function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        })();

        (function(){
            const modal = document.getElementById("menu-modal");
            const modalImg = document.getElementById("menu-modal-img");
            const closeBtn = document.getElementById("menu-modal-close");

            function openModal(src){
                modalImg.src = src;
                modal.style.display = "flex";
                modal.setAttribute("aria-hidden","false");
                closeBtn.focus();
            }
            function closeModal(){
                modal.style.display = "none";
                modal.setAttribute("aria-hidden","true");
                modalImg.src = "";
            }

            document.querySelectorAll(".menu-thumb-btn").forEach(btn=>{
                btn.addEventListener("click", function(){
                    const src = this.getAttribute("data-src");
                    if(src) openModal(src);
                });
            });

            closeBtn.addEventListener("click", closeModal);
            modal.addEventListener("click", function(e){
                if(e.target === modal) closeModal();
            });
            document.addEventListener("keydown", function(e){
                if(e.key === "Escape" && modal.style.display === "flex") closeModal();
            });
        })();
    </script>
</body>
</html>';
}

function copyDir($src, $dst) {
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            if (is_dir($srcFile)) {
                copyDir($srcFile, $dstFile);
            } else {
                copy($srcFile, $dstFile);
            }
        }
    }
    closedir($dir);
}

function copyFile($src, $dst) {
    if (file_exists($src)) {
        $dir = dirname($dst);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        copy($src, $dst);
    }
}
