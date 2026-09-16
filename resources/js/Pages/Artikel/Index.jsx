import { Link } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';

export default function Index({ artikels, seo }) {
    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} />

            <section className="mx-auto max-w-5xl px-4 py-16">
                <h1 className="text-3xl font-bold text-slate-900">Artikel</h1>

                {artikels.length === 0 ? (
                    <p className="mt-10 text-slate-500">Belum ada artikel yang ditayangkan.</p>
                ) : (
                    <div className="mt-8 grid gap-6 sm:grid-cols-2">
                        {artikels.map((artikel) => (
                            <Link
                                key={artikel.slug}
                                href={`/artikel/${artikel.slug}`}
                                className="group block overflow-hidden rounded-xl border border-slate-200 transition hover:shadow-lg"
                            >
                                <div className="aspect-[16/9] w-full overflow-hidden bg-slate-100">
                                    {artikel.featured_image ? (
                                        <img
                                            src={artikel.featured_image}
                                            alt={artikel.judul}
                                            className="h-full w-full object-cover transition group-hover:scale-105"
                                        />
                                    ) : (
                                        <div className="flex h-full items-center justify-center text-slate-400">
                                            Tidak ada gambar
                                        </div>
                                    )}
                                </div>
                                <div className="p-4">
                                    {artikel.kategori && (
                                        <p className="text-xs font-medium uppercase tracking-wide text-emerald-600">
                                            {artikel.kategori}
                                        </p>
                                    )}
                                    <h2 className="mt-1 font-semibold text-slate-900">{artikel.judul}</h2>
                                    {artikel.tanggal_publish && (
                                        <p className="mt-1 text-sm text-slate-500">{artikel.tanggal_publish}</p>
                                    )}
                                </div>
                            </Link>
                        ))}
                    </div>
                )}
            </section>
        </SiteLayout>
    );
}
