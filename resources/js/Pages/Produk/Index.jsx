import { router } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';
import ProdukListingCard from '../../Components/ProdukListingCard';

const tipeTabs = [
    { value: '', label: 'Semua tipe' },
    { value: 'rumah', label: 'Rumah' },
    { value: 'ruko', label: 'Ruko' },
    { value: 'kavling', label: 'Kavling' },
];

const statusTabs = [
    { value: '', label: 'Semua status' },
    { value: 'primary', label: 'Primary' },
    { value: 'secondary', label: 'Secondary' },
];

export default function Index({ produks, filters, seo, jsonLd }) {
    function updateFilter(key, value) {
        router.get(
            '/produk',
            { ...filters, [key]: value || undefined },
            { preserveState: true, preserveScroll: true, replace: true }
        );
    }

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <section className="max-w-6xl mx-auto px-6 pt-8 pb-10">
                <h1 className="font-display text-4xl md:text-5xl mb-4">Semua produk</h1>
                <p className="text-[#6B6459] text-lg max-w-lg">
                    Listing rumah, ruko, dan kavling — primary dari pengembang maupun secondary dari pemilik lama,
                    semua di kawasan ini.
                </p>
            </section>

            <section className="max-w-6xl mx-auto px-6 pb-6 border-t border-[#DAD4C5] pt-8">
                <div className="flex flex-wrap items-center gap-2 mb-4">
                    {tipeTabs.map((tab) => (
                        <button
                            key={tab.value}
                            type="button"
                            onClick={() => updateFilter('tipe', tab.value)}
                            className={
                                (filters.tipe ?? '') === tab.value
                                    ? 'px-4 py-2 rounded-full bg-[#1E1C18] text-[#F4F1E9] text-sm'
                                    : 'px-4 py-2 rounded-full text-[#6B6459] text-sm hover:bg-[#EAE5D8] transition-colors'
                            }
                        >
                            {tab.label}
                        </button>
                    ))}
                </div>
                <div className="flex flex-wrap items-center gap-2">
                    {statusTabs.map((tab) => (
                        <button
                            key={tab.value}
                            type="button"
                            onClick={() => updateFilter('status', tab.value)}
                            className={
                                (filters.status ?? '') === tab.value
                                    ? 'px-4 py-1.5 rounded-full border border-[#DAD4C5] text-sm'
                                    : 'px-4 py-1.5 rounded-full border border-transparent text-[#6B6459] text-sm hover:bg-[#EAE5D8] transition-colors'
                            }
                        >
                            {tab.label}
                        </button>
                    ))}
                </div>
            </section>

            <section className="max-w-6xl mx-auto px-6 py-10">
                {produks.length === 0 ? (
                    <p className="text-[#6B6459]">Tidak ada produk yang cocok dengan filter ini.</p>
                ) : (
                    <div className="grid md:grid-cols-3 gap-x-10 gap-y-12">
                        {produks.map((produk, index) => (
                            <ProdukListingCard key={produk.slug} produk={produk} index={index} />
                        ))}
                    </div>
                )}
            </section>
        </SiteLayout>
    );
}
