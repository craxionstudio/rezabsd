import { router } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';
import ProdukListingCard from '../../Components/ProdukListingCard';

const statusOptions = [
    { value: '', label: 'Semua status' },
    { value: 'primary', label: 'Primary' },
    { value: 'secondary', label: 'Secondary' },
];

const listingTypeOptions = [
    { value: '', label: 'Jual & Sewa' },
    { value: 'jual', label: 'Jual' },
    { value: 'sewa', label: 'Sewa' },
];

export default function Index({ produks, tipeOptions, filters, seo, jsonLd }) {
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
                <div className="flex flex-wrap items-center gap-3">
                    <select
                        value={filters.tipe ?? ''}
                        onChange={(event) => updateFilter('tipe', event.target.value)}
                        className="px-4 py-2 rounded-full border border-[#DAD4C5] bg-[#F4F1E9] text-sm text-[#1E1C18]"
                    >
                        <option value="">Semua tipe</option>
                        {tipeOptions.map((tipe) => (
                            <option key={tipe.slug} value={tipe.slug}>
                                {tipe.nama}
                            </option>
                        ))}
                    </select>
                    <select
                        value={filters.status ?? ''}
                        onChange={(event) => updateFilter('status', event.target.value)}
                        className="px-4 py-2 rounded-full border border-[#DAD4C5] bg-[#F4F1E9] text-sm text-[#1E1C18]"
                    >
                        {statusOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                    <select
                        value={filters.listing_type ?? ''}
                        onChange={(event) => updateFilter('listing_type', event.target.value)}
                        className="px-4 py-2 rounded-full border border-[#DAD4C5] bg-[#F4F1E9] text-sm text-[#1E1C18]"
                    >
                        {listingTypeOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
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
