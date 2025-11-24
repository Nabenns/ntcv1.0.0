<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $tickerData = [
            ['symbol' => 'BTC/USDT', 'price' => '$83,450', 'change' => '-3.5%'],
            ['symbol' => 'ETH/USDT', 'price' => '$2,730', 'change' => '-3.6%'],
            ['symbol' => 'AAPL', 'price' => '$269.38', 'change' => '+0.3%'],
            ['symbol' => 'MSFT', 'price' => '$473.26', 'change' => '-2.8%'],
            ['symbol' => 'AMZN', 'price' => '$216.71', 'change' => '-2.6%'],
            ['symbol' => 'NVDA', 'price' => '$1,283.11', 'change' => '+1.2%'],
            ['symbol' => 'TSLA', 'price' => '$212.44', 'change' => '-1.5%'],
        ];

        $pillars = [
            [
                'title' => 'Exclusive Learning Video',
                'copy' => 'Nikmati modul dan video pembelajaran yang disusun oleh mentor berpengalaman puluhan tahun di industri trading forex dan gold. Materi disampaikan dari level dasar hingga tingkat mahir, sehingga Anda dapat belajar dengan terarah dan efektif.',
            ],
            [
                'title' => 'Technical Edge',
                'copy' => 'Dapatkan analisis teknikal mendalam dan ide trading yang dapat Anda gunakan setiap hari. Semua disajikan untuk membantu Anda mengambil keputusan yang lebih percaya diri di pasar.',
            ],
            [
                'title' => 'Exclusive Support',
                'copy' => 'Tim analis profesional kami siap menjawab setiap pertanyaan Anda melalui ruang diskusi maupun pesan pribadi. Dukungan penuh untuk memastikan perjalanan belajar dan trading Anda berjalan optimal.',
            ],
            [
                'title' => 'Exclusive Insight',
                'copy' => 'Akses rangkuman market harian yang selalu diperbarui. Anda akan mendapatkan informasi jika terjadi perubahan sentimen atau tren, sehingga Anda tetap selangkah lebih maju dalam membaca pergerakan pasar.',
            ],
        ];

        $services = [
            [
                'label' => 'Exclusive Community',
                'status' => 'OPEN',
                'copy' => 'Akses ke private Telegram room yang berisi sinyal trading harian, ruang diskusi aktif, serta modul premium yang hanya tersedia bagi member komunitas.',
                'cta' => 'https://t.me/nusantaratradingcenter',
                'ctaLabel' => 'Gabung Komunitas',
            ],
            [
                'label' => 'Kursus Trading',
                'status' => 'OPEN',
                'copy' => 'Materi pembelajaran lengkap berupa modul dan video yang terus diperbarui. Cocok untuk pemula hingga mahir, dilengkapi studi kasus nyata agar Anda memahami market secara praktis.',
                'cta' => 'https://wa.me/6281288880000?text=Halo%20NTC%2C%20saya%20ingin%20info%20kursus',
                'ctaLabel' => 'Info Kursus',
            ],
            [
                'label' => 'Premium Membership',
                'status' => 'OPEN',
                'copy' => 'Nikmati pendampingan intensif dan dukungan chat 24/7 dari tim analis profesional yang siap menjawab setiap pertanyaan Anda tentang market, strategi, dan peluang trading.',
                'cta' => 'https://wa.me/6281288880000?text=Halo%20NTC%2C%20saya%20ingin%20info%20premium%20membership',
                'ctaLabel' => 'Hubungi Kami',
            ],
        ];

        $testimonials = [
            [
                'content' => 'Setelah 6 bulan konsisten di komunitas ini, jurnal trading saya jauh lebih disiplin.',
                'name' => 'Rudi Laksana',
                'role' => 'Swing Trader',
            ],
            [
                'content' => 'Suka banget sama format live mentoring. Interaktif dan langsung applicable.',
                'name' => 'Nadya Zuhri',
                'role' => 'Crypto Day Trader',
            ],
            [
                'content' => 'NTC bantu saya memimpin komunitas lokal karena materinya gampang dibawa ulang.',
                'name' => 'Yoga Prakoso',
                'role' => 'Community Lead',
            ],
        ];

        $howItWorks = [
            ['step' => '01', 'title' => 'Daftar Akun', 'copy' => 'Buat akun member kurang dari 2 menit.'],
            ['step' => '02', 'title' => 'Pilih Paket', 'copy' => 'Langganan sesuai kebutuhan pembelajaranmu.'],
            ['step' => '03', 'title' => 'Masuk Komunitas', 'copy' => 'Akses grup, modul, dan jadwal live session.'],
        ];

        $faq = [
            [
                'q' => 'Apakah pemula seperti saya bisa ikut?',
                'a' => 'Tentu bisa! Teknik dan sinyal trading yang kami sediakan dirancang agar mudah dipahami, bahkan untuk pemula. Anda dapat mengikuti semua arahan dan sinyal yang diberikan dengan jelas dan terstruktur.',
            ],
            [
                'q' => 'Berapa Stop Loss dan TP untuk setiap sinyal trading?',
                'a' => 'Setiap sinyal sudah dilengkapi dengan parameter risiko dan target yang jelas: Stop Loss: 30–60 pips, Take Profit: 100–200 pips. Kami juga menerapkan sistem Break Even yang ketat untuk membantu meminimalkan risiko dan menjaga potensi profit.',
            ],
            [
                'q' => 'Bagaimana sistem pembayarannya?',
                'a' => 'Kami mendukung berbagai metode pembayaran yang aman dan praktis, antara lain Transfer Bank, Virtual Account, Kartu Kredit, E-Wallet utama.',
            ],
        ];

        $stats = [
            ['label' => 'Anggota Aktif', 'value' => '3.2K', 'delta' => '+180/mo'],
            ['label' => 'Jam Mentoring', 'value' => '1,450+', 'delta' => 'Live & on-demand'],
            ['label' => 'Kota Komunitas', 'value' => '24', 'delta' => 'Chapter Indonesia'],
        ];

        return view('pages.home', [
            'articles' => Article::published()->take(3)->get(),
            'tickerData' => $tickerData,
            'pillars' => $pillars,
            'services' => $services,
            'testimonials' => $testimonials,
            'howItWorks' => $howItWorks,
            'faq' => $faq,
            'stats' => $stats,
        ]);
    }
}
