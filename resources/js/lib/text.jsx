/** Render "*kata*" jadi <em> miring, dipakai untuk headline yang diedit lewat Filament. */
export function renderWithEmphasis(text) {
    if (!text) return null;

    return text.split(/\*(.+?)\*/g).map((part, index) =>
        index % 2 === 1 ? (
            <em key={index} className="italic">
                {part}
            </em>
        ) : (
            part
        )
    );
}
