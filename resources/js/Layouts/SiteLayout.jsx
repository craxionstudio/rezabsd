import { Link, usePage } from '@inertiajs/react';

const nav = [
    { href: '/', label: 'Home' },
    { href: '/produk', label: 'Produk' },
    { href: '/artikel', label: 'Artikel' },
    { href: '/about-us', label: 'About Us' },
];

export default function SiteLayout({ children }) {
    const { settings } = usePage().props;
    const waLink = settings?.whatsapp
        ? `https://wa.me/${settings.whatsapp}?text=${encodeURIComponent('Halo, saya tertarik dengan info properti.')}`
        : null;

    return (
        <div className="flex min-h-screen flex-col bg-white text-slate-900">
            <header className="border-b border-slate-200">
                <div className="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                    <Link href="/" className="flex flex-col leading-tight">
                        <span className="text-lg font-semibold">{settings?.nama_sales}</span>
                        <span className="text-xs text-slate-500">Sales dari {settings?.nama_agensi}</span>
                    </Link>
                    <nav className="flex items-center gap-6 text-sm font-medium">
                        {nav.map((item) => (
                            <Link key={item.href} href={item.href} className="text-slate-700 hover:text-slate-950">
                                {item.label}
                            </Link>
                        ))}
                        {waLink && (
                            <a
                                href={waLink}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="rounded-full bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700"
                            >
                                WhatsApp
                            </a>
                        )}
                    </nav>
                </div>
            </header>

            <main className="flex-1">{children}</main>

            <footer className="border-t border-slate-200 bg-slate-50">
                <div className="mx-auto max-w-6xl px-4 py-8 text-sm text-slate-600">
                    <p className="font-medium text-slate-800">
                        {settings?.nama_sales} — {settings?.jabatan} di {settings?.nama_agensi}
                    </p>
                    <p className="mt-2 max-w-3xl">{settings?.disclaimer}</p>
                    <p className="mt-4 text-xs text-slate-400">
                        &copy; {new Date().getFullYear()} {settings?.nama_sales}. Bukan situs resmi developer/kawasan.
                    </p>
                </div>
            </footer>
        </div>
    );
}
