// Add loading class to body on initial load
document.addEventListener('DOMContentLoaded', function () {
    document.body.classList.add('loading');

    // Initialize Workshop/Dealer Filtering
    initLocationFiltering();

    // Initialize FAQ Functionality
    initFAQFunctionality();

    // Initialize Contact Page
    initContactPage();

    // Initialize navbar
    const navbar = document.querySelector('.navbar');
    const navbarHeight = 100;

    // Navbar scroll effect
    window.addEventListener('scroll', function () {
        if (window.scrollY > navbarHeight) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scroll for anchor links
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

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Add hover effect to product cards
    const productCards = document.querySelectorAll('.product-thumb');
    productCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const angleX = (y - centerY) / 20;
            const angleY = (centerX - x) / 20;

            card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) scale(1.02)`;
            card.style.boxShadow = `${-angleY}px ${angleX}px 30px rgba(0, 0, 0, 0.1)`;
        });
    });

    // Parallax effect for hero section
    function parallax() {
        const parallaxElements = document.querySelectorAll('.parallax');

        parallaxElements.forEach(element => {
            const speed = parseFloat(element.getAttribute('data-speed')) || 0.5;
            const yPos = -(window.scrollY * speed);
            element.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    }

    window.addEventListener('scroll', parallax);

    // Initialize Splide carousel if exists
    if (document.querySelector('.splide')) {
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

    // Add smooth scroll behavior
    const scroll = new SmoothScroll('a[href*="#"]', {
        speed: 800,
        speedAsDuration: true,
        offset: 80,
    });

    // Add loading animation to images
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '200px 0px',
        threshold: 0.01
    });

    images.forEach(img => imageObserver.observe(img));

    // Remove loading state and hide preloader once everything is loaded
    window.addEventListener('load', function () {
        document.body.classList.remove('loading');

        const preloader = document.getElementById('preloader') || document.querySelector('.preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';

            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });
});

// Workshop/Dealer Location Filtering Function
function initLocationFiltering() {
    const cityFilter = document.getElementById('cityFilter');
    const typeFilter = document.getElementById('typeFilter');
    const locationItems = document.querySelectorAll('.location-item');

    if (!cityFilter || !typeFilter || locationItems.length === 0) {
        return; // Exit if we're not on the workshops page
    }

    function filterLocations() {
        const selectedCity = cityFilter.value.toLowerCase();
        const selectedType = typeFilter.value.toLowerCase();

        locationItems.forEach(item => {
            const itemCity = item.dataset.city || '';
            const itemType = item.dataset.type || '';

            const cityMatch = selectedCity === '' || itemCity === selectedCity;
            const typeMatch = selectedType === '' || itemType === selectedType;

            if (cityMatch && typeMatch) {
                item.classList.remove('hidden');
                item.style.display = 'block';
            } else {
                item.classList.add('hidden');
                item.style.display = 'none';
            }
        });

        // Show message if no results
        const visibleItems = Array.from(locationItems).filter(item =>
            !item.classList.contains('hidden')
        );

        let noResultsMsg = document.querySelector('.no-results-message');
        if (visibleItems.length === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-message text-center py-5';
                noResultsMsg.innerHTML = `
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada lokasi yang sesuai dengan filter yang dipilih. 
                        Silakan ubah filter Anda.
                    </div>
                `;
                document.getElementById('locationsGrid').appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    // Add event listeners
    cityFilter.addEventListener('change', filterLocations);
    typeFilter.addEventListener('change', filterLocations);

    initLiveMap();
}

// Global dealer locations data (accessible by both map and button functions)
window.dealerLocations = [
    { name: "SecondCycle Jakarta Pusat", city: "Jakarta", type: "Dealer Resmi", lat: -6.2088, lng: 106.8456, address: "Jl. Sudirman No. 123, Jakarta Pusat" },
    { name: "SecondCycle Jakarta Utara", city: "Jakarta", type: "Workshop", lat: -6.1384, lng: 106.8759, address: "Jl. Kelapa Gading No. 456, Jakarta Utara" },
    { name: "SecondCycle Jakarta Selatan", city: "Jakarta", type: "Service Center", lat: -6.2615, lng: 106.8106, address: "Jl. Fatmawati No. 789, Jakarta Selatan" },
    { name: "SecondCycle Bandung", city: "Bandung", type: "Dealer Resmi", lat: -6.9175, lng: 107.6191, address: "Jl. Dago No. 321, Bandung" },
    { name: "SecondCycle Surabaya Pusat", city: "Surabaya", type: "Workshop", lat: -7.2575, lng: 112.7521, address: "Jl. Ahmad Yani No. 654, Surabaya" },
    { name: "SecondCycle Surabaya Utara", city: "Surabaya", type: "Service Center", lat: -7.2316, lng: 112.7366, address: "Jl. Kenjeran No. 987, Surabaya Utara" },
    { name: "SecondCycle Semarang", city: "Semarang", type: "Dealer Resmi", lat: -6.9667, lng: 110.4167, address: "Jl. Pemuda No. 147, Semarang" },
    { name: "SecondCycle Yogyakarta", city: "Yogyakarta", type: "Workshop", lat: -7.7956, lng: 110.3695, address: "Jl. Malioboro No. 258, Yogyakarta" },
    { name: "SecondCycle Malang", city: "Malang", type: "Service Center", lat: -7.9797, lng: 112.6304, address: "Jl. Sukarno Hatta No. 369, Malang" },
    { name: "SecondCycle Bogor", city: "Bogor", type: "Dealer Resmi", lat: -6.5944, lng: 106.7892, address: "Jl. Pajajaran No. 741, Bogor" },
    { name: "SecondCycle Tangerang", city: "Tangerang", type: "Workshop", lat: -6.1703, lng: 106.6402, address: "Jl. Boulevard Raya No. 852, Tangerang" },
    { name: "SecondCycle Bekasi", city: "Bekasi", type: "Service Center", lat: -6.2383, lng: 106.9756, address: "Jl. Ahmad Yani No. 963, Bekasi" }
];

// Live Map Function
function initLiveMap() {
    const mapContainer = document.getElementById('locationsMap');
    if (!mapContainer) return;

    // Initialize Leaflet map centered on Indonesia
    window.map = L.map('locationsMap').setView([-2.5, 118], 5);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ' OpenStreetMap contributors',
        maxZoom: 19,
        minZoom: 5,
    }).addTo(window.map);

    // Use global dealer locations
    // Add markers for each location
    window.dealerLocations.forEach(location => {
        const markerColor = location.type === 'Dealer Resmi' ? '#6366f1' :
            location.type === 'Workshop' ? '#10b981' : '#f59e0b';

        const customIcon = L.divIcon({
            html: `<div style="background-color: ${markerColor}; width: 30px; height: 30px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30],
            className: 'custom-marker'
        });

        const marker = L.marker([location.lat, location.lng], { icon: customIcon })
            .addTo(map);

        // Create popup content
        const popupContent = `
            <div style="min-width: 200px;">
                <h6 style="margin: 0 0 8px 0; color: #1e293b; font-weight: 600;">${location.name}</h6>
                <p style="margin: 4px 0; color: #64748b; font-size: 14px;">
                    <i class="fas fa-map-marker-alt" style="color: ${markerColor}; margin-right: 4px;"></i>
                    <strong>${location.city}</strong>
                </p>
                <p style="margin: 4px 0; color: #64748b; font-size: 14px;">
                    <span style="background: ${markerColor}; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                        ${location.type}
                    </span>
                </p>
                <p style="margin: 8px 0 0 0; color: #64748b; font-size: 13px;">
                    ${location.address}
                </p>
                <div style="margin-top: 12px; display: flex; gap: 8px;">
                    <button onclick="window.open('https://www.google.com/maps/search/?api=1&query=${location.lat},${location.lng}', '_blank')" 
                            style="background: #6366f1; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer;">
                        <i class="fas fa-map me-1"></i>Google Maps
                    </button>
                    <button onclick="window.open('tel:+6287769002763', '_self')" 
                            style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer;">
                        <i class="fas fa-phone me-1"></i>Hubungi
                    </button>
                </div>
            </div>
        `;

        marker.bindPopup(popupContent);
    });

    // Add user location if available
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Add user location marker
                const userIcon = L.divIcon({
                    html: `<div style="background-color: #ef4444; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.5);"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                    popupAnchor: [0, -10],
                    className: 'user-marker'
                });

                L.marker([userLat, userLng], { icon: userIcon })
                    .addTo(map)
                    .bindPopup('<strong>Lokasi Anda</strong><br>Anda berada di sini');

                // Add location info below map
                const locationInfo = document.createElement('div');
                locationInfo.className = 'mt-3 text-center';
                locationInfo.innerHTML = `
                    <small class="text-muted">
                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                        Lokasi Anda terdeteksi: ${userLat.toFixed(4)}, ${userLng.toFixed(4)}
                    </small>
                `;
                mapContainer.parentNode.appendChild(locationInfo);
            },
            function (error) {
                console.log('Geolocation error:', error);
            }
        );
    }
}

// Function to scroll to locations list and apply filters
function scrollToLocations() {
    const locationsGrid = document.getElementById('locationsGrid');
    if (locationsGrid) {
        // Scroll to the locations section
        locationsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Apply filters if they're set
        const cityFilter = document.getElementById('cityFilter');
        const typeFilter = document.getElementById('typeFilter');

        if (cityFilter && typeFilter) {
            // Trigger filter change event to apply filters
            cityFilter.dispatchEvent(new Event('change'));
            typeFilter.dispatchEvent(new Event('change'));
        }
    }
}

// FAQ/Help Center Functionality
function initFAQFunctionality() {
    const faqSearch = document.getElementById('faqSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const faqItems = document.querySelectorAll('.faq-item');

    if (!faqSearch || !categoryFilter || faqItems.length === 0) {
        return; // Exit if we're not on the FAQ page
    }

    // Search functionality
    faqSearch.addEventListener('input', function () {
        filterFAQs();
    });

    // Category filter functionality
    categoryFilter.addEventListener('change', function () {
        filterFAQs();
    });
}

function filterFAQs() {
    const searchTerm = document.getElementById('faqSearch').value.toLowerCase();
    const selectedCategory = document.getElementById('categoryFilter').value.toLowerCase();
    const faqItems = document.querySelectorAll('.faq-item');
    const noResults = document.getElementById('noResults');

    let visibleCount = 0;

    faqItems.forEach(item => {
        const question = item.dataset.question || '';
        const answer = item.dataset.answer || '';
        const category = item.dataset.category || '';

        const matchesSearch = searchTerm === '' ||
            question.includes(searchTerm) ||
            answer.includes(searchTerm);

        const matchesCategory = selectedCategory === '' ||
            category === selectedCategory;

        if (matchesSearch && matchesCategory) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
        noResults.style.display = 'block';
    } else {
        noResults.style.display = 'none';
    }
}

function searchFAQ(term) {
    const faqSearch = document.getElementById('faqSearch');
    if (faqSearch) {
        faqSearch.value = term;
        filterFAQs();

        // Scroll to FAQ section
        document.getElementById('faqAccordion').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

function filterByCategory(category) {
    const categoryFilter = document.getElementById('categoryFilter');
    if (categoryFilter) {
        categoryFilter.value = category;
        filterFAQs();

        // Scroll to FAQ section
        document.getElementById('faqAccordion').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

function clearFilters() {
    const faqSearch = document.getElementById('faqSearch');
    const categoryFilter = document.getElementById('categoryFilter');

    if (faqSearch) faqSearch.value = '';
    if (categoryFilter) categoryFilter.value = '';

    filterFAQs();
}

function markHelpful(faqId) {
    // Simulate marking as helpful
    const button = event.target;
    button.innerHTML = '<i class="fas fa-check"></i> Terima Kasih!';
    button.classList.remove('btn-outline-success');
    button.classList.add('btn-success');
    button.disabled = true;

    // Disable the "No" button
    const noButton = button.parentElement.querySelector('.btn-outline-danger');
    if (noButton) {
        noButton.disabled = true;
    }

    // Here you would normally send this to the server
    console.log('FAQ ' + faqId + ' marked as helpful');
}

function markNotHelpful(faqId) {
    // Simulate marking as not helpful
    const button = event.target;
    button.innerHTML = '<i class="fas fa-times"></i> Terima Kasih';
    button.classList.remove('btn-outline-danger');
    button.classList.add('btn-danger');
    button.disabled = true;

    // Disable the "Yes" button
    const yesButton = button.parentElement.querySelector('.btn-outline-success');
    if (yesButton) {
        yesButton.disabled = true;
    }

    // Here you would normally send this to the server
    console.log('FAQ ' + faqId + ' marked as not helpful');
}

function startLiveChat() {
    // Simulate live chat functionality
    alert('Live chat akan segera tersedia. Untuk sementara, silakan hubungi kami melalui telepon atau email.');
    // In a real implementation, this would open a chat widget
}


// Contact Page Functionality
function initContactPage() {
    // Initialize contact map if on contact page
    initContactMap();

    // Initialize form validation
    initContactFormValidation();
}

function initContactMap() {
    const mapContainer = document.getElementById('contactMap');
    if (!mapContainer) return; // Exit if not on contact page

    // Initialize Leaflet map centered on Jakarta
    const contactMap = L.map('contactMap').setView([-6.2088, 106.8456], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ' OpenStreetMap contributors',
        maxZoom: 19,
        minZoom: 10,
    }).addTo(contactMap);

    // Add main office marker
    const mainOfficeIcon = L.divIcon({
        html: `<div style="background-color: #6366f1; width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.3);"></div>`,
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40],
        className: 'main-office-marker'
    });

    const mainOfficeMarker = L.marker([-6.2088, 106.8456], { icon: mainOfficeIcon })
        .addTo(contactMap);

    // Create popup content for main office
    const popupContent = `
        <div style="min-width: 250px;">
            <h6 style="margin: 0 0 8px 0; color: #1e293b; font-weight: 600;">SecondCycle Indonesia</h6>
            <p style="margin: 4px 0; color: #64748b; font-size: 14px;">
                <i class="fas fa-map-marker-alt" style="color: #6366f1; margin-right: 4px;"></i>
                <strong>Kantor Pusat</strong>
            </p>
            <p style="margin: 4px 0; color: #64748b; font-size: 14px;">
                Jl. Sudirman No. 123, Jakarta Pusat
            </p>
            <p style="margin: 4px 0; color: #64748b; font-size: 14px;">
                DKI Jakarta 10110
            </p>
            <div style="margin-top: 12px; display: flex; gap: 8px;">
                <button onclick="window.open('https://www.google.com/maps/search/?api=1&query=SecondCycle+Indonesia+Jakarta', '_blank')" 
                        style="background: #6366f1; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer;">
                    <i class="fas fa-map me-1"></i>Google Maps
                </button>
                <button onclick="window.open('tel:+6287769002763', '_self')" 
                        style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer;">
                    <i class="fas fa-phone me-1"></i>Hubungi
                </button>
            </div>
        </div>
    `;

    mainOfficeMarker.bindPopup(popupContent).openPopup();

    // Add nearby dealer locations as smaller markers
    const nearbyDealers = [
        { name: "SecondCycle Jakarta Utara", lat: -6.1384, lng: 106.8759, type: "Workshop" },
        { name: "SecondCycle Jakarta Selatan", lat: -6.2615, lng: 106.8106, type: "Service Center" },
        { name: "SecondCycle Bekasi", lat: -6.2383, lng: 106.9756, type: "Service Center" }
    ];

    nearbyDealers.forEach(dealer => {
        const dealerIcon = L.divIcon({
            html: `<div style="background-color: #10b981; width: 25px; height: 25px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
            iconSize: [25, 25],
            iconAnchor: [12, 25],
            popupAnchor: [0, -25],
            className: 'dealer-marker'
        });

        L.marker([dealer.lat, dealer.lng], { icon: dealerIcon })
            .addTo(contactMap)
            .bindPopup(`
                <div style="min-width: 200px;">
                    <h6 style="margin: 0 0 4px 0; color: #1e293b; font-size: 14px; font-weight: 600;">${dealer.name}</h6>
                    <p style="margin: 2px 0; color: #64748b; font-size: 12px;">
                        <span style="background: #10b981; color: white; padding: 1px 4px; border-radius: 3px; font-size: 10px;">
                            ${dealer.type}
                        </span>
                    </p>
                </div>
            `);
    });
}

function initContactFormValidation() {
    const contactForm = document.getElementById('contactForm');
    if (!contactForm) return; // Exit if not on contact page

    // Add real-time validation
    const requiredFields = contactForm.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function () {
            validateField(this);
        });

        field.addEventListener('input', function () {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });

    // Form submission handler
    contactForm.addEventListener('submit', function (e) {
        let isValid = true;

        requiredFields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();

            // Scroll to first error
            const firstError = contactForm.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }

            // Show error message
            showNotification('Mohon lengkapi semua field yang wajib diisi.', 'error');
        }
    });
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    // Remove previous validation
    field.classList.remove('is-invalid', 'is-valid');

    // Remove existing error message
    const existingError = field.parentNode.querySelector('.invalid-feedback');
    if (existingError) {
        existingError.remove();
    }

    // Validation rules
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'Field ini wajib diisi.';
    } else if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Format email tidak valid.';
        }
    } else if (field.type === 'tel' && value) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        if (!phoneRegex.test(value) || value.length < 10) {
            isValid = false;
            errorMessage = 'Nomor telepon tidak valid (minimal 10 digit).';
        }
    } else if (field.name === 'message' && value.length < 10) {
        isValid = false;
        errorMessage = 'Pesan minimal 10 karakter.';
    }

    // Apply validation
    if (!isValid) {
        field.classList.add('is-invalid');

        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = errorMessage;
        field.parentNode.appendChild(errorDiv);
    } else if (value) {
        field.classList.add('is-valid');
    }

    return isValid;
}

// Contact page interaction functions
function callPhone() {
    window.open('tel:+6287769002763', '_self');
}

function openWhatsApp() {
    const message = encodeURIComponent('Halo SecondCycle, saya ingin bertanya tentang motor bekas Anda.');
    window.open(`https://wa.me/6287769002763?text=${message}`, '_blank');
}

function scrollToForm() {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Focus on first field
        const firstField = contactForm.querySelector('input');
        if (firstField) {
            setTimeout(() => firstField.focus(), 500);
        }
    }
}

function resetForm() {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.reset();

        // Remove validation classes
        const fields = contactForm.querySelectorAll('.form-control, .form-select');
        fields.forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });

        // Remove error messages
        const errorMessages = contactForm.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(msg => msg.remove());

        showNotification('Form telah direset.', 'info');
    }
}

function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.contact-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Create notification
    const notification = document.createElement('div');
    notification.className = `contact-notification alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}


// Function to show specific location on map
function showLocationOnMap(locationName, cityName) {
    const mapContainer = document.getElementById('locationsMap');
    if (!mapContainer) return;

    // Scroll to map section
    mapContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Find the location in our data
    const location = window.dealerLocations.find(loc =>
        loc.name.toLowerCase().includes(locationName.toLowerCase()) ||
        loc.city.toLowerCase().includes(cityName.toLowerCase())
    );

    if (location && window.map) {
        // Center map on the location
        window.map.setView([location.lat, location.lng], 12);

        // Find and open the popup for this location
        window.map.eachLayer(function (layer) {
            if (layer instanceof L.Marker) {
                const popup = layer.getPopup();
                if (popup && popup.getContent().includes(location.name)) {
                    layer.openPopup();

                    // Add highlight effect
                    const icon = layer.getIcon();
                    const originalHtml = icon.options.html;
                    icon.options.html = originalHtml.replace('30px', '40px').replace('2px', '4px');
                    layer.setIcon(icon);

                    // Reset after 2 seconds
                    setTimeout(() => {
                        icon.options.html = originalHtml;
                        layer.setIcon(icon);
                    }, 2000);
                }
            }
        });
    }
}
