import SiteLayout from '../Layouts/SiteLayout';
import Seo from '../Components/Seo';

export default function About({ settings, seo, jsonLd }) {
    const socials = [
        { label: 'Instagram', url: settings.instagram },
        { label: 'Facebook', url: settings.facebook },
        { label: 'TikTok', url: settings.tiktok },
    ].filter((social) => social.url);

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <section className="mx-auto max-w-3xl px-4 py-16">
                <h1 className="text-3xl font-bold text-slate-900">Tentang {settings.nama_sales}</h1>
                <p className="mt-2 text-slate-500">
                    {settings.jabatan} di {settings.nama_agensi}
                </p>

                {settings.bio && <p className="mt-6 whitespace-pre-line text-slate-700">{settings.bio}</p>}

                <h2 className="mt-10 text-xl font-semibold text-slate-900">Tentang {settings.nama_agensi}</h2>
                <p className="mt-2 text-slate-700">
                    {settings.nama_agensi} adalah agensi properti tempat {settings.nama_sales} bernaung sebagai
                    sales marketing, membantu calon pembeli menemukan hunian yang tepat.
                </p>

                {socials.length > 0 && (
                    <div className="mt-6 flex gap-4">
                        {socials.map((social) => (
                            <a
                                key={social.label}
                                href={social.url}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-sm font-medium text-emerald-600 hover:underline"
                            >
                                {social.label}
                            </a>
                        ))}
                    </div>
                )}

                <div className="mt-10 rounded-xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-900">
                    <p className="font-semibold">Disclaimer</p>
                    <p className="mt-1">{settings.disclaimer}</p>
                </div>
            </section>
        </SiteLayout>
    );
}
