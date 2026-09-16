import { router } from '@inertiajs/react';
import SiteLayout from '../../Layouts/SiteLayout';
import Seo from '../../Components/Seo';
import ProdukCard from '../../Components/ProdukCard';

const tipeOptions = [
    { value: '', label: 'Semua Tipe' },
    { value: 'rumah', label: 'Rumah' },
    { value: 'ruko', label: 'Ruko' },
    { value: 'kavling', label: 'Kavling' },
];

const statusOptions = [
    { value: '', label: 'Semua Status' },
    { value: 'primary', label: 'Primary' },
    { value: 'secondary', label: 'Secondary' },
];

export default function Index({ produks, filters, seo, jsonLd }) {
    function updateFilter(key, value) {
        router.get('/produk', { ...filters, [key]: value || undefined }, { preserveState: true, replace: true });
    }

    return (
        <SiteLayout>
            <Seo title={seo.title} description={seo.description} jsonLd={jsonLd} />

            <section className="mx-auto max-w-6xl px-4 py-16">
                <h1 className="text-3xl font-bold text-slate-900">Produk</h1>

                <div className="mt-6 flex flex-wrap gap-4">
                    <select
                        value={filters.tipe ?? ''}
                        onChange={(event) => updateFilter('tipe', event.target.value)}
                        className="rounded-lg border border-slate-300 px-4 py-2 text-sm"
                    >
                        {tipeOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                    <select
                        value={filters.status ?? ''}
                        onChange={(event) => updateFilter('status', event.target.value)}
                        className="rounded-lg border border-slate-300 px-4 py-2 text-sm"
                    >
                        {statusOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                </div>

                {produks.length === 0 ? (
                    <p className="mt-10 text-slate-500">Tidak ada produk yang cocok dengan filter ini.</p>
                ) : (
                    <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {produks.map((produk) => (
                            <ProdukCard key={produk.slug} produk={produk} />
                        ))}
                    </div>
                )}
            </section>
        </SiteLayout>
    );
}
