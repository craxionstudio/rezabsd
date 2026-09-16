import { Link, usePage } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';
import ProdukListingCard from '../../Components/ProdukListingCard';
import { DetailMainArt, DetailThumb1Art, DetailThumb2Art, DetailThumb3Art } from '../../Components/PlaceholderArt';
import { formatHargaSingkat, waLink } from '../../lib/format';

const TIPE_LABEL = { rumah: 'Rumah', ruko: 'Ruko', kavling: 'Kavling' };
const STATUS_LABEL = { primary: 'Primary', secondary: 'Secondary' };

function GalleryImage({ url, Fallback, className }) {
    return url ? (
        <img src={url} alt="" className={`${className} object-cover`} />
    ) : (
        <Fallback className={className} />
    );
}

export default function Show({ produk, related, seo, jsonLd }) {
    const { settings } = usePage().props;
    const [main, thumb1, thumb2, thumb3] = produk.gallery;

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <div className="max-w-6xl mx-auto px-6 pt-4 pb-6 text-sm text-[#6B6459]">
                <Link href="/produk" className="hover:text-[#1E1C18] transition-colors">
                    Produk
                </Link>{' '}
                / <span className="text-[#1E1C18]">{produk.nama}</span>
            </div>

            <section className="max-w-6xl mx-auto px-6 pb-4">
                <div className="grid md:grid-cols-[2fr_1fr] gap-3">
                    <div className="h-[380px] overflow-hidden">
                        <GalleryImage url={main} Fallback={DetailMainArt} className="w-full h-full" />
                    </div>
                    <div className="grid grid-rows-3 gap-3">
                        <div className="overflow-hidden">
                            <GalleryImage url={thumb1} Fallback={DetailThumb1Art} className="w-full h-full" />
                        </div>
                        <div className="overflow-hidden">
                            <GalleryImage url={thumb2} Fallback={DetailThumb2Art} className="w-full h-full" />
                        </div>
                        <div className="overflow-hidden">
                            <GalleryImage url={thumb3} Fallback={DetailThumb3Art} className="w-full h-full" />
                        </div>
                    </div>
                </div>
            </section>

            <section className="max-w-6xl mx-auto px-6 py-10 grid md:grid-cols-[1.3fr_1fr] gap-14 items-start">
                <div>
                    <p className="text-sm text-[#6E7C58] mb-3">
                        {STATUS_LABEL[produk.status]} · {TIPE_LABEL[produk.tipe]}
                    </p>
                    <h1 className="font-display text-3xl md:text-4xl mb-3">{produk.nama}</h1>
                    <p className="font-display text-2xl mb-8">{formatHargaSingkat(produk.harga)}</p>

                    <div className="divide-y divide-[#DAD4C5] text-sm mb-10">
                        <div className="flex justify-between py-3">
                            <span className="text-[#6B6459]">Luas tanah</span>
                            <span>{produk.luas_tanah ?? '-'} m²</span>
                        </div>
                        <div className="flex justify-between py-3">
                            <span className="text-[#6B6459]">Luas bangunan</span>
                            <span>{produk.luas_bangunan ?? '-'} m²</span>
                        </div>
                        <div className="flex justify-between py-3">
                            <span className="text-[#6B6459]">Kamar tidur</span>
                            <span>{produk.kamar_tidur ?? '-'}</span>
                        </div>
                        <div className="flex justify-between py-3">
                            <span className="text-[#6B6459]">Kamar mandi</span>
                            <span>{produk.kamar_mandi ?? '-'}</span>
                        </div>
                        {produk.lokasi && (
                            <div className="flex justify-between py-3">
                                <span className="text-[#6B6459]">Lokasi</span>
                                <span>{produk.lokasi}</span>
                            </div>
                        )}
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
                                imgHeightClass="h-48"
                            />
                        ))}
                    </div>
                </section>
            )}
        </SiteLayout>
    );
}
