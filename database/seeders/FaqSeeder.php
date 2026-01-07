<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing FAQs to prevent duplicates
        Faq::truncate();
        // General Category
        $generalFaqs = [
            [
                'category' => 'general',
                'question' => 'Apa itu SecondCycle?',
                'answer' => 'SecondCycle adalah platform jual beli motor bekas berkualitas yang menyediakan motor-motor pilihan dengan proses inspeksi ketat dan transparan. Kami menjamin semua motor yang dijual telah melalui pemeriksaan menyeluruh oleh teknisi bersertifikat.'
            ],
            [
                'category' => 'general',
                'question' => 'Kenapa harus membeli motor di SecondCycle?',
                'answer' => 'Karena kami menyediakan motor bekas berkualitas dengan garansi, proses inspeksi transparan, harga kompetitif, dan layanan purna jual yang lengkap. Setiap motor mendapatkan sertifikat inspeksi dan garansi resmi dari SecondCycle.'
            ],
            [
                'category' => 'general',
                'question' => 'Apakah SecondCycle memiliki dealer fisik?',
                'answer' => 'Ya, SecondCycle memiliki jaringan dealer dan workshop resmi di kota-kota besar Pulau Jawa seperti Jakarta, Bandung, Surabaya, Semarang, Yogyakarta, Malang, Bogor, Tangerang, dan Bekasi. Anda bisa langsung mengunjungi dealer kami untuk melihat unit motor.'
            ],
            [
                'category' => 'general',
                'question' => 'Bagaimana cara kerja SecondCycle?',
                'answer' => 'SecondCycle bekerja dengan sistem yang transparan: kami membeli motor bekas berkualitas, melakukan inspeksi menyeluruh, melakukan perbaikan jika diperlukan, kemudian menjual kembali dengan garansi. Setiap tahap proses didokumentasikan dan bisa dicek oleh pembeli.'
            ],
            [
                'category' => 'general',
                'question' => 'Apakah ada program tukar tambah motor?',
                'answer' => 'Ya, SecondCycle menyediakan program tukar tambah motor. Anda bisa menukar motor lama Anda dengan motor pilihan dari koleksi kami. Tim kami akan melakukan penilaian motor Anda dan memberikan penawaran harga yang fair.'
            ]
        ];

        // Produk Category
        $produkFaqs = [
            [
                'category' => 'produk',
                'question' => 'Apa saja merek motor yang tersedia?',
                'answer' => 'SecondCycle menyediakan berbagai merek motor populer di Indonesia seperti Honda, Yamaha, Suzuki, Kawasaki, dan merek lainnya. Kami fokus pada motor-motor dengan ketersediaan suku cadang yang mudah dan kualitas yang terbukti.'
            ],
            [
                'category' => 'produk',
                'question' => 'Bagaimana kondisi motor yang dijual?',
                'answer' => 'Semua motor di SecondCycle melalui proses inspeksi 50+ poin meliputi mesin, rangka, kelistrikan, rem, suspensi, dan komponen lainnya. Motor yang tidak lolos inspeksi tidak akan dijual. Setiap motor mendapatkan laporan inspeksi lengkap.'
            ],
            [
                'category' => 'produk',
                'question' => 'Apakah motor sudah melalui service?',
                'answer' => 'Ya, semua motor mendapatkan service rutin sebelum dijual termasuk penggantian oli, filter, spare part yang aus, dan penyesuaian performa. Kami memastikan motor dalam kondisi prima siap pakai.'
            ],
            [
                'category' => 'produk',
                'question' => 'Berapa umur rata-rata motor yang dijual?',
                'answer' => 'Umur motor yang kami jual berkisar antara 1-7 tahun dengan kilometer maksimal 50.000 km. Kami memilih motor-motor yang masih dalam kondisi prima dan memiliki nilai jual kembali yang baik.'
            ],
            [
                'category' => 'produk',
                'question' => 'Apakah tersedia motor sport dan matic?',
                'answer' => 'Ya, SecondCycle menyediakan semua jenis motor: matic, bebek, dan sport. Setiap jenis motor memiliki spesifikasi dan keunggulan masing-masing yang bisa disesuaikan dengan kebutuhan Anda.'
            ],
            [
                'category' => 'produk',
                'question' => 'Bagaimana dengan dokumen motor?',
                'answer' => 'Semua motor memiliki dokumen lengkap termasuk STNK, BPKB, dan faktur pembelian. Kami memastikan semua dokumen asli dan tidak ada masalah hukum. Proses balik nama bisa dibantu oleh tim kami.'
            ]
        ];

        // Layanan Category
        $layananFaqs = [
            [
                'category' => 'layanan',
                'question' => 'Apa saja garansi yang didapat?',
                'answer' => 'SecondCycle memberikan garansi mesin 1 bulan, garansi transmisi 3 bulan, garansi kelistrikan 6 bulan, dan garansi rangka 1 tahun. Garansi meliputi penggantian spare part dan jasa service di workshop resmi kami.'
            ],
            [
                'category' => 'layanan',
                'question' => 'Bagaimana proses pembayaran?',
                'answer' => 'Kami menerima pembayaran tunai, transfer bank, kartu kredit (cicilan 0% hingga 12 bulan), dan pembiayaan dari leasing partner. Proses pembayaran aman dan terjamin keamanannya.'
            ],
            [
                'category' => 'layanan',
                'question' => 'Apakah ada layanan pengiriman motor?',
                'answer' => 'Ya, kami menyediakan layanan pengiriman motor ke seluruh Indonesia dengan biaya terjangkau. Motor akan dikemas dengan aman dan diasuransikan selama perjalanan. Estimasi pengiriman 1-5 hari kerja tergantung lokasi.'
            ],
            [
                'category' => 'layanan',
                'question' => 'Bagaimana proses test ride?',
                'answer' => 'Anda bisa melakukan test ride di dealer kami dengan syarat membawa SIM C dan KTP. Tim kami akan mendampingi selama test ride dan menjelaskan fitur-fitur motor. Test ride gratis tidak ada biaya tambahan.'
            ],
            [
                'category' => 'layanan',
                'question' => 'Apakah ada program servis gratis?',
                'answer' => 'Ya, setiap pembelian motor mendapatkan 1x servis gratis (oli dan filter) dalam 3 bulan pertama. Selain itu, ada diskon 20% untuk semua spare part dan jasa service di workshop resmi SecondCycle selama 1 tahun.'
            ],
            [
                'category' => 'layanan',
                'question' => 'Bagaimana cara klaim garansi?',
                'answer' => 'Klaim garansi bisa dilakukan dengan membawa motor ke workshop resmi SecondCycle terdekat beserta buku garansi dan nota pembelian. Tim kami akan memeriksa kerusakan dan melakukan perbaikan sesuai syarat dan ketentuan garansi.'
            ]
        ];

        // Teknis Category
        $teknisFaqs = [
            [
                'category' => 'teknis',
                'question' => 'Apa saja yang diperiksa saat inspeksi?',
                'answer' => 'Proses inspeksi meliputi: kondisi mesin (kompresi, kebocoran), transmisi, sistem kelistrikan, rem, suspensi, rangka, ban, dan aksesoris. Total ada 50+ poin pemeriksaan untuk memastikan kualitas motor.'
            ],
            [
                'category' => 'teknis',
                'question' => 'Bagaimana cara merawat motor bekas?',
                'answer' => 'Lakukan service rutin setiap 2000 km, ganti oli setiap 3000 km, periksa tekanan ban secara berkala, panaskan motor 3-5 menit sebelum dipakai, dan hindari pemakaian dalam kondisi hujan deras. Ikuti buku panduan servis yang kami berikan.'
            ],
            [
                'category' => 'teknis',
                'question' => 'Apakah spare part mudah didapat?',
                'answer' => 'Ya, semua motor yang kami jual adalah merek populer dengan ketersediaan spare part yang mudah. Workshop resmi kami juga menyediakan spare part original dengan harga kompetitif.'
            ],
            [
                'category' => 'teknis',
                'question' => 'Bagaimana jika motor bermasalah setelah dibeli?',
                'answer' => 'Hubungi customer service kami segera. Jika masih dalam masa garansi, perbaikan akan ditanggung. Jika sudah lewat masa garansi, kami tetap membantu dengan biaya yang terjangkau. Workshop kami siap membantu 24/7 untuk masalah darurat.'
            ],
            [
                'category' => 'teknis',
                'question' => 'Apakah motor sudah dimodifikasi?',
                'answer' => 'Tidak, semua motor yang kami jual dalam kondisi standar pabrik. Kami tidak menjual motor yang sudah dimodifikasi untuk menjaga keaslian dan kualitas. Modifikasi bisa dilakukan setelah pembelian dengan bantuan workshop kami.'
            ],
            [
                'category' => 'teknis',
                'question' => 'Bagaimana cara mengecek keaslian kilometer?',
                'answer' => 'Tim kami menggunakan alat diagnostik profesional untuk mengecek keaslian kilometer dan mencocokkannya dengan riwayat service. Kami juga memeriksa kondisi fisik pedal gas, handle grip, dan komponen lain yang menunjukkan pemakaian.'
            ]
        ];

        // Insert all FAQs
        foreach ($generalFaqs as $faq) {
            Faq::create($faq);
        }

        foreach ($produkFaqs as $faq) {
            Faq::create($faq);
        }

        foreach ($layananFaqs as $faq) {
            Faq::create($faq);
        }

        foreach ($teknisFaqs as $faq) {
            Faq::create($faq);
        }
    }
}
