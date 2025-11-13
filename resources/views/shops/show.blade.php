@extends('layouts.app')

@section('title', 'تفاصيل ' . $shop['name'])

@section('content')
<style>
/* Simple styles for menu thumbnails and modal */
.menu-thumbs{display:flex;gap:0.5rem;flex-wrap:wrap}
.menu-thumb-btn{border:0;padding:0;background:transparent;cursor:pointer}
.menu-thumb{width:96px;height:96px;object-fit:cover;border-radius:6px;display:block;border:1px solid #eee}
.menu-modal{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.75);z-index:1200;padding:1rem}
.menu-modal__content{max-width:95%;max-height:95%;position:relative}
.menu-modal__img{max-width:100%;max-height:100%;display:block;border-radius:6px}
.menu-modal__close{position:absolute;top:-10px;right:-10px;background:#fff;border-radius:50%;border:0;padding:6px;cursor:pointer}
</style>
<!-- ← رابط العودة للرئيسية -->
<a href="/" class="back-link">
    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    العودة للرئيسية
</a>

<article class="shop-details">
    <!-- الصورة الرئيسية للمحل -->
    <div class="shop-details__image-container">
        <img src="{{ $shop['image'] }}" alt="صورة مطعم {{ $shop['name'] }}" class="shop-details__image">
    </div>

    <!-- تفاصيل المحل -->
    <div class="shop-details__content">
        <h1 class="shop-details__title">{{ $shop['name'] }}</h1>

        <!-- العنوان الكامل -->
        <div class="shop-details__section">
            <h2 class="shop-details__section-title">📍 العنوان الكامل</h2>
            <p class="shop-details__address">{{ $shop['fullAddress'] }}</p>
        </div>

        <!-- أرقام الدليفري -->
        <div class="shop-details__section">
            <h2 class="shop-details__section-title">📞 أرقام الدليفري</h2>
            <div class="shop-details__delivery-numbers">
                @foreach ($shop['deliveryNumbers'] as $number)
                    <a href="tel:+20{{ substr($number, 1) }}" class="delivery-number">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                        {{ $number }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- صورة المنيو (صور مصغرة قابلة للتكبير) -->
        <div class="shop-details__section">
            <h2 class="shop-details__section-title">🍽️ المنيو</h2>
            <div class="shop-details__menu-container">
                @if(!empty($shop['menuImages']) && is_array($shop['menuImages']))
                    <div class="menu-thumbs">
                        @foreach($shop['menuImages'] as $idx => $m)
                            <button type="button" class="menu-thumb-btn" data-src="{{ $m }}" aria-label="عرض صورة المنيو {{ $idx + 1 }}">
                                <img src="{{ $m }}" alt="منيو {{ $idx + 1 }}" class="menu-thumb">
                            </button>
                        @endforeach
                    </div>
                @else
                    <p>لا يوجد منيو لعرضه حالياً.</p>
                @endif
            </div>
        </div>

        <!-- Modal لعرض الصورة المكبرة -->
        <div id="menu-modal" class="menu-modal" style="display:none" role="dialog" aria-hidden="true">
            <div class="menu-modal__content" role="document">
                <button id="menu-modal-close" class="menu-modal__close" aria-label="إغلاق">✕</button>
                <img id="menu-modal-img" class="menu-modal__img" src="" alt="صورة المنيو">
            </div>
        </div>

    {{-- زرار العودة للأعلى --}}
    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى" title="العودة للأعلى">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

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

        (function(){
            const modal = document.getElementById('menu-modal');
                const modalImg = document.getElementById('menu-modal-img');
                const closeBtn = document.getElementById('menu-modal-close');

                function openModal(src){
                    modalImg.src = src;
                    modal.style.display = 'flex';
                    modal.setAttribute('aria-hidden','false');
                    // focus close for accessibility
                    closeBtn.focus();
                }
                function closeModal(){
                    modal.style.display = 'none';
                    modal.setAttribute('aria-hidden','true');
                    modalImg.src = '';
                }

                document.querySelectorAll('.menu-thumb-btn').forEach(btn=>{
                    btn.addEventListener('click', function(){
                        const src = this.getAttribute('data-src');
                        if(src) openModal(src);
                    });
                });

                closeBtn.addEventListener('click', closeModal);
                modal.addEventListener('click', function(e){
                    if(e.target === modal) closeModal();
                });
                document.addEventListener('keydown', function(e){
                    if(e.key === 'Escape' && modal.style.display === 'flex') closeModal();
                });
            })();
        </script>
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
        © {{ date('Y') }} كل الحقوق محفوظة — <strong>قرمشة</strong>.
    </p>
</footer>
@endsection
