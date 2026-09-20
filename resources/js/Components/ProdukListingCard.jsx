import { Link } from '@inertiajs/react';
import { produkArtFor } from './PlaceholderArt';

const STATUS_LABEL = { primary: 'Primary', secondary: 'Secondary' };

export default function ProdukListingCard({ produk, index = 0, showTipeInLabel = true, showSpecs = true }) {
    const Art = produkArtFor(index);
    const label = showTipeInLabel
        ? `${STATUS_LABEL[produk.status]} · ${produk.tipe}`
        : STATUS_LABEL[produk.status];

    let specs = produk.hargaLabel;
    if (produk.listing_type === 'sewa') {
        specs += ' · Disewakan';
    }
    if (showSpecs) {
        if (produk.tipeSlug === 'apartment' && produk.kamar_tidur !== null && produk.kamar_tidur !== undefined) {
            specs += ` · ${produk.kamar_tidur === 0 ? 'Studio' : `${produk.kamar_tidur}BR`}`;
        } else if (produk.tipeSlug === 'ruko' && produk.kamar_mandi) {
            specs += ` · ${produk.kamar_mandi} toilet`;
        } else if (produk.kamar_tidur || produk.kamar_mandi) {
            specs += ` · ${produk.kamar_tidur ?? '-'} KT, ${produk.kamar_mandi ?? '-'} KM`;
        } else if (produk.luas_tanah) {
            specs += ` · ${produk.luas_tanah} m²`;
        }
    }

    return (
        <Link href={`/produk/${produk.slug}`} className="group block">
            <div className="aspect-[3/4] mb-4 overflow-hidden">
                {produk.cover ? (
                    <img
                        src={produk.cover}
                        alt={produk.nama}
                        className="w-full h-full object-cover transition group-hover:scale-105"
                    />
                ) : (
                    <Art className="w-full h-full" />
                )}
            </div>
            <p className="text-sm text-[#6E7C58] mb-2">{label}</p>
            <p className="font-display text-lg mb-1">{produk.nama}</p>
            <p className="text-[#6B6459] text-sm">{specs}</p>
        </Link>
    );
}
