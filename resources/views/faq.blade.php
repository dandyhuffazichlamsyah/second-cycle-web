@extends('layouts.main')

@section('title', 'Pusat Bantuan - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-white border-bottom border-light" style="margin-top: 120px;">
  <div class="container py-lg-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge-premium badge-premium-dark mb-2">Pusat Bantuan</span>
        <h1 class="display-5 fw-bold mb-4">Ada yang Bisa Kami Bantu?</h1>
        <p class="text-secondary mb-4 fs-5" style="line-height: 1.7;">
          Temukan jawaban atas pertanyaan seputar pembelian, kelengkapan surat STNK/BPKB, pengiriman unit, hingga garansi mesin.
        </p>
      </div>
      <div class="col-lg-6">
        <div class="p-4 bg-light border border-light">
          <label class="form-label fw-bold small text-secondary">Cari Informasi</label>
          <div class="d-flex mb-3">
            <input type="text" class="form-control" id="faqSearch" placeholder="Ketik kata kunci (misal: garansi, stnk)..." style="border-right: none;">
            <button class="btn btn-primary px-4">Cari</button>
          </div>
          <div class="small">
            <span class="text-secondary">Kata kunci populer:</span>
            <a href="#" onclick="searchKeyword('garansi'); event.preventDefault();" class="text-dark fw-bold text-decoration-none ms-2">Garansi</a>,
            <a href="#" onclick="searchKeyword('stnk'); event.preventDefault();" class="text-dark fw-bold text-decoration-none ms-2">STNK</a>,
            <a href="#" onclick="searchKeyword('kredit'); event.preventDefault();" class="text-dark fw-bold text-decoration-none ms-2">Kredit</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Accordion FAQs -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="accordion accordion-flush" id="faqAccordion">
          
          <div class="accordion-item border-bottom border-light faq-item" data-searchable="garansi mesin klaim kerusakan">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed fw-bold py-4 text-dark bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                Bagaimana jaminan garansi motor di SecondCycle?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-secondary small pb-4" style="line-height: 1.8;">
                Setiap unit motor bekas yang Anda beli di SecondCycle berhak mendapatkan Garansi Mesin selama 30 hari kalender terhitung sejak unit diserahterimakan. Garansi mencakup kerusakan mesin utama non-habis pakai yang bukan disebabkan kelalaian penggunaan atau modifikasi ilegal.
              </div>
            </div>
          </div>

          <div class="accordion-item border-bottom border-light faq-item" data-searchable="dokumen stnk bpkb asli surat kepolisian legalitas">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed fw-bold py-4 text-dark bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                Apakah surat-surat kendaraan dijamin asli dan lengkap?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-secondary small pb-4" style="line-height: 1.8;">
                Ya, 100% dijamin. Seluruh unit kami wajib memiliki BPKB, STNK, dan Faktur Pembelian asli (kecuali diinformasikan khusus jika ada berkas hilang yang sedang dalam pengurusan). Kami melakukan verifikasi silang langsung ke Samsat kepolisian untuk memastikan legalitas dokumen.
              </div>
            </div>
          </div>

          <div class="accordion-item border-bottom border-light faq-item" data-searchable="kredit tenor pembiayaan cicilan angsuran adira oto leasing">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed fw-bold py-4 text-dark bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                Apakah bisa mengajukan pembelian secara kredit?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-secondary small pb-4" style="line-height: 1.8;">
                Tentu saja. Kami bekerja sama dengan leasing otomotif terpercaya (seperti ADIRA, OTO, dan FIF). Anda bisa mensimulasikan nilai DP dan tenor angsuran bulanan langsung di halaman detail masing-masing motor, lalu mengisi formulir pengajuan kredit untuk diproses tim analis kami.
              </div>
            </div>
          </div>

          <div class="accordion-item border-bottom border-light faq-item" data-searchable="pengiriman ongkir kurir antar jemput unit rumah">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed fw-bold py-4 text-dark bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                Bagaimana ketentuan pengiriman motor ke rumah saya?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-secondary small pb-4" style="line-height: 1.8;">
                Kami menyediakan layanan pengiriman dengan mobil towing khusus langsung ke alamat rumah Anda. Untuk wilayah Jabodetabek, pengiriman tidak dikenakan biaya tambahan (gratis ongkir). Untuk pengiriman di luar Jabodetabek, tarif akan dihitung berdasarkan jarak tempuh diler terdekat.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearch');
    const faqItems = document.querySelectorAll('.faq-item');

    function performSearch(term) {
        const query = term.toLowerCase().trim();
        faqItems.forEach(item => {
            const searchable = item.dataset.searchable.toLowerCase();
            const text = item.textContent.toLowerCase();
            if (searchable.includes(query) || text.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', function() {
        performSearch(this.value);
    });

    window.searchKeyword = function(keyword) {
        searchInput.value = keyword;
        performSearch(keyword);
    };
});
</script>
@endsection
