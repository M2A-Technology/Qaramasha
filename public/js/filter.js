document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('[data-filter="shops"]');
    if (!searchInput) return;

    const cards = Array.from(document.querySelectorAll('[data-shop-card]'));
    const emptyState = document.querySelector('[data-empty-state]');

    // نخفي الرسالة من الأول
    if (emptyState) {
        emptyState.hidden = true;
        emptyState.style.display = 'none';
    }

    const toggleEmptyState = (searchTerm) => {
        if (!emptyState) return;
        
        // الرسالة تظهر بس لما:
        // 1. المستخدم كتب حاجة (searchTerm.length > 0)
        // 2. ومفيش نتائج ظاهرة
        const hasVisible = cards.some((card) => card.style.display !== 'none');
        
        if (searchTerm.length > 0 && !hasVisible) {
            // تظهر الرسالة
            emptyState.hidden = false;
            emptyState.style.display = '';
        } else {
            // تخفي الرسالة
            emptyState.hidden = true;
            emptyState.style.display = 'none';
        }
    };

    searchInput.addEventListener('input', function () {
        const term = this.value.trim().toLowerCase();

        cards.forEach((card) => {
            const name = card.getAttribute('data-shop-name') || '';
            const match = name.includes(term);
            card.style.display = match ? '' : 'none';
        });

        toggleEmptyState(term);
    });
});
