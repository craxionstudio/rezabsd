import { Head } from '@inertiajs/react';

export default function Seo({ title, description, jsonLd }) {
    const entries = Array.isArray(jsonLd) ? jsonLd : jsonLd ? [jsonLd] : [];

    return (
        <Head title={title}>
            {description && <meta name="description" content={description} />}
            {entries.map((entry, index) => (
                <script
                    key={index}
                    type="application/ld+json"
                    dangerouslySetInnerHTML={{ __html: JSON.stringify(entry) }}
                />
            ))}
        </Head>
    );
}
