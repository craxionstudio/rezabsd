import { Link } from '@inertiajs/react';
import { formatRupiah } from '../lib/format';

export default function ProdukCard({ produk }) {
    return (
        <Link
            href={`/produk/${produk.slug}`}
            className="group block overflow-hidden rounded-xl border border-slate-200 transition hover:shadow-lg"
        >
            <div className="aspect-[4/3] w-full overflow-hidden bg-slate-100">
                {produk.cover ? (
                    <img
                        src={produk.cover}
                        alt={produk.nama}
                        className="h-full w-full object-cover transition group-hover:scale-105"
                    />
                ) : (
                    <div className="flex h-full items-center justify-center text-slate-400">Tidak ada foto</div>
                )}
            </div>
            <div className="p-4">
                <p className="text-xs font-medium uppercase tracking-wide text-emerald-600">
                    {produk.tipe} · {produk.status}
                </p>
                <h3 className="mt-1 font-semibold text-slate-900">{produk.nama}</h3>
                {produk.lokasi && <p className="text-sm text-slate-500">{produk.lokasi}</p>}
                <p className="mt-2 text-lg font-semibold text-slate-900">{formatRupiah(produk.harga)}</p>
                {(produk.kamar_tidur || produk.kamar_mandi) && (
                    <p className="mt-1 text-sm text-slate-500">
                        {produk.kamar_tidur ?? '-'} KT · {produk.kamar_mandi ?? '-'} KM
                    </p>
                )}
            </div>
        </Link>
    );
}
