
(function ($) {
  "use strict";

  // NAVBAR
  $(".navbar").headroom();

  // Close mobile menu when clicking on a link
  $('.navbar-nav>li>a').on('click', function () {
    $('.navbar-collapse').collapse('hide');
  });

  // Initialize Slick sliders
  if ($('.slick-slideshow').length) {
    $('.slick-slideshow').slick({
      autoplay: true,
      infinite: true,
      arrows: false,
      fade: true,
      dots: true,
      autoplaySpeed: 5000,
      pauseOnHover: false
    });
  }

  if ($('.slick-testimonial').length) {
    $('.slick-testimonial').slick({
      autoplay: true,
      infinite: true,
      arrows: true,
      dots: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      prevArrow: '<button type="button" class="slick-prev"><i class="ri-arrow-left-s-line"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="ri-arrow-right-s-line"></i></button>',
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false
          }
        }
      ]
    });
  }

  // Smooth scrolling for anchor links
  $('a[href*="#"]').on('click', function (e) {
    if (this.hash !== '') {
      e.preventDefault();

      const hash = this.hash;
      $('html, body').animate(
        {
          scrollTop: $(hash).offset().top - 80
        },
        800,
        'easeInOutQuad'
      );
    }
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });

  $('.back-to-top').click(function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, 800, 'easeInOutExpo');
    return false;
  });

  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Add animation to elements when they come into view
  function animateOnScroll() {
    $('.animate-on-scroll').each(function () {
      var position = $(this).offset().top;
      var scroll = $(window).scrollTop();
      var windowHeight = $(window).height();

      if (scroll + windowHeight > position + 100) {
        $(this).addClass('animate');
      }
    });
  }

  // Run animation on load and scroll
  $(window).on('load scroll', animateOnScroll);

  // Initialize AOS with custom settings
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }

  // Add active class to nav links on scroll
  $(window).scroll(function () {
    var scrollDistance = $(window).scrollTop();

    $('section').each(function (i) {
      if ($(this).position().top <= scrollDistance + 100) {
        $('.navbar-nav .nav-link.active').removeClass('active');
        $('.navbar-nav .nav-link').eq(i).addClass('active');
      }
    });
  });

  // Initialize VanillaTilt for 3D tilt effect
  if (typeof VanillaTilt !== 'undefined') {
    VanillaTilt.init(document.querySelectorAll(".product-card"), {
      max: 10,
      speed: 400,
      glare: true,
      'max-glare': 0.2,
      scale: 1.02
    });
  }

  // Add ripple effect to buttons
  $('.btn, .nav-link').on('click', function (e) {
    var $this = $(this);
    var $ripple = $("<span class='ripple-effect'></span>");

    // Remove any old ripple effects
    $this.find('.ripple-effect').remove();

    // Get click position relative to the button
    var pos = $this.offset();
    var relativeX = e.pageX - pos.left;
    var relativeY = e.pageY - pos.top;

    // Set ripple position
    $ripple.css({
      left: relativeX + 'px',
      top: relativeY + 'px'
    });

    // Add ripple to button
    $this.append($ripple);

    // Remove ripple after animation completes
    setTimeout(function () {
      $ripple.remove();
    }, 1000);
  });

  // Initialize Splide carousel if it exists
  if (typeof Splide !== 'undefined') {
    new Splide('.splide', {
      type: 'loop',
      perPage: 1,
      autoplay: true,
      interval: 5000,
      pauseOnHover: true,
      pauseOnFocus: false,
      speed: 1000,
      arrows: true,
      pagination: true,
      breakpoints: {
        768: {
          perPage: 1,
        },
        1024: {
          perPage: 2,
        },
        1200: {
          perPage: 3,
        },
      },
    }).mount();
  }

  // Lazy load images
  if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
      img.src = img.dataset.src;
    });
  } else {
    // Fallback for browsers that don't support lazy loading
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
    document.body.appendChild(script);
  }

  // Add smooth scroll behavior
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();

      const targetId = this.getAttribute('href');
      if (targetId === '#') return;

      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 80,
          behavior: 'smooth'
        });
      }
    });
  });

  // Add active class to current nav link
  const currentLocation = location.href;
  const menuItems = document.querySelectorAll('.nav-link');
  const menuLength = menuItems.length;

  for (let i = 0; i < menuLength; i++) {
    if (menuItems[i].href === currentLocation) {
      menuItems[i].classList.add('active');
    }
  }

})(jQuery);
