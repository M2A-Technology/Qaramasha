@extends('layouts.app')

@section('title', 'Qaramasha - دليل كشري مصر')

@section('content')
<header class="hero" id="top">
    <span class="hero__eyebrow">دليل كشري مصر</span>
    <h1 class="hero__title">اكتشف أشهر محلات الكشري عندها توست قرمشة في القاهرة وضواحيها</h1>
    <p class="hero__subtitle">
        لكل عاشق للكشري الأصلي، جمعنالك المحلات اللي بتقدّم تجربة مختلفة مع قرمشه…<br>
        طعْم مصري أصيل بلمسة جديدة تخلي كل لقمة مليانة نكهة، حرارة، وقرمشة لا تقاوم 🔥
    </p>

    <section class="scroll-gallery" aria-label="معرض صور قرمشة">
        <div class="scroll-gallery__container" id="gallery-scroll">
            <div class="scroll-gallery__item"><img src="/images/Toast1.jpg" alt="توست قرمشة"></div>
            <div class="scroll-gallery__item"><img src="/images/Toast2.jpg" alt="كشري بقرمشة"></div>
            <div class="scroll-gallery__item"><img src="/images/Toast3.jpg" alt="وجبة كشري"></div>
            <div class="scroll-gallery__item"><img src="/images/Toast4.jpg" alt="تغليف المنتج"></div>
            <div class="scroll-gallery__item"><img src="/images/Toast5.jpg" alt="محل قرمشة"></div>
            <div class="scroll-gallery__item"><img src="/images/Toast6.jpg" alt="محل قرمشة"></div>
            <div class="scroll-gallery__item"><img src="/images/Toast7.jpg" alt="محل قرمشة"></div>
            <div class="scroll-gallery__item"><img src="/images/Toast8.jpg" alt="محل قرمشة"></div>
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
    @foreach ($shops as $shop)
        <article class="shop-card" data-shop-card data-shop-name="{{ mb_strtolower($shop['name']) }}">
            <img src="{{ $shop['image'] }}" alt="صورة تظهر أجواء مطعم {{ $shop['name'] }}" class="shop-card__image" loading="lazy">
            <div class="shop-card__body">
                <h2 class="shop-card__title">{{ $shop['name'] }}</h2>
                @isset($shop['owner'])
                @endisset
                <p class="shop-card__address">{{ $shop['address'] }}</p>
                <a href="{{ url('/shops/' . $shop['slug']) }}" class="shop-card__cta" aria-label="عرض تفاصيل مطعم {{ $shop['name'] }}">
                    عرض التفاصيل
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5 5L7.5 10L12.5 15" stroke="currentColor" stroke-width="1.8"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </article>
    @endforeach
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
        {{-- <p class="site-footer__developer">
             Developer
            <strong>Amr Ebrahim</strong> 👨‍💻—
            📱 <a href="tel:201125400593">01125400593</a>
            | 💬 <a href="https://wa.me/201125400593" target="_blank">WhatsApp</a>
        </p> --}}
    </div>




    <div class="site-footer__copyright">
        
        <span class="site-footer__copyright-right">
            👨‍💻 تم التطوير بواسطة <strong>M2A For Software Solutions</strong><br>
            📱 <a href="tel:201125400593">01125400593</a>
        | 💬 <a href="https://wa.me/201125400593" target="_blank">واتساب</a>
        </span>
        <span class="site-footer__copyright-left">
            © {{ date('Y') }} كل الحقوق محفوظة — <strong>قرمشة</strong>.
        </span>
        
    </div>
</footer>

@endsection
