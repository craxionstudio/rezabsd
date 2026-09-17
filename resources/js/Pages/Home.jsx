import { Link, usePage } from '@inertiajs/react';
import SiteLayout from '../Layouts/SiteLayout';
import Seo from '../Components/Seo';
import ProdukListingCard from '../Components/ProdukListingCard';
import {
    HeroKawasanArt,
    TestimonialAvatarArt,
    ArtikelFeaturedArt,
    ArtikelIconKprArt,
    ArtikelIconCompareArt,
} from '../Components/PlaceholderArt';
import { renderWithEmphasis } from '../lib/text';
import { waLink } from '../lib/format';

const tipeTabs = [
    { value: '', label: 'Semua' },
    { value: 'rumah', label: 'Rumah' },
    { value: 'ruko', label: 'Ruko' },
    { value: 'kavling', label: 'Kavling' },
];

export default function Home({ content, highlights, artikelHighlights, seo, jsonLd }) {
    const { settings } = usePage().props;
    const [featuredArtikel, ...smallArtikels] = artikelHighlights;

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <section className="max-w-6xl mx-auto px-6 pt-8 pb-16 grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <p className="text-sm text-[#6E7C58] mb-4">{content.hero_eyebrow}</p>
                    <h1 className="font-display text-5xl md:text-6xl leading-[1.05] mb-6">
                        {renderWithEmphasis(content.hero_headline)}
                    </h1>
                    <p className="text-[#6B6459] text-lg max-w-md mb-8 leading-relaxed">{content.hero_subtext}</p>
                    <Link
                        href="/produk"
                        className="inline-block bg-[#1E1C18] text-[#F4F1E9] px-7 py-3.5 rounded-full text-sm hover:bg-[#332F28] transition-colors"
                    >
                        {content.hero_cta_label}
                    </Link>
                </div>
                <div className="relative h-[420px] overflow-hidden" style={{ clipPath: 'polygon(0 7%, 100% 0, 100% 100%, 0 93%)' }}>
                    {content.hero_image ? (
                        <img src={content.hero_image} alt={settings.nama_agensi} className="w-full h-full object-cover" />
                    ) : (
                        <HeroKawasanArt className="w-full h-full" />
                    )}
                </div>
            </section>

            <section className="max-w-6xl mx-auto px-6 py-16 border-t border-[#DAD4C5]">
                <div className="flex flex-wrap items-end justify-between gap-4 mb-10">
                    <h2 className="font-display text-3xl">Listing pilihan</h2>
                    <div className="flex gap-2 text-sm">
                        {tipeTabs.map((tab) => (
                            <Link
                                key={tab.value}
                                href={tab.value ? `/produk?tipe=${tab.value}` : '/produk'}
                                className={
                                    tab.value === ''
                                        ? 'px-4 py-2 rounded-full bg-[#1E1C18] text-[#F4F1E9]'
                                        : 'px-4 py-2 rounded-full text-[#6B6459] hover:bg-[#EAE5D8] transition-colors'
                                }
                            >
                                {tab.label}
                            </Link>
                        ))}
                    </div>
                </div>

                {highlights.length === 0 ? (
                    <p className="text-[#6B6459]">Belum ada produk yang ditayangkan.</p>
                ) : (
                    <div className="grid md:grid-cols-3 gap-10">
                        {highlights.map((produk, index) => (
                            <ProdukListingCard
                                key={produk.slug}
                                produk={produk}
                                index={index}
                                showTipeInLabel={false}
                            />
                        ))}
                    </div>
                )}
            </section>

            <section className="border-t border-[#DAD4C5]">
                <div className="max-w-6xl mx-auto px-6 py-16">
                    <div className="flex flex-col md:flex-row md:divide-x divide-[#DAD4C5]">
                        <div className="flex-1 px-0 md:px-6 first:md:pl-0 mb-8 md:mb-0">
                            <p className="font-display text-4xl mb-1">{content.stat_1_value}</p>
                            <p className="text-sm text-[#6B6459]">{content.stat_1_label}</p>
                        </div>
                        <div className="flex-1 px-0 md:px-6 mb-8 md:mb-0">
                            <p className="font-display text-4xl mb-1">{content.stat_2_value}</p>
                            <p className="text-sm text-[#6B6459]">{content.stat_2_label}</p>
                        </div>
                        <div className="flex-1 px-0 md:px-6">
                            <p className="font-display text-4xl mb-1">{content.stat_3_value}</p>
                            <p className="text-sm text-[#6B6459]">{content.stat_3_label}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section className="bg-[#1E1C18] text-[#F4F1E9]">
                <div className="max-w-6xl mx-auto px-6 py-20">
                    <h2 className="font-display text-3xl mb-12 max-w-md">
                        Prosesnya dari awal sampai serah terima kunci
                    </h2>
                    <div className="grid md:grid-cols-3 gap-10">
                        <div>
                            <p className="font-display text-2xl text-[#9CA786] mb-3">01</p>
                            <p className="font-display text-lg mb-2">{content.process_step_1_title}</p>
                            <p className="text-sm text-[#B8B2A2] leading-relaxed">{content.process_step_1_desc}</p>
                        </div>
                        <div>
                            <p className="font-display text-2xl text-[#9CA786] mb-3">02</p>
                            <p className="font-display text-lg mb-2">{content.process_step_2_title}</p>
                            <p className="text-sm text-[#B8B2A2] leading-relaxed">{content.process_step_2_desc}</p>
                        </div>
                        <div>
                            <p className="font-display text-2xl text-[#9CA786] mb-3">03</p>
                            <p className="font-display text-lg mb-2">{content.process_step_3_title}</p>
                            <p className="text-sm text-[#B8B2A2] leading-relaxed">{content.process_step_3_desc}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section className="max-w-3xl mx-auto px-6 py-20 text-center">
                <div className="w-14 h-14 rounded-full mx-auto mb-6 overflow-hidden">
                    <TestimonialAvatarArt className="w-full h-full" />
                </div>
                <p className="font-display text-2xl italic leading-relaxed mb-4">
                    &ldquo;{content.testimonial_quote}&rdquo;
                </p>
                <p className="text-sm text-[#6B6459]">{content.testimonial_name}</p>
            </section>

            {artikelHighlights.length > 0 && (
                <section className="max-w-6xl mx-auto px-6 py-16 border-t border-[#DAD4C5]">
                    <h2 className="font-display text-3xl mb-10">Cerita &amp; tips</h2>
                    <div className="grid md:grid-cols-2 gap-10">
                        <Link href={`/artikel/${featuredArtikel.slug}`} className="group block">
                            <div className="h-64 mb-4 overflow-hidden">
                                {featuredArtikel.featured_image ? (
                                    <img
                                        src={featuredArtikel.featured_image}
                                        alt={featuredArtikel.judul}
                                        className="w-full h-full object-cover transition group-hover:scale-105"
                                    />
                                ) : (
                                    <ArtikelFeaturedArt className="w-full h-full" />
                                )}
                            </div>
                            <p className="font-display text-xl mb-2">{featuredArtikel.judul}</p>
                            <p className="text-[#6B6459] text-sm leading-relaxed">{featuredArtikel.excerpt}</p>
                        </Link>
                        <div className="flex flex-col gap-8 justify-center">
                            {smallArtikels.map((artikel, index) => {
                                const Icon = index === 0 ? ArtikelIconKprArt : ArtikelIconCompareArt;
                                const gradient =
                                    index === 0
                                        ? 'linear-gradient(165deg,#C9C2AE,#A79F87)'
                                        : 'linear-gradient(165deg,#A9A28E,#6E7C58)';

                                return (
                                    <Link key={artikel.slug} href={`/artikel/${artikel.slug}`} className="flex gap-4 group">
                                        <div
                                            className="w-24 h-24 shrink-0 flex items-center justify-center"
                                            style={{ background: gradient }}
                                        >
                                            <Icon className="w-8 h-8" />
                                        </div>
                                        <div>
                                            <p className="font-display text-base mb-1">{artikel.judul}</p>
                                            <p className="text-[#6B6459] text-sm">{artikel.excerpt}</p>
                                        </div>
                                    </Link>
                                );
                            })}
                        </div>
                    </div>
                </section>
            )}

            <section className="bg-[#1E1C18] text-[#F4F1E9]">
                <div className="max-w-3xl mx-auto px-6 py-20 text-center">
                    <h2 className="font-display text-3xl mb-4">{content.cta_banner_title}</h2>
                    <p className="text-[#B8B2A2] mb-8">{content.cta_banner_subtitle}</p>
                    <a
                        href={waLink(settings.whatsapp)}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block bg-[#F4F1E9] text-[#1E1C18] px-7 py-3.5 rounded-full text-sm hover:bg-white transition-colors"
                    >
                        {content.cta_banner_button_label}
                    </a>
                </div>
            </section>
        </SiteLayout>
    );
}
