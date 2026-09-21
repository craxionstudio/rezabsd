import { Link } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';
import { ArtikelFeaturedArt, produkArtFor } from '../../Components/PlaceholderArt';

export default function Index({ featured, artikels, kategoriOptions, activeKategoriSlug, kategoriInfo, seo, jsonLd }) {
    const isKategoriMode = Boolean(kategoriInfo);

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} canonical={seo.canonical} jsonLd={jsonLd} />

            {isKategoriMode ? (
                <section className="max-w-6xl mx-auto px-6 pt-8 pb-10">
                    <div className="text-sm text-[#6B6459] mb-4">
                        <Link href="/artikel" className="hover:text-[#1E1C18] transition-colors">
                            Artikel
                        </Link>{' '}
                        / <span className="text-[#1E1C18]">{kategoriInfo.nama}</span>
                    </div>
                    <h1 className="font-display text-4xl md:text-5xl mb-4">{kategoriInfo.nama}</h1>
                    {kategoriInfo.deskripsi_singkat && (
                        <p className="text-[#6B6459] text-lg max-w-lg">{kategoriInfo.deskripsi_singkat}</p>
                    )}
                </section>
            ) : (
                <>
                    <section className="max-w-6xl mx-auto px-6 pt-8 pb-10">
                        <h1 className="font-display text-4xl md:text-5xl mb-4">Cerita &amp; tips</h1>
                        <p className="text-[#6B6459] text-lg max-w-lg">
                            Info seputar kawasan ini dan tips praktis buat yang lagi cari rumah, ruko, atau kavling.
                        </p>
                    </section>

                    <section className="max-w-6xl mx-auto px-6 pb-8 border-t border-[#DAD4C5] pt-8">
                        <div className="flex flex-wrap gap-2">
                            <Link
                                href="/artikel"
                                className={`px-4 py-2 rounded-full text-sm transition-colors ${
                                    !activeKategoriSlug
                                        ? 'bg-[#1E1C18] text-[#F4F1E9]'
                                        : 'text-[#6B6459] hover:bg-[#EAE5D8]'
                                }`}
                            >
                                Semua
                            </Link>
                            {kategoriOptions.map((kategori) => (
                                <Link
                                    key={kategori.slug}
                                    href={`/artikel/kategori/${kategori.slug}`}
                                    className={`px-4 py-2 rounded-full text-sm transition-colors ${
                                        activeKategoriSlug === kategori.slug
                                            ? 'bg-[#1E1C18] text-[#F4F1E9]'
                                            : 'text-[#6B6459] hover:bg-[#EAE5D8]'
                                    }`}
                                >
                                    {kategori.nama}
                                </Link>
                            ))}
                        </div>
                    </section>

                    {featured && (
                        <section className="max-w-6xl mx-auto px-6 pb-16">
                            <Link href={`/artikel/${featured.slug}`} className="grid md:grid-cols-2 gap-8 items-center group">
                                <div className="h-72 overflow-hidden">
                                    {featured.featured_image ? (
                                        <img
                                            src={featured.featured_image}
                                            alt={featured.judul}
                                            className="w-full h-full object-cover"
                                        />
                                    ) : (
                                        <ArtikelFeaturedArt className="w-full h-full" />
                                    )}
                                </div>
                                <div>
                                    {featured.kategori && (
                                        <p className="text-sm text-[#6E7C58] mb-3">{featured.kategori}</p>
                                    )}
                                    <p className="font-display text-2xl md:text-3xl mb-3 group-hover:underline">
                                        {featured.judul}
                                    </p>
                                    <p className="text-[#6B6459] leading-relaxed mb-4">{featured.excerpt}</p>
                                    {featured.tanggal_publish && (
                                        <p className="text-sm text-[#8A8471]">{featured.tanggal_publish}</p>
                                    )}
                                </div>
                            </Link>
                        </section>
                    )}
                </>
            )}

            <section className="max-w-6xl mx-auto px-6 pb-16 border-t border-[#DAD4C5] pt-12">
                {artikels.length === 0 ? (
                    <p className="text-[#6B6459]">Belum ada artikel yang ditayangkan.</p>
                ) : (
                    <div className="grid md:grid-cols-3 gap-x-10 gap-y-12">
                        {artikels.map((artikel, index) => {
                            const Art = produkArtFor(index);

                            return (
                                <Link key={artikel.slug} href={`/artikel/${artikel.slug}`} className="group">
                                    <div className="h-52 mb-4 overflow-hidden">
                                        {artikel.featured_image_thumb ? (
                                            <img
                                                src={artikel.featured_image_thumb}
                                                alt={artikel.judul}
                                                className="w-full h-full object-cover transition group-hover:scale-105"
                                            />
                                        ) : (
                                            <Art className="w-full h-full" />
                                        )}
                                    </div>
                                    {artikel.kategori && (
                                        <p className="text-sm text-[#6E7C58] mb-2">{artikel.kategori}</p>
                                    )}
                                    <p className="font-display text-lg mb-2 group-hover:underline">{artikel.judul}</p>
                                    <p className="text-[#6B6459] text-sm leading-relaxed mb-2">{artikel.excerpt}</p>
                                    {artikel.tanggal_publish && (
                                        <p className="text-xs text-[#8A8471]">{artikel.tanggal_publish}</p>
                                    )}
                                </Link>
                            );
                        })}
                    </div>
                )}
            </section>
        </SiteLayout>
    );
}
