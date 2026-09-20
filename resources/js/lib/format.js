export function displayPhone(whatsapp) {
    if (!whatsapp) return '-';

    return whatsapp.startsWith('62') ? `0${whatsapp.slice(2)}` : whatsapp;
}

export function waLink(whatsapp, message = 'Halo, saya tertarik dengan info properti.') {
    if (!whatsapp) return '#';

    return `https://wa.me/${whatsapp}?text=${encodeURIComponent(message)}`;
}
