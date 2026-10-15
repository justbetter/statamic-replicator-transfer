import { isTransferableReplicator } from '../support/fields';

export default function exportReplicator() {
    return {
        title: 'Export replicator',
        visible: isTransferableReplicator,

        async run(payload) {
            const response = await fetch(cp_url('replicator-transfer/export'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify({
                    value: payload.value,
                    meta: payload.meta,
                }),
            });

            if (!response.ok) {
                throw new Error('Export failed.');
            }

            const blob = await response.blob();

            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = 'export.json';

            document.body.appendChild(link);
            link.click();
            link.remove();

            URL.revokeObjectURL(url);
        },
    };
}
