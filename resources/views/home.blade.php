@php
    use Illuminate\Support\Str;

    $imageUrl = fn (?string $path) => $path
        ? (Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/'.$path))
        : null;
    $siteUrl = url('/');
    $heroImage = $imageUrl($setting->hero_image);
    $aboutImage = $imageUrl($setting->about_image);
    $waNumber = preg_replace('/\D+/', '', $contact->whatsapp ?? '');
    $dailyPackage = $packages->firstWhere('is_featured', true) ?: $packages->first();
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting->meta_title ?: $setting->site_name }}</title>
    <meta name="description" content="{{ $setting->meta_description }}">
    <meta name="keywords" content="{{ $setting->meta_keywords }}">
    <link rel="canonical" href="{{ $siteUrl }}">
    <meta property="og:title" content="{{ $setting->meta_title ?: $setting->site_name }}">
    <meta property="og:description" content="{{ $setting->meta_description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $siteUrl }}">
    @if($heroImage)
        <meta property="og:image" content="{{ $heroImage }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <script src="{{ asset('assets/app.js') }}" defer></script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": @json($setting->site_name),
            "image": @json($heroImage),
            "address": @json($contact->address),
            "telephone": @json($contact->phone ?: $contact->whatsapp),
            "url": @json($siteUrl)
        }
    </script>
</head>
<body>
    <a class="skip-link" href="#beranda">Lewati ke konten</a>
    <header class="site-nav" id="navbar">
        <div class="container nav-inner">
            <a class="brand" href="#beranda" aria-label="{{ $setting->site_name }}">
                <span class="brand-mark">PA</span>
                <span>{{ $setting->site_name }}</span>
            </a>
            <nav class="nav-menu" id="navMenu" aria-label="Navigasi utama">
                <a class="nav-link active" href="#beranda">Beranda</a>
                <a class="nav-link" href="#tentang">Tentang</a>
                <a class="nav-link" href="#fasilitas">Fasilitas</a>
                <a class="nav-link" href="#galeri">Galeri</a>
                <a class="nav-link" href="#paket">Paket</a>
                <a class="nav-link" href="#peserta">Peserta</a>
                <a class="nav-link" href="#kontak">Kontak</a>
            </nav>
            <div class="nav-actions">
                @if($waNumber)
                    <a class="btn btn-ghost" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener">Reservasi</a>
                @endif
                <button class="hamburger" id="hamburger" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="navMenu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <main>
        <section class="hero reveal" id="beranda">
            <div class="container hero-grid">
                <div class="hero-copy">
                    @if($setting->hero_eyebrow)
                        <p class="eyebrow">{{ $setting->hero_eyebrow }}</p>
                    @endif
                    <h1>{{ $setting->hero_title }}</h1>
                    <p class="lead">{{ $setting->hero_subtitle }}</p>
                    <div class="actions">
                        @if($setting->hero_cta_text)
                            <a class="btn btn-primary" href="{{ $setting->hero_cta_link ?: '#paket' }}">{{ $setting->hero_cta_text }}</a>
                        @endif
                        @if($setting->hero_secondary_text)
                            <a class="btn btn-outline" href="{{ $setting->hero_secondary_link ?: '#kontak' }}">{{ $setting->hero_secondary_text }}</a>
                        @endif
                    </div>
                    @if($setting->highlights)
                        <div class="trust-strip">
                            @foreach($setting->highlights as $item)
                                <div>
                                    <span>{{ $item['label'] ?? '' }}</span>
                                    <strong>{{ $item['value'] ?? '' }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if($heroImage)
                    <figure class="hero-photo">
                        <img src="{{ $heroImage }}" alt="Suasana {{ $setting->site_name }}" width="720" height="520" loading="eager">
                    </figure>
                @endif
            </div>
        </section>

        @php
            $aboutSlides = collect();

            if ($aboutImage) {
                $aboutSlides->push([
                    'src' => $aboutImage,
                    'alt' => 'Pemenang galatama harian '.$setting->site_name,
                    'caption' => 'Galatama Harian',
                ]);
            }

            foreach ($galleries as $gallery) {
                $src = $imageUrl($gallery->image);
                if ($src && ! $aboutSlides->contains('src', $src)) {
                    $aboutSlides->push([
                        'src' => $src,
                        'alt' => $gallery->caption ?: 'Pemenang galatama harian '.$setting->site_name,
                        'caption' => $gallery->caption ?: 'Pemenang Galatama',
                    ]);
                }
            }
        @endphp

        <section class="section reveal" id="tentang">
            <div class="container split">
                @if($aboutSlides->isNotEmpty())
                    <div class="about-slider" data-slider aria-label="Slider foto pemenang galatama harian">
                        <div class="about-slider-track">
                            @foreach($aboutSlides as $slide)
                                <figure class="about-slide @if($loop->first) active @endif" data-slide>
                                    <img src="{{ $slide['src'] }}" alt="{{ $slide['alt'] }}" width="560" height="420" loading="lazy">
                                    <figcaption>{{ $slide['caption'] }}</figcaption>
                                </figure>
                            @endforeach
                        </div>

                        <div class="slider-progress" aria-hidden="true"></div>
                    </div>
                @endif
                <div>
                    <p class="eyebrow">Tentang</p>
                    <h2>{{ $setting->about_title }}</h2>
                    <p>{{ $setting->about_description }}</p>
                </div>
            </div>
        </section>

        <section class="section section-muted reveal" id="fasilitas">
            <div class="container">
                <div class="section-head">
                    <p class="eyebrow">Fasilitas</p>
                    <h2>Fasilitas Lengkap untuk Memancing Lebih Nyaman</h2>
                    <p>Kebutuhan utama pengunjung tersedia dalam area yang tertata dan mudah diakses.</p>
                </div>
                <div class="feature-grid stagger">
                    @foreach($facilities as $facility)
                        <article class="content-card feature-card">
                            @if($facility->image)
                                <img class="card-icon-img" src="{{ $imageUrl($facility->image) }}" alt="{{ $facility->title }}" width="56" height="56" loading="lazy">
                            @else
                                <span class="card-icon" aria-hidden="true">{{ Str::substr($facility->title, 0, 1) }}</span>
                            @endif
                            <h3>{{ $facility->title }}</h3>
                            <p>{{ $facility->description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section reveal" id="galeri">
            <div class="container">
                <div class="section-head">
                    <p class="eyebrow">Galeri</p>
                    <h2>Suasana Pemancingan Galatama AURI</h2>
                    <p>Foto area kolam, saung, dan fasilitas pendukung.</p>
                </div>
                <div class="gallery-grid stagger" aria-label="Galeri foto">
                    @foreach($galleries as $gallery)
                        <button class="gallery-item" type="button" aria-label="Buka foto {{ $loop->iteration }}">
                            <img src="{{ $imageUrl($gallery->image) }}" alt="{{ $gallery->caption ?: 'Galeri Pemancingan Galatama AURI' }}" width="420" height="300" loading="lazy">
                            @if($gallery->caption)
                                <span>{{ $gallery->caption }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section section-muted reveal" id="paket">
            <div class="container centered-section">
                <div class="section-head section-head-center">
                    <p class="eyebrow">Harga Harian</p>
                    <h2>Galatama Harian</h2>
                    <p>Harga dapat diperbarui setiap hari dari CMS sesuai jadwal dan kebijakan kolam.</p>
                </div>
                @if($dailyPackage)
                    <article class="content-card price-card daily-price-card featured">
                        <div>
                            <p class="eyebrow">Update Hari Ini</p>
                            <h3>{{ $dailyPackage->name }}</h3>
                            <p>{{ $dailyPackage->description }}</p>
                        </div>
                        <div class="daily-price-main">
                            <span>Harga</span>
                            <strong>{{ $dailyPackage->price }}</strong>
                        </div>
                        @if($dailyPackage->features)
                            <ul class="daily-feature-list">
                                @foreach($dailyPackage->features as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </article>
                @endif
            </div>
        </section>

        <section class="section reveal" id="peserta">
            <div class="container">
                <div class="section-head">
                    <p class="eyebrow">Peserta</p>
                    <h2>Daftar Peserta Galatama</h2>
                    <p>Nama peserta aktif untuk sesi galatama harian. Data dapat diperbarui dari dashboard admin.</p>
                </div>
                <div class="participant-list">
                    @forelse($participants as $participant)
                        <article class="participant-item">
                            <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div>
                                <h3>{{ $participant->name }}</h3>
                                @if($participant->note)
                                    <p>{{ $participant->note }}</p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <article class="content-card">
                            <h3>Belum ada peserta</h3>
                            <p>Tambahkan daftar peserta dari dashboard admin.</p>
                        </article>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="section section-muted reveal" id="kontak">
            <div class="container">
                <div class="section-head">
                    <p class="eyebrow">Kontak</p>
                    <h2>Reservasi dan Informasi Lokasi</h2>
                    <p>Hubungi admin untuk jadwal, paket komunitas, atau petunjuk rute.</p>
                </div>
                <div class="contact-grid">
                    <div class="map-panel">
                        @if($contact->maps_embed)
                            <iframe title="Peta {{ $setting->site_name }}" src="{{ $contact->maps_embed }}" width="640" height="420" loading="lazy"></iframe>
                        @endif
                    </div>
                    <div class="content-card contact-card">
                        <h3>{{ $setting->site_name }}</h3>
                        <p>{{ $contact->address }}</p>
                        @if($contact->opening_hours)
                            <p>Jam operasional: {{ $contact->opening_hours }}</p>
                        @endif
                        @if($contact->phone)
                            <p>Telepon: <a href="tel:{{ preg_replace('/\s+/', '', $contact->phone) }}">{{ $contact->phone }}</a></p>
                        @endif
                        @if($contact->email)
                            <p>Email: <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                        @endif
                        <div class="actions">
                            @if($waNumber)
                                <a class="btn btn-primary" href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Pemancingan Galatama AURI, saya ingin reservasi.') }}" target="_blank" rel="noopener">Chat WhatsApp</a>
                            @endif
                            @if($contact->maps_url)
                                <a class="btn btn-outline" href="{{ $contact->maps_url }}" target="_blank" rel="noopener">Buka Maps</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <p>&copy; {{ date('Y') }} {{ $setting->site_name }}. Semua hak dilindungi.</p>
            <div class="social">
                @foreach(['instagram' => 'Instagram', 'facebook' => 'Facebook', 'tiktok' => 'TikTok'] as $field => $label)
                    @if($contact->{$field})
                        <a href="{{ $contact->{$field} }}" target="_blank" rel="noopener">{{ $label }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </footer>

    <div class="lightbox" id="lightbox" aria-hidden="true" role="dialog" aria-label="Galeri">
        <button class="lightbox-close" id="lightboxClose" type="button" aria-label="Tutup galeri">&times;</button>
        <button class="lightbox-nav" id="lightboxPrev" type="button" aria-label="Gambar sebelumnya">&lsaquo;</button>
        <img id="lightboxImage" alt="" width="960" height="640">
        <button class="lightbox-nav" id="lightboxNext" type="button" aria-label="Gambar berikutnya">&rsaquo;</button>
    </div>
</body>
</html>
