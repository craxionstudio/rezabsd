import { useCallback, useEffect } from 'react';

/**
 * Fullscreen photo viewer for a gallery — prev/next, keyboard arrows,
 * Escape, and click-outside-the-photo all close/navigate it.
 */
export default function Lightbox({ images, activeIndex, onClose, onNavigate }) {
    const isOpen = activeIndex !== null;

    const next = useCallback(() => {
        onNavigate((activeIndex + 1) % images.length);
    }, [activeIndex, images.length, onNavigate]);

    const prev = useCallback(() => {
        onNavigate((activeIndex - 1 + images.length) % images.length);
    }, [activeIndex, images.length, onNavigate]);

    useEffect(() => {
        if (!isOpen) return undefined;

        function handleKeyDown(event) {
            if (event.key === 'Escape') onClose();
            if (event.key === 'ArrowRight') next();
            if (event.key === 'ArrowLeft') prev();
        }

        window.addEventListener('keydown', handleKeyDown);

        return () => window.removeEventListener('keydown', handleKeyDown);
    }, [isOpen, onClose, next, prev]);

    if (!isOpen) return null;

    return (
        <div
            className="fixed inset-0 z-50 bg-black/90 flex items-center justify-center"
            onClick={onClose}
        >
            <button
                type="button"
                onClick={onClose}
                className="absolute top-5 right-5 md:top-6 md:right-6 text-white/80 hover:text-white text-3xl leading-none w-10 h-10 flex items-center justify-center"
                aria-label="Tutup"
            >
                &times;
            </button>

            {images.length > 1 && (
                <button
                    type="button"
                    onClick={(event) => {
                        event.stopPropagation();
                        prev();
                    }}
                    className="absolute left-2 md:left-6 text-white/80 hover:text-white text-4xl px-3 py-6"
                    aria-label="Foto sebelumnya"
                >
                    &#8249;
                </button>
            )}

            <img
                src={images[activeIndex]}
                alt=""
                className="max-h-[85vh] max-w-[85vw] object-contain"
                onClick={(event) => event.stopPropagation()}
            />

            {images.length > 1 && (
                <button
                    type="button"
                    onClick={(event) => {
                        event.stopPropagation();
                        next();
                    }}
                    className="absolute right-2 md:right-6 text-white/80 hover:text-white text-4xl px-3 py-6"
                    aria-label="Foto berikutnya"
                >
                    &#8250;
                </button>
            )}

            {images.length > 1 && (
                <p className="absolute bottom-6 text-white/70 text-sm">
                    {activeIndex + 1} / {images.length}
                </p>
            )}
        </div>
    );
}
