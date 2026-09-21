import { Link, usePage } from '@inertiajs/react';
import { waLink, displayPhone } from '../lib/format';

const navItems = [
    { href: '/', label: 'Beranda' },
    { href: '/tentang', label: 'Tentang' },
    { href: '/produk', label: 'Produk' },
    { href: '/artikel', label: 'Artikel' },
];

export default function SiteLayout({ children }) {
    const { props, url: currentUrl } = usePage();
    const { settings } = props;

    return (
        <div className="antialiased">
            <nav className="max-w-6xl mx-auto flex items-center justify-between px-6 py-6">
                <Link href="/" className="font-display text-lg">
                    {settings.nama_sales}
                </Link>
                <div className="hidden md:flex items-center gap-8 text-sm text-[#6B6459]">
                    {navItems.map((item) => (
                        <Link
                            key={item.href}
                            href={item.href}
                            className={
                                currentUrl === item.href || (item.href !== '/' && currentUrl.startsWith(item.href))
                                    ? 'text-[#1E1C18]'
                                    : 'hover:text-[#1E1C18] transition-colors'
                            }
                        >
                            {item.label}
                        </Link>
                    ))}
                </div>
                <a
                    href={waLink(settings.whatsapp)}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="bg-[#1E1C18] text-[#F4F1E9] text-sm px-5 py-2.5 rounded-full hover:bg-[#332F28] transition-colors whitespace-nowrap"
                >
                    Hubungi via WhatsApp
                </a>
            </nav>

            {children}

            <footer className="bg-[#EAE5D8] border-t border-[#DAD4C5]">
                <div className="max-w-6xl mx-auto px-6 py-14 grid md:grid-cols-3 gap-10">
                    <div>
                        <p className="font-display text-lg mb-2">{settings.nama_sales}</p>
                        <p className="text-sm text-[#6B6459] leading-relaxed">
                            Sales properti {settings.nama_agensi} untuk kawasan ini. Bantu cari unit primary dan
                            secondary sesuai kebutuhan.
                        </p>
                    </div>
                    <div>
                        <p className="text-sm text-[#6B6459] mb-3">Halaman</p>
                        <div className="flex flex-col gap-2 text-sm">
                            {navItems.map((item) => (
                                <Link key={item.href} href={item.href} className="hover:text-[#1E1C18] transition-colors">
                                    {item.label}
                                </Link>
                            ))}
                        </div>
                    </div>
                    <div>
                        <p className="text-sm text-[#6B6459] mb-3">Kontak</p>
                        {settings.whatsapp && <p className="text-sm mb-1">{displayPhone(settings.whatsapp)}</p>}
                        {settings.email && <p className="text-sm">{settings.email}</p>}
                    </div>
                </div>
                <div className="max-w-6xl mx-auto px-6 pb-8 text-xs text-[#8A8471] border-t border-[#DAD4C5] pt-6 flex flex-wrap items-center justify-between gap-3">
                    <p>
                        Website independen milik {settings.nama_sales}, sales dari {settings.nama_agensi}. Bukan
                        situs resmi developer/kawasan. &copy; {new Date().getFullYear()} {settings.nama_sales}.
                    </p>
                    <div className="flex gap-4">
                        <Link href="/kebijakan-privasi" className="hover:text-[#1E1C18] transition-colors">
                            Kebijakan Privasi
                        </Link>
                        <Link href="/syarat-ketentuan" className="hover:text-[#1E1C18] transition-colors">
                            Syarat &amp; Ketentuan
                        </Link>
                    </div>
                </div>
            </footer>
        </div>
    );
}
