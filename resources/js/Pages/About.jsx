import { usePage } from '@inertiajs/react';
import SiteLayout from '../Layouts/SiteLayout';
import Seo from '../Components/Seo';
import { PortraitArt } from '../Components/PlaceholderArt';
import { displayPhone, waLink } from '../lib/format';

export default function About({ seo, jsonLd }) {
    const { settings } = usePage().props;
    const bioParagraphs = (settings.bio ?? '').split(/\n{2,}/).filter(Boolean);

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <section className="max-w-6xl mx-auto px-6 pt-8 pb-16 grid md:grid-cols-[0.8fr_1.2fr] gap-12 items-center">
                <div
                    className="relative aspect-square overflow-hidden"
                    style={{ clipPath: 'polygon(0 5%, 100% 0, 100% 95%, 0 100%)' }}
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
                    <p className="text-sm text-[#6E7C58] mb-4">Sales properti {settings.nama_agensi}</p>
                    <h1 className="font-display text-4xl md:text-5xl leading-[1.1] mb-6">
                        Halo, saya {settings.nama_sales.split(' ')[0]} — bantu Anda cari unit yang{' '}
                        <em className="italic">pas</em>
                    </h1>
                    <p className="text-[#6B6459] text-lg max-w-lg leading-relaxed mb-6">
                        Lima tahun fokus di kawasan ini, dari unit primary langsung dari pengembang sampai secondary
                        dari pemilik lama. Saya pegang sendiri tiap konsultasi, bukan dilempar ke tim lain.
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

            <section className="max-w-3xl mx-auto px-6 py-16 border-t border-[#DAD4C5]">
                <h2 className="font-display text-2xl mb-6">Latar belakang</h2>
                {bioParagraphs.length > 0 ? (
                    bioParagraphs.map((paragraph, index) => (
                        <p
                            key={index}
                            className={`text-[#6B6459] leading-relaxed ${index < bioParagraphs.length - 1 ? 'mb-4' : ''}`}
                        >
                            {paragraph}
                        </p>
                    ))
                ) : (
                    <p className="text-[#6B6459] leading-relaxed">Belum ada bio yang ditambahkan.</p>
                )}
            </section>

            <section className="border-t border-[#DAD4C5]">
                <div className="max-w-3xl mx-auto px-6 py-16">
                    <h2 className="font-display text-2xl mb-8">Kredensial</h2>
                    <div className="divide-y divide-[#DAD4C5] text-sm">
                        <div className="flex justify-between py-4">
                            <span className="text-[#6B6459]">Afiliasi</span>
                            <span>{settings.nama_agensi} — agen properti</span>
                        </div>
                        <div className="flex justify-between py-4">
                            <span className="text-[#6B6459]">Area operasi</span>
                            <span>Kawasan ini saja</span>
                        </div>
                        <div className="flex justify-between py-4">
                            <span className="text-[#6B6459]">Pengalaman</span>
                            <span>5 tahun, 50+ unit terjual</span>
                        </div>
                        {settings.whatsapp && (
                            <div className="flex justify-between py-4">
                                <span className="text-[#6B6459]">Kontak</span>
                                <span>{displayPhone(settings.whatsapp)}</span>
                            </div>
                        )}
                    </div>
                </div>
            </section>

            <section className="max-w-3xl mx-auto px-6 py-16 border-t border-[#DAD4C5]">
                <h2 className="font-display text-2xl mb-6">Tentang {settings.nama_agensi}</h2>
                <p className="text-[#6B6459] leading-relaxed mb-8">
                    {settings.nama_agensi} adalah agen properti tempat saya bernaung. Bukan pengembang, bukan
                    pengelola kawasan — perannya menghubungkan pembeli dengan unit primary dari pengembang maupun
                    secondary dari pemilik lama, lewat sales seperti saya yang pegang area tertentu.
                </p>
                <div className="border-l-2 border-[#4C5740] pl-6 py-1">
                    <p className="text-sm text-[#6B6459] leading-relaxed">{settings.disclaimer}</p>
                </div>
            </section>
        </SiteLayout>
    );
}
