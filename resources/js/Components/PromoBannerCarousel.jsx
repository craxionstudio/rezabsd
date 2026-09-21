import { useState } from 'react';
import { usePage } from '@inertiajs/react';
import { waLink } from '../lib/format';

export default function PromoBannerCarousel({ banners, headline = 'PROMO TERKINI' }) {
    const { settings } = usePage().props;
    const [index, setIndex] = useState(0);

    if (!banners || banners.length === 0) {
        return null;
    }

    const banner = banners[index % banners.length];
    const targetUrl =
        banner.link_url ||
        (settings?.whatsapp
            ? waLink(
                  settings.whatsapp,
                  `Halo, saya tertarik dengan promo ${banner.judul ? `"${banner.judul}"` : 'ini'}. Boleh info lebih lanjut?`
              )
            : null);

    function prev() {
        setIndex((current) => (current - 1 + banners.length) % banners.length);
    }

    function next() {
        setIndex((current) => (current + 1) % banners.length);
    }

    const image = (
        <div className="relative w-full overflow-hidden bg-[#EAE5D8] rounded-[15px]" style={{ borderRadius: '15px' }}>
            <div className="aspect-[3/4] md:hidden">
                <img src={banner.gambarMobile} alt={banner.judul ?? ''} className="w-full h-full object-cover rounded-[15px]" style={{ borderRadius: '15px' }} />
            </div>
            <div className="hidden md:block md:aspect-[16/6]">
                <img src={banner.gambarDesktop} alt={banner.judul ?? ''} className="w-full h-full object-cover rounded-[15px]" style={{ borderRadius: '15px' }} />
            </div>
        </div>
    );

    return (
        <section className="max-w-6xl mx-auto px-6 py-16 border-t border-[#DAD4C5]">
            <div className="flex flex-wrap items-center justify-between gap-4 mb-8">
                {headline && (
                    <h2 className="font-display text-3xl">{headline}</h2>
                )}
                {targetUrl && (
                    <a
                        href={targetUrl}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center gap-2 bg-[#1E1C18] text-[#F4F1E9] text-sm px-5 py-2.5 rounded-full hover:bg-[#332F28] transition-colors whitespace-nowrap"
                    >
                        <span>Get more info</span>
                        <span aria-hidden="true" className="text-base leading-none">→</span>
                    </a>
                )}
            </div>
            <div className="relative rounded-[15px] overflow-hidden" style={{ borderRadius: '15px' }}>
                {targetUrl ? (
                    <a href={targetUrl} target="_blank" rel="noopener noreferrer" className="block rounded-[15px] overflow-hidden" style={{ borderRadius: '15px' }}>
                        {image}
                    </a>
                ) : (
                    image
                )}

                {banners.length > 1 && (
                    <>
                        <button
                            type="button"
                            onClick={prev}
                            aria-label="Banner sebelumnya"
                            className="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-[#1E1C18] text-[#F4F1E9] flex items-center justify-center hover:bg-[#332F28] transition-colors z-10 cursor-pointer"
                        >
                            ‹
                        </button>
                        <button
                            type="button"
                            onClick={next}
                            aria-label="Banner berikutnya"
                            className="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-[#1E1C18] text-[#F4F1E9] flex items-center justify-center hover:bg-[#332F28] transition-colors z-10 cursor-pointer"
                        >
                            ›
                        </button>
                        <div className="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                            {banners.map((item, dotIndex) => (
                                <button
                                    key={dotIndex}
                                    type="button"
                                    onClick={() => setIndex(dotIndex)}
                                    aria-label={`Pindah ke banner ${dotIndex + 1}`}
                                    className={`w-2.5 h-2.5 rounded-full transition-all cursor-pointer ${
                                        dotIndex === index % banners.length ? 'bg-[#F4F1E9] scale-125' : 'bg-[#F4F1E9]/40 hover:bg-[#F4F1E9]/70'
                                    }`}
                                />
                            ))}
                        </div>
                    </>
                )}
            </div>
        </section>
    );
}
