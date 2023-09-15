window.onload = function() {
    var templateSlider = document.getElementById('template-slider');
    var templateSliderInner = templateSlider.querySelector('.template-slider-inner');
    var templateCards = templateSlider.getElementsByClassName('template-card');
    var slideWidth = templateCards[0].offsetWidth;
    var slideIndex = 0;
    var slideInterval = 3000; // Interval slide dalam milidetik (misalnya 3000 = 3 detik)
    var slideTimer;

    function slideLeft() {
        slideIndex--;
        if (slideIndex < 0) {
            slideIndex = templateCards.length - 1;
        }
        templateSliderInner.style.transform = 'translateX(' + (-slideIndex * slideWidth) + 'px)';
    }

    function slideRight() {
        slideIndex++;
        if (slideIndex >= templateCards.length) {
            slideIndex = 0;
        }
        templateSliderInner.style.transform = 'translateX(' + (-slideIndex * slideWidth) + 'px)';
    }

    function startSlideShow() {
        slideTimer = setInterval(function() {
            slideRight();
        }, slideInterval);
    }

    function stopSlideShow() {
        clearInterval(slideTimer);
    }

    document.getElementById('slide-left').addEventListener('click', function() {
        stopSlideShow();
        slideLeft();
    });

    document.getElementById('slide-right').addEventListener('click', function() {
        stopSlideShow();
        slideRight();
    });

    // Tambahkan event listener untuk saat kursor berada di atas slider
    templateSlider.addEventListener('mouseenter', stopSlideShow);
    templateSlider.addEventListener('mouseleave', startSlideShow);

    // Tambahkan event listener untuk saat transisi selesai (infinite)
    templateSliderInner.addEventListener('transitionend', function() {
        if (slideIndex === 0) {
            templateSliderInner.style.transition = 'none'; // Hentikan transisi saat mencapai slide pertama
            slideIndex = templateCards.length - 2;
            templateSliderInner.style.transform = 'translateX(' + (-slideIndex * slideWidth) + 'px)';
            setTimeout(function() {
                templateSliderInner.style.transition = ''; // Setel ulang transisi setelah penyesuaian transformasi
            }, 0);
        } else if (slideIndex === templateCards.length - 1) {
            templateSliderInner.style.transition = 'none'; // Hentikan transisi saat mencapai slide terakhir
            slideIndex = 1;
            templateSliderInner.style.transform = 'translateX(' + (-slideIndex * slideWidth) + 'px)';
            setTimeout(function() {
                templateSliderInner.style.transition = ''; // Setel ulang transisi setelah penyesuaian transformasi
            }, 0);
        }
    });

    startSlideShow();
};