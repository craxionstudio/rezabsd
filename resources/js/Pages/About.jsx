import { usePage } from "@inertiajs/react";
import SiteLayout from "../Layouts/SiteLayout";
import Seo from "../Components/Seo";
import { PortraitArt } from "../Components/PlaceholderArt";
import { renderWithEmphasis } from "../lib/text";
import { waLink } from "../lib/format";

export default function About({ content, seo, jsonLd }) {
    const { settings } = usePage().props;

    return (
        <SiteLayout>
            <Seo
                title={seo.title}
                description={seo.description}
                canonical={seo.canonical}
                jsonLd={jsonLd}
            />

            <section className="max-w-6xl mx-auto px-6 pt-8 pb-16 grid md:grid-cols-[0.8fr_1.2fr] gap-12 items-center">
                <div
                    className="relative aspect-square overflow-hidden"
                    style={{
                        clipPath: "polygon(0 5%, 100% 0, 100% 95%, 0 100%)",
                    }}
                >
                    {settings.foto_profil ? (
                        <img
                            src={settings.foto_profil}
                            alt={settings.nama_sales}
                            className="w-full h-full object-cover"
                        />
                    ) : (
                        <PortraitArt className="w-full h-full" />
                    )}
                </div>
                <div>
                    <p className="text-sm text-[#6E7C58] mb-4">
                        Sales properti {settings.nama_agensi}
                    </p>
                    <h1 className="font-display text-4xl md:text-5xl leading-[1.1] mb-6">
                        {renderWithEmphasis(content.hero_headline)}
                    </h1>
                    <p className="text-[#6B6459] text-lg max-w-lg leading-relaxed mb-6">
                        {content.hero_subtext}
                    </p>
                    <a
                        href={waLink(settings.whatsapp)}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block bg-[#1E1C18] text-[#F4F1E9] px-7 py-3.5 rounded-full text-sm hover:bg-[#332F28] transition-colors"
                    >
                        Chat via WhatsApp
                    </a>
                </div>
            </section>

            <section className="border-t border-[#DAD4C5]">
                <div className="max-w-3xl mx-auto px-6 py-16">
                    <h2 className="font-display text-2xl mb-8">Kredensial</h2>
                    <div className="divide-y divide-[#DAD4C5] text-sm">
                        <div className="flex justify-between py-4">
                            <span className="text-[#6B6459]">Afiliasi</span>
                            <span>{content.credential_afiliasi}</span>
                        </div>
                        <div className="flex justify-between py-4">
                            <span className="text-[#6B6459]">Area operasi</span>
                            <span>{content.credential_area}</span>
                        </div>
                        <div className="flex justify-between py-4">
                            <span className="text-[#6B6459]">Kontak</span>
                            <span>{content.credential_kontak}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section className="max-w-3xl mx-auto px-6 py-16 border-t border-[#DAD4C5]">
                <h2 className="font-display text-2xl mb-6">
                    Tentang {settings.nama_agensi}
                </h2>
                <p className="text-[#6B6459] leading-relaxed mb-8">
                    {content.linktown_description}
                </p>
                <div className="border-l-2 border-[#4C5740] pl-6 py-1">
                    <p className="text-sm text-[#6B6459] leading-relaxed">
                        {settings.disclaimer}
                    </p>
                </div>
            </section>
        </SiteLayout>
    );
}
