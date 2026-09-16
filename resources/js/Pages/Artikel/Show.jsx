import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';

export default function Show({ artikel, seo, jsonLd }) {
    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <article className="mx-auto max-w-3xl px-4 py-16">
                {artikel.kategori && (
                    <p className="text-sm font-medium uppercase tracking-wide text-emerald-600">{artikel.kategori}</p>
                )}
                <h1 className="mt-2 text-3xl font-bold text-slate-900">{artikel.judul}</h1>
                {artikel.tanggal_publish && <p className="mt-2 text-sm text-slate-500">{artikel.tanggal_publish}</p>}

                {artikel.featured_image && (
                    <img
                        src={artikel.featured_image}
                        alt={artikel.judul}
                        className="mt-6 aspect-[16/9] w-full rounded-xl object-cover"
                    />
                )}

                <div
                    className="prose prose-slate mt-8 max-w-none"
                    dangerouslySetInnerHTML={{ __html: artikel.konten }}
                />
            </article>
        </SiteLayout>
    );
}
