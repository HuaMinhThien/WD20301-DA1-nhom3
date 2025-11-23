const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');

let currentSlide = 0;
const totalSlides = slides.length;

// Hiển thị slide theo index
function showSlide(index) {
    // Ẩn tất cả slides
    slides.forEach(slide => {
        slide.style.display = 'none';
        slide.classList.remove('active');
    });
    
    // Ẩn tất cả dots
    dots.forEach(dot => {
        dot.classList.remove('active');
    });

    // Hiển thị slide hiện tại
    slides[index].style.display = 'block';
    slides[index].classList.add('active');
    
    // Kích hoạt dot tương ứng
    if (dots[index]) {
        dots[index].classList.add('active');
    }
}

// Next slide
function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

// Prev slide
function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

// Sự kiện nút
if (next) {
    next.addEventListener('click', nextSlide);
}

if (prev) {
    prev.addEventListener('click', prevSlide);
}

// Sự kiện dot
dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
        currentSlide = i;
        showSlide(currentSlide);
    });
});

// Tự động chạy (mỗi 5 giây)
let autoPlay = setInterval(nextSlide, 5000);

// Dừng tự động khi hover
const bannerContainer = document.querySelector('.main-container-banner');
if (bannerContainer) {
    bannerContainer.addEventListener('mouseenter', () => {
        clearInterval(autoPlay);
    });

    bannerContainer.addEventListener('mouseleave', () => {
        autoPlay = setInterval(nextSlide, 5000);
    });
}

// Khởi tạo slider khi trang load
document.addEventListener('DOMContentLoaded', function() {
    showSlide(currentSlide);
});