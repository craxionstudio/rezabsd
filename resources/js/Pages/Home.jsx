import { Link, usePage } from '@inertiajs/react';
import SiteLayout from '../Layouts/SiteLayout';
import Seo from '../Components/Seo';
import ProdukCard from '../Components/ProdukCard';

export default function Home({ highlights, seo, jsonLd }) {
    const { settings } = usePage().props;

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <section className="border-b border-slate-200 bg-slate-50">
                <div className="mx-auto max-w-6xl px-4 py-16 text-center">
                    <p className="text-sm font-medium uppercase tracking-widest text-emerald-600">
                        {settings?.nama_agensi}
                    </p>
                    <h1 className="mt-3 text-4xl font-bold text-slate-900 sm:text-5xl">
                        Cari Rumah, Ruko, atau Kavling Impian Anda
                    </h1>
                    <p className="mt-4 text-lg text-slate-600">
                        Dibantu langsung oleh {settings?.nama_sales}, {settings?.jabatan} dari{' '}
                        {settings?.nama_agensi}.
                    </p>
                    <div className="mt-8 flex justify-center gap-4">
                        <Link
                            href="/produk"
                            className="rounded-full bg-slate-900 px-6 py-3 font-medium text-white hover:bg-slate-800"
                        >
                            Lihat Semua Produk
                        </Link>
                        {settings?.whatsapp && (
                            <a
                                href={`https://wa.me/${settings.whatsapp}`}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="rounded-full border border-slate-300 px-6 py-3 font-medium text-slate-700 hover:bg-white"
                            >
                                Chat WhatsApp
                            </a>
                        )}
                    </div>
                </div>
            </section>

            <section className="mx-auto max-w-6xl px-4 py-16">
                <div className="flex items-center justify-between">
                    <h2 className="text-2xl font-semibold text-slate-900">Listing Unggulan</h2>
                    <Link href="/produk" className="text-sm font-medium text-emerald-600 hover:underline">
                        Lihat semua &rarr;
                    </Link>
                </div>

                {highlights.length === 0 ? (
                    <p className="mt-6 text-slate-500">Belum ada produk yang ditayangkan.</p>
                ) : (
                    <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {highlights.map((produk) => (
                            <ProdukCard key={produk.slug} produk={produk} />
                        ))}
                    </div>
                )}
            </section>
        </SiteLayout>
    );
}
