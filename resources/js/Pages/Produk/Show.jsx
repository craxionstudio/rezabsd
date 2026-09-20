import { Link, usePage } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';
import ProdukListingCard from '../../Components/ProdukListingCard';
import { produkArtFor } from '../../Components/PlaceholderArt';
import { waLink } from '../../lib/format';

const STATUS_LABEL = { primary: 'Primary', secondary: 'Secondary' };
const LISTING_TYPE_LABEL = { jual: 'Dijual', sewa: 'Disewakan' };
const GALLERY_FALLBACK_COUNT = 5;

export default function Show({ produk, related, seo, jsonLd }) {
    const { settings } = usePage().props;

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <div className="max-w-6xl mx-auto px-6 pt-4 pb-6 text-sm text-[#6B6459]">
                <Link href="/produk" className="hover:text-[#1E1C18] transition-colors">
                    Produk
                </Link>{' '}
                / <span className="text-[#1E1C18]">{produk.nama}</span>
            </div>

            {produk.tipeUnitNames.length > 0 && (
                <section className="max-w-6xl mx-auto px-6 pb-8">
                    <p className="text-sm text-[#6E7C58] mb-3">Tersedia tipe</p>
                    <div className="flex flex-wrap gap-2">
                        {produk.tipeUnitNames.map((nama) => (
                            <span key={nama} className="px-4 py-2 border border-[#DAD4C5] text-sm">
                                {nama}
                            </span>
                        ))}
                    </div>
                </section>
            )}

            <section className="max-w-6xl mx-auto px-6 pb-4">
                <div className="flex gap-3 h-[260px] overflow-x-auto">
                    {(produk.gallery.length > 0
                        ? produk.gallery
                        : Array.from({ length: GALLERY_FALLBACK_COUNT })
                    ).map((url, index) => {
                        const Art = produkArtFor(index);

                        return (
                            <div key={index} className="aspect-[3/4] h-full flex-shrink-0 overflow-hidden">
                                {url ? (
                                    <img src={url} alt={produk.nama} className="w-full h-full object-cover" />
                                ) : (
                                    <Art className="w-full h-full" />
                                )}
                            </div>
                        );
                    })}
                </div>
            </section>

            <section className="max-w-6xl mx-auto px-6 py-10 grid md:grid-cols-[1.3fr_1fr] gap-14 items-start">
                <div>
                    <p className="text-sm text-[#6E7C58] mb-3">
                        {STATUS_LABEL[produk.status]} · {produk.tipe} · {LISTING_TYPE_LABEL[produk.listing_type]}
                    </p>
                    <h1 className="font-display text-3xl md:text-4xl mb-3">{produk.nama}</h1>
                    <p className="font-display text-2xl mb-6">{produk.hargaLabel}</p>

                    {produk.promo.length > 0 && (
                        <ul className="flex flex-wrap gap-2 mb-8">
                            {produk.promo.map((item) => (
                                <li
                                    key={item}
                                    className="px-3 py-1.5 bg-[#EAE5D8] text-[#1E1C18] text-xs rounded-full"
                                >
                                    {item}
                                </li>
                            ))}
                        </ul>
                    )}

                    <div className="divide-y divide-[#DAD4C5] text-sm mb-10">
                        {produk.specRows.map((row) => (
                            <div key={row.label} className="flex justify-between py-3">
                                <span className="text-[#6B6459]">{row.label}</span>
                                <span>{row.value}</span>
                            </div>
                        ))}
                    </div>

                    {produk.deskripsi && (
                        <div
                            className="text-[#6B6459] leading-relaxed"
                            dangerouslySetInnerHTML={{ __html: produk.deskripsi }}
                        />
                    )}
                </div>

                <div className="bg-[#EAE5D8] p-6">
                    <p className="font-display text-lg mb-2">Tanya-tanya dulu?</p>
                    <p className="text-sm text-[#6B6459] mb-5 leading-relaxed">
                        {settings.nama_sales} yang jawab langsung, biasanya respons dalam hitungan menit.
                    </p>
                    <a
                        href={waLink(
                            settings.whatsapp,
                            `Halo, saya tertarik dengan produk "${produk.nama}". Boleh info lebih lanjut?`
                        )}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="block text-center bg-[#1E1C18] text-[#F4F1E9] px-6 py-3.5 rounded-full text-sm hover:bg-[#332F28] transition-colors"
                    >
                        Chat via WhatsApp
                    </a>
                </div>
            </section>

            {related.length > 0 && (
                <section className="max-w-6xl mx-auto px-6 py-16 border-t border-[#DAD4C5]">
                    <h2 className="font-display text-2xl mb-10">Listing lain di kawasan ini</h2>
                    <div className="grid md:grid-cols-3 gap-10">
                        {related.map((item, index) => (
                            <ProdukListingCard
                                key={item.slug}
                                produk={item}
                                index={index}
                                showSpecs={false}
                            />
                        ))}
                    </div>
                </section>
            )}
        </SiteLayout>
    );
}
