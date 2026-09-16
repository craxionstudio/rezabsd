import { usePage } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';
import ProdukCard from '../../Components/ProdukCard';
import { formatRupiah } from '../../lib/format';

export default function Show({ produk, related, seo, jsonLd }) {
    const { settings } = usePage().props;

    const waLink = settings?.whatsapp
        ? `https://wa.me/${settings.whatsapp}?text=${encodeURIComponent(
              `Halo, saya tertarik dengan produk "${produk.nama}". Boleh info lebih lanjut?`
          )}`
        : null;

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <section className="mx-auto max-w-5xl px-4 py-12">
                {produk.gallery.length > 0 && (
                    <div className="grid grid-cols-2 gap-2 overflow-hidden rounded-xl sm:grid-cols-4">
                        {produk.gallery.map((url) => (
                            <img key={url} src={url} alt={produk.nama} className="aspect-square w-full object-cover" />
                        ))}
                    </div>
                )}

                <div className="mt-8 grid gap-8 lg:grid-cols-3">
                    <div className="lg:col-span-2">
                        <p className="text-sm font-medium uppercase tracking-wide text-emerald-600">
                            {produk.tipe} · {produk.status}
                        </p>
                        <h1 className="mt-1 text-3xl font-bold text-slate-900">{produk.nama}</h1>
                        {produk.lokasi && <p className="mt-1 text-slate-500">{produk.lokasi}</p>}

                        <dl className="mt-6 grid grid-cols-2 gap-4 rounded-xl border border-slate-200 p-4 text-sm sm:grid-cols-4">
                            <div>
                                <dt className="text-slate-500">LT</dt>
                                <dd className="font-semibold">{produk.luas_tanah ?? '-'} m²</dd>
                            </div>
                            <div>
                                <dt className="text-slate-500">LB</dt>
                                <dd className="font-semibold">{produk.luas_bangunan ?? '-'} m²</dd>
                            </div>
                            <div>
                                <dt className="text-slate-500">Kamar Tidur</dt>
                                <dd className="font-semibold">{produk.kamar_tidur ?? '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-slate-500">Kamar Mandi</dt>
                                <dd className="font-semibold">{produk.kamar_mandi ?? '-'}</dd>
                            </div>
                        </dl>

                        {produk.deskripsi && (
                            <div
                                className="prose prose-slate mt-6 max-w-none"
                                dangerouslySetInnerHTML={{ __html: produk.deskripsi }}
                            />
                        )}
                    </div>

                    <aside className="h-fit rounded-xl border border-slate-200 p-6">
                        <p className="text-sm text-slate-500">Harga</p>
                        <p className="text-2xl font-bold text-slate-900">{formatRupiah(produk.harga)}</p>
                        {waLink && (
                            <a
                                href={waLink}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="mt-4 block rounded-full bg-emerald-600 px-6 py-3 text-center font-medium text-white hover:bg-emerald-700"
                            >
                                Tanya via WhatsApp
                            </a>
                        )}
                    </aside>
                </div>

                {related.length > 0 && (
                    <div className="mt-16">
                        <h2 className="text-xl font-semibold text-slate-900">Produk Terkait</h2>
                        <div className="mt-6 grid gap-6 sm:grid-cols-3">
                            {related.map((item) => (
                                <ProdukCard key={item.slug} produk={item} />
                            ))}
                        </div>
                    </div>
                )}
            </section>
        </SiteLayout>
    );
}
