import { Link } from '@inertiajs/react';
import { produkArtFor } from './PlaceholderArt';
import { formatHargaSingkat } from '../lib/format';

const TIPE_LABEL = { rumah: 'Rumah', ruko: 'Ruko', kavling: 'Kavling' };
const STATUS_LABEL = { primary: 'Primary', secondary: 'Secondary' };

export default function ProdukListingCard({ produk, index = 0, showTipeInLabel = true, showSpecs = true, imgHeightClass = 'h-56' }) {
    const Art = produkArtFor(produk.tipe, index);
    const label = showTipeInLabel
        ? `${STATUS_LABEL[produk.status]} · ${TIPE_LABEL[produk.tipe]}`
        : STATUS_LABEL[produk.status];

    let specs = formatHargaSingkat(produk.harga);
    if (showSpecs) {
        if (produk.tipe === 'kavling' && produk.luas_tanah) {
            specs += ` · ${produk.luas_tanah} m²`;
        } else if (produk.kamar_tidur || produk.kamar_mandi) {
            specs += ` · ${produk.kamar_tidur ?? '-'} KT, ${produk.kamar_mandi ?? '-'} KM`;
        }
    }

    return (
        <Link href={`/produk/${produk.slug}`} className="group block">
            <div className={`${imgHeightClass} mb-4 overflow-hidden`}>
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
