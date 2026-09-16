export function formatRupiah(value) {
    if (value === null || value === undefined) return '-';

    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value);
}

/** Format singkat ala mockup: "Rp 850 juta", "Rp 1,4 miliar". */
export function formatHargaSingkat(value) {
    if (value === null || value === undefined) return '-';

    if (value >= 1_000_000_000) {
        const miliar = Math.round((value / 1_000_000_000) * 10) / 10;
        return `Rp ${String(miliar).replace('.', ',')} miliar`;
    }

    if (value >= 1_000_000) {
        const juta = Math.round(value / 1_000_000);
        return `Rp ${juta} juta`;
    }

    return formatRupiah(value);
}

export function displayPhone(whatsapp) {
    if (!whatsapp) return '-';

    return whatsapp.startsWith('62') ? `0${whatsapp.slice(2)}` : whatsapp;
}

export function waLink(whatsapp, message = 'Halo, saya tertarik dengan info properti.') {
    if (!whatsapp) return '#';

    return `https://wa.me/${whatsapp}?text=${encodeURIComponent(message)}`;
}
