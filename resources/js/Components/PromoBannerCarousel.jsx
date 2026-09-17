import { useState } from 'react';

export default function PromoBannerCarousel({ banners }) {
    const [index, setIndex] = useState(0);

    if (banners.length === 0) {
        return null;
    }

    const banner = banners[index % banners.length];

    function prev() {
        setIndex((current) => (current - 1 + banners.length) % banners.length);
    }

    function next() {
        setIndex((current) => (current + 1) % banners.length);
    }

    const image = (
        <div className="relative w-full overflow-hidden bg-[#EAE5D8]">
            <div className="aspect-[3/4] md:hidden">
                <img src={banner.gambarMobile} alt={banner.judul ?? ''} className="w-full h-full object-cover" />
            </div>
            <div className="hidden md:block md:aspect-[16/6]">
                <img src={banner.gambarDesktop} alt={banner.judul ?? ''} className="w-full h-full object-cover" />
            </div>
        </div>
    );

    return (
        <section className="max-w-6xl mx-auto px-6 py-16">
            <div className="relative">
                {banner.link_url ? (
                    <a href={banner.link_url} target="_blank" rel="noopener noreferrer">
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
                            className="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-[#1E1C18] text-[#F4F1E9] flex items-center justify-center hover:bg-[#332F28] transition-colors"
                        >
                            ‹
                        </button>
                        <button
                            type="button"
                            onClick={next}
                            aria-label="Banner berikutnya"
                            className="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-[#1E1C18] text-[#F4F1E9] flex items-center justify-center hover:bg-[#332F28] transition-colors"
                        >
                            ›
                        </button>
                        <div className="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                            {banners.map((item, dotIndex) => (
                                <span
                                    key={dotIndex}
                                    className={`w-2 h-2 rounded-full ${
                                        dotIndex === index % banners.length ? 'bg-[#F4F1E9]' : 'bg-[#F4F1E9]/40'
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
