import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';

export default function Show({ title, content, seo }) {
    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} />

            <article className="max-w-3xl mx-auto px-6 py-16">
                <h1 className="font-display text-3xl md:text-4xl mb-8">{title}</h1>
                {content ? (
                    <div
                        className="prose prose-neutral max-w-none text-[#6B6459]"
                        dangerouslySetInnerHTML={{ __html: content }}
                    />
                ) : (
                    <p className="text-[#6B6459]">Konten belum diisi.</p>
                )}
            </article>
        </SiteLayout>
    );
}
