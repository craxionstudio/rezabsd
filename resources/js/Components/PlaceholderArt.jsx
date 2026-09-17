/**
 * Ilustrasi SVG dummy dari mockup — dipakai sebagai fallback ketika field
 * galeri foto/foto profil dari Filament masih kosong. Begitu ada foto asli,
 * komponen pemanggil merender <img> ke media asli dan bukan komponen ini.
 */

export function HeroKawasanArt({ className }) {
    return (
        <svg viewBox="0 0 500 220" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="500" height="220" fill="#EDE8DA" />
            <circle cx="430" cy="42" r="20" fill="#F0DCA8" />
            <rect y="175" width="500" height="45" fill="#8B9A76" />
            <rect x="150" y="150" width="6" height="25" fill="#5B4636" />
            <circle cx="153" cy="140" r="16" fill="#6E7C58" />
            <rect x="330" y="150" width="6" height="25" fill="#5B4636" />
            <circle cx="333" cy="140" r="16" fill="#6E7C58" />
            <polygon points="30,140 90,105 150,140" fill="#A66B52" />
            <rect x="45" y="140" width="90" height="45" fill="#EDE6D3" />
            <rect x="70" y="160" width="20" height="25" fill="#5B4636" />
            <rect x="55" y="148" width="16" height="16" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="105" y="148" width="16" height="16" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <polygon points="175,120 250,75 325,120" fill="#8B5540" />
            <rect x="190" y="120" width="120" height="65" fill="#DCD3B8" />
            <rect x="235" y="150" width="30" height="35" fill="#5B4636" />
            <rect x="205" y="135" width="20" height="18" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="275" y="135" width="20" height="18" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <polygon points="350,140 410,105 470,140" fill="#A66B52" />
            <rect x="365" y="140" width="90" height="45" fill="#EDE6D3" />
            <rect x="390" y="160" width="20" height="25" fill="#5B4636" />
            <rect x="375" y="148" width="16" height="16" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="425" y="148" width="16" height="16" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
        </svg>
    );
}

export function PortraitArt({ className }) {
    return (
        <svg viewBox="0 0 200 200" className={className}>
            <rect width="200" height="200" fill="#DCD3B8" />
            <path d="M20 200c0-48 36-78 80-78s80 30 80 78" fill="#6E7C58" />
            <circle cx="100" cy="88" r="46" fill="#E8C88A" />
            <path
                d="M54 78c0-30 20-48 46-48s46 18 46 48c-6-16-24-26-46-26s-40 10-46 26z"
                fill="#3B372C"
            />
        </svg>
    );
}

export function TestimonialAvatarArt({ className }) {
    return (
        <svg viewBox="0 0 40 40" className={className}>
            <rect width="40" height="40" fill="#C9C2AE" />
            <path d="M7 38c0-8 6-13 13-13s13 5 13 13" fill="#6E7C58" />
            <circle cx="20" cy="15" r="7" fill="#E8C88A" />
            <path
                d="M13 13c0-5 3-8 7-8s7 3 7 8c-1-3-4-4-7-4s-6 1-7 4z"
                fill="#3B372C"
            />
        </svg>
    );
}

export function CardRumah4590Art({ className }) {
    return (
        <svg viewBox="0 0 300 200" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="300" height="200" fill="#EDE8DA" />
            <circle cx="250" cy="45" r="18" fill="#F0DCA8" />
            <rect y="150" width="300" height="50" fill="#8B9A76" />
            <rect x="35" y="120" width="6" height="35" fill="#5B4636" />
            <circle cx="38" cy="110" r="22" fill="#6E7C58" />
            <polygon points="90,110 175,55 260,110" fill="#A66B52" />
            <rect x="105" y="110" width="140" height="70" fill="#EDE6D3" />
            <rect x="155" y="140" width="30" height="40" fill="#5B4636" />
            <rect x="120" y="122" width="26" height="26" fill="#E8C88A" stroke="#3B372C" strokeWidth="2" />
            <rect x="200" y="122" width="26" height="26" fill="#E8C88A" stroke="#3B372C" strokeWidth="2" />
        </svg>
    );
}

export function CardRukoDuaLantaiArt({ className }) {
    return (
        <svg viewBox="0 0 300 200" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="300" height="200" fill="#EDE8DA" />
            <rect y="165" width="300" height="35" fill="#8B9A76" />
            <rect x="85" y="40" width="130" height="125" fill="#DCD3B8" />
            <rect x="85" y="40" width="130" height="10" fill="#A66B52" />
            <line x1="85" y1="100" x2="215" y2="100" stroke="#3B372C" strokeWidth="2" />
            <rect x="100" y="58" width="26" height="24" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.5" />
            <rect x="137" y="58" width="26" height="24" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.5" />
            <rect x="174" y="58" width="26" height="24" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.5" />
            <rect x="100" y="115" width="100" height="45" fill="#B9C4C0" stroke="#3B372C" strokeWidth="2" />
            <polygon points="90,112 210,112 200,98 100,98" fill="#6E7C58" />
        </svg>
    );
}

export function CardKavlingSiapBangunArt({ className }) {
    return (
        <svg viewBox="0 0 300 200" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="300" height="200" fill="#EDE8DA" />
            <circle cx="255" cy="40" r="16" fill="#F0DCA8" />
            <rect y="120" width="300" height="80" fill="#8B9A76" />
            <line x1="30" y1="140" x2="26" y2="130" stroke="#4C5740" strokeWidth="2" />
            <line x1="55" y1="150" x2="51" y2="138" stroke="#4C5740" strokeWidth="2" />
            <line x1="85" y1="145" x2="81" y2="133" stroke="#4C5740" strokeWidth="2" />
            <line x1="115" y1="155" x2="111" y2="143" stroke="#4C5740" strokeWidth="2" />
            <line x1="60" y1="120" x2="60" y2="105" stroke="#5B4636" strokeWidth="3" />
            <line x1="240" y1="120" x2="240" y2="105" stroke="#5B4636" strokeWidth="3" />
            <line x1="60" y1="108" x2="240" y2="108" stroke="#5B4636" strokeWidth="2" strokeDasharray="8 6" />
            <line x1="150" y1="120" x2="150" y2="85" stroke="#5B4636" strokeWidth="3" />
            <rect x="150" y="80" width="45" height="24" fill="#EDE6D3" stroke="#3B372C" strokeWidth="1.5" />
            <rect x="245" y="105" width="6" height="20" fill="#5B4636" />
            <circle cx="248" cy="95" r="16" fill="#6E7C58" />
        </svg>
    );
}

export function CardRumah60120Art({ className }) {
    return (
        <svg viewBox="0 0 300 200" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="300" height="200" fill="#EDE8DA" />
            <ellipse cx="235" cy="45" rx="26" ry="14" fill="#DCD3B8" />
            <ellipse cx="255" cy="40" rx="20" ry="12" fill="#DCD3B8" />
            <rect y="150" width="300" height="50" fill="#8B9A76" />
            <rect x="255" y="120" width="6" height="35" fill="#5B4636" />
            <circle cx="258" cy="110" r="22" fill="#4C5740" />
            <polygon points="55,115 150,45 245,115" fill="#8B5540" />
            <rect x="75" y="115" width="150" height="65" fill="#DCD3B8" />
            <rect x="135" y="147" width="30" height="33" fill="#5B4636" />
            <rect x="95" y="129" width="26" height="26" fill="#E8C88A" stroke="#3B372C" strokeWidth="2" />
            <rect x="180" y="129" width="26" height="26" fill="#E8C88A" stroke="#3B372C" strokeWidth="2" />
        </svg>
    );
}

export function CardRukoTigaLantaiArt({ className }) {
    return (
        <svg viewBox="0 0 300 200" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="300" height="200" fill="#EDE8DA" />
            <rect y="175" width="300" height="25" fill="#8B9A76" />
            <rect x="95" y="20" width="110" height="155" fill="#C9C2AE" />
            <rect x="95" y="20" width="110" height="8" fill="#A66B52" />
            <line x1="95" y1="65" x2="205" y2="65" stroke="#3B372C" strokeWidth="1.5" />
            <line x1="95" y1="110" x2="205" y2="110" stroke="#3B372C" strokeWidth="1.5" />
            <rect x="108" y="35" width="22" height="20" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="170" y="35" width="22" height="20" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="108" y="78" width="22" height="20" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="170" y="78" width="22" height="20" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="105" y="125" width="95" height="50" fill="#B9C4C0" stroke="#3B372C" strokeWidth="2" />
        </svg>
    );
}

export function CardKavlingPojokTamanArt({ className }) {
    return (
        <svg viewBox="0 0 300 200" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="300" height="200" fill="#EDE8DA" />
            <circle cx="45" cy="42" r="16" fill="#F0DCA8" />
            <rect y="115" width="300" height="85" fill="#8B9A76" />
            <rect x="215" y="130" width="8" height="35" fill="#5B4636" />
            <circle cx="219" cy="118" r="24" fill="#6E7C58" />
            <line x1="50" y1="115" x2="50" y2="100" stroke="#5B4636" strokeWidth="3" />
            <rect x="50" y="95" width="40" height="22" fill="#EDE6D3" stroke="#3B372C" strokeWidth="1.5" />
            <line x1="45" y1="150" x2="41" y2="140" stroke="#4C5740" strokeWidth="2" />
            <line x1="70" y1="160" x2="66" y2="150" stroke="#4C5740" strokeWidth="2" />
            <line x1="110" y1="155" x2="106" y2="145" stroke="#4C5740" strokeWidth="2" />
            <line x1="140" y1="165" x2="136" y2="155" stroke="#4C5740" strokeWidth="2" />
        </svg>
    );
}

export function ArtikelFeaturedArt({ className }) {
    return (
        <svg viewBox="0 0 300 200" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="300" height="200" fill="#EDE8DA" />
            <rect y="150" width="300" height="50" fill="#8B9A76" />
            <polygon points="90,110 175,55 260,110" fill="#A66B52" />
            <rect x="105" y="110" width="140" height="70" fill="#EDE6D3" />
            <rect x="155" y="140" width="30" height="40" fill="#5B4636" />
            <rect x="120" y="122" width="26" height="26" fill="#E8C88A" stroke="#3B372C" strokeWidth="2" />
            <rect x="200" y="122" width="26" height="26" fill="#E8C88A" stroke="#3B372C" strokeWidth="2" />
        </svg>
    );
}

export function ArtikelIconKprArt({ className }) {
    return (
        <svg viewBox="0 0 60 60" className={className} style={{ opacity: 0.85 }}>
            <circle cx="22" cy="30" r="14" fill="none" stroke="#3B372C" strokeWidth="2" />
            <circle cx="38" cy="30" r="14" fill="none" stroke="#3B372C" strokeWidth="2" />
        </svg>
    );
}

export function ArtikelIconCompareArt({ className }) {
    return (
        <svg viewBox="0 0 60 60" className={className} style={{ opacity: 0.85 }}>
            <rect x="8" y="14" width="18" height="30" fill="none" stroke="#20261A" strokeWidth="2" />
            <rect x="34" y="14" width="18" height="30" fill="none" stroke="#20261A" strokeWidth="2" />
            <line x1="30" y1="10" x2="30" y2="48" stroke="#20261A" strokeWidth="1.5" strokeDasharray="3 3" />
        </svg>
    );
}

export function DetailMainArt({ className }) {
    return (
        <svg viewBox="0 0 400 260" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="400" height="260" fill="#EDE8DA" />
            <circle cx="335" cy="55" r="24" fill="#F0DCA8" />
            <rect y="195" width="400" height="65" fill="#8B9A76" />
            <rect x="45" y="155" width="8" height="45" fill="#5B4636" />
            <circle cx="49" cy="140" r="28" fill="#6E7C58" />
            <polygon points="120,145 230,70 340,145" fill="#A66B52" />
            <rect x="140" y="145" width="180" height="90" fill="#EDE6D3" />
            <rect x="200" y="180" width="40" height="55" fill="#5B4636" />
            <rect x="160" y="160" width="34" height="34" fill="#E8C88A" stroke="#3B372C" strokeWidth="2.5" />
            <rect x="265" y="160" width="34" height="34" fill="#E8C88A" stroke="#3B372C" strokeWidth="2.5" />
        </svg>
    );
}

export function DetailThumb1Art({ className }) {
    return (
        <svg viewBox="0 0 200 130" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="200" height="130" fill="#DCD3B8" />
            <rect x="0" y="90" width="200" height="40" fill="#B9C4C0" />
            <rect x="130" y="20" width="45" height="55" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.5" />
            <rect x="20" y="65" width="90" height="30" rx="4" fill="#A66B52" />
            <rect x="20" y="50" width="20" height="22" fill="#8B5540" />
            <rect x="90" y="50" width="20" height="22" fill="#8B5540" />
        </svg>
    );
}

export function DetailThumb2Art({ className }) {
    return (
        <svg viewBox="0 0 200 130" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="200" height="130" fill="#EDE6D3" />
            <rect x="0" y="30" width="200" height="30" fill="#B9C4C0" />
            <rect x="0" y="80" width="200" height="50" fill="#6E7C58" />
            <rect x="15" y="88" width="35" height="15" fill="none" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="60" y="88" width="35" height="15" fill="none" stroke="#3B372C" strokeWidth="1.3" />
        </svg>
    );
}

export function DetailThumb3Art({ className }) {
    return (
        <svg viewBox="0 0 200 130" preserveAspectRatio="xMidYMid slice" className={className}>
            <rect width="200" height="130" fill="#DCD3B8" />
            <rect x="0" y="95" width="200" height="35" fill="#8B9A76" />
            <rect x="25" y="55" width="90" height="45" rx="3" fill="#A66B52" />
            <rect x="25" y="45" width="30" height="20" rx="4" fill="#EDE6D3" stroke="#3B372C" strokeWidth="1.3" />
            <rect x="140" y="30" width="35" height="45" fill="#E8C88A" stroke="#3B372C" strokeWidth="1.3" />
        </svg>
    );
}

/**
 * Fallback card ilustrasi, dipilih siklis berdasarkan index. Tipe produk kini
 * dikelola bebas lewat CMS (bisa nama apa saja), jadi ilustrasi tidak lagi
 * dipetakan per nama tipe — cukup diputar dari daftar generik ini.
 */
const PRODUK_ART_VARIANTS = [
    CardRumah4590Art,
    CardRukoDuaLantaiArt,
    CardKavlingSiapBangunArt,
    CardRumah60120Art,
    CardRukoTigaLantaiArt,
    CardKavlingPojokTamanArt,
];

export function produkArtFor(index = 0) {
    return PRODUK_ART_VARIANTS[index % PRODUK_ART_VARIANTS.length];
}
