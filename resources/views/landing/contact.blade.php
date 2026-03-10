@extends('layouts.landing')

@section('title', 'Kontak Kami')
@section('page_title', 'Hubungi Kami')

@section('breadcrumb')
<span class="breadcrumb-sep">Kontak</span>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8 lg:px-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Contact Info --}}
        <div>
            <h2 class="text-2xl font-extrabold text-[#212529] dark:text-white mb-2">Kami Siap Membantu!</h2>
            <p class="text-sm text-[#6C757D] mb-6 leading-relaxed">
                Hubungi kami untuk pertanyaan, pesanan khusus, atau informasi lainnya.
                Tim kami siap melayani Anda.
            </p>

            <div class="space-y-4">
                @foreach([
                    ['solar:phone-bold','WhatsApp','Hubungi via WhatsApp','https://wa.me/62812345678','#25D366'],
                    ['solar:letter-bold','Email','info@evdesign.id','mailto:info@evdesign.id','#fc1919'],
                    ['solar:map-point-bold','Lokasi','Yogyakarta, Indonesia',null,'#fc1919'],
                    ['solar:clock-bold','Jam Operasional','Senin – Sabtu, 08:00 – 17:00 WIB',null,'#fc1919'],
                ] as [$icon,$label,$value,$href,$color])
                <div class="flex items-start gap-4 p-4 bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222]">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: {{ $color }}1a">
                        <iconify-icon icon="{{ $icon }}" class="text-xl" style="color: {{ $color }}"></iconify-icon>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide">{{ $label }}</p>
                        @if($href)
                        <a href="{{ $href }}" target="_blank" class="text-sm font-medium text-[#212529] dark:text-white hover:text-[#fc1919] transition-colors truncate block">{{ $value }}</a>
                        @else
                        <p class="text-sm font-medium text-[#212529] dark:text-white">{{ $value }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 p-5 bg-gradient-to-r from-[#fc1919] to-[#c0392b] rounded-2xl text-white">
                <p class="font-bold text-base mb-1">Butuh Produk Custom?</p>
                <p class="text-sm text-white/80 mb-3">Kami menerima pesanan kerajinan tangan sesuai kebutuhan Anda.</p>
                <a href="https://wa.me/62812345678?text={{ urlencode('Halo EVDesign, saya ingin memesan produk custom.') }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-white text-[#fc1919] px-4 py-2 rounded-xl text-sm font-bold hover:bg-red-50 transition-colors">
                    <iconify-icon icon="ic:baseline-whatsapp" class="text-base"></iconify-icon>
                    Chat WhatsApp
                </a>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222] p-6">
            <h3 class="text-base font-bold text-[#212529] dark:text-white mb-4">Kirim Pesan</h3>
            <form class="space-y-4" onsubmit="handleContact(event)">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide block mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Masukkan nama Anda"
                           class="w-full px-4 py-2.5 rounded-xl border border-[#E9ECEF] dark:border-[#333] bg-[#F8F9FA] dark:bg-[#111] text-[#212529] dark:text-white text-sm outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20 transition-all placeholder-[#ADB5BD]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide block mb-1">Email</label>
                    <input type="email" name="email" required placeholder="email@domain.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-[#E9ECEF] dark:border-[#333] bg-[#F8F9FA] dark:bg-[#111] text-[#212529] dark:text-white text-sm outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20 transition-all placeholder-[#ADB5BD]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide block mb-1">Subjek</label>
                    <input type="text" name="subject" required placeholder="Perihal pesan"
                           class="w-full px-4 py-2.5 rounded-xl border border-[#E9ECEF] dark:border-[#333] bg-[#F8F9FA] dark:bg-[#111] text-[#212529] dark:text-white text-sm outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20 transition-all placeholder-[#ADB5BD]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide block mb-1">Pesan</label>
                    <textarea name="message" required rows="4" placeholder="Tulis pesan Anda..."
                              class="w-full px-4 py-2.5 rounded-xl border border-[#E9ECEF] dark:border-[#333] bg-[#F8F9FA] dark:bg-[#111] text-[#212529] dark:text-white text-sm outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20 transition-all placeholder-[#ADB5BD] resize-none"></textarea>
                </div>
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 bg-[#fc1919] text-white rounded-xl font-bold text-sm hover:bg-red-600 transition-all shadow-lg shadow-red-500/20 hover:-translate-y-0.5">
                    <iconify-icon icon="solar:letter-bold" class="text-base"></iconify-icon>
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleContact(e) {
    e.preventDefault();
    const btn = e.target.querySelector('button[type=submit]');
    btn.innerHTML = '<iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon> Terima kasih! Pesan terkirim.';
    btn.disabled = true;
    btn.style.background = '#28A745';
    e.target.reset();
    setTimeout(() => {
        btn.innerHTML = '<iconify-icon icon="solar:letter-bold" class="text-base"></iconify-icon> Kirim Pesan';
        btn.disabled = false;
        btn.style.background = '';
    }, 4000);
}
</script>
@endpush
@endsection
