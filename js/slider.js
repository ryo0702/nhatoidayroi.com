// ヒーロースライダーのJavaScript
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 0;
    let slideInterval;

    // スライドの切り替え関数
    function showSlide(index) {
        // すべてのスライドを非表示
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // 指定されたスライドを表示
        if (slides[index]) {
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }
    }

    // 次のスライドに移動
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // 自動スライド開始
    function startSlideShow() {
        slideInterval = setInterval(nextSlide, 5000); // 5秒間隔
    }

    // 自動スライド停止
    function stopSlideShow() {
        clearInterval(slideInterval);
    }

    // ドットクリックイベント
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            currentSlide = index;
            showSlide(currentSlide);
            stopSlideShow();
            startSlideShow(); // 再開
        });
    });

    // スライダーホバー時の一時停止
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopSlideShow);
        sliderContainer.addEventListener('mouseleave', startSlideShow);
    }

    // スライドが存在する場合のみ自動スライドを開始
    if (slides.length > 0) {
        startSlideShow();
    }
});
