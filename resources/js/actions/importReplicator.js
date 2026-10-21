import { isTransferableReplicator } from '../support/fields';

export default function importReplicator() {
    return {
        title: 'Import replicator',
        visible: isTransferableReplicator,
        confirm: {
            fields: {
                name: {
                    type: 'files',
                    display: 'Import json',
                    max_files: 1,
                    accept: '.json',
                    validate: [
                        'required',
                    ],
                },
            },
        },

        async run({
            confirmation,
            update,
            updateMeta,
            value,
            meta,
            vm,
        }) {
            const response = await fetch(cp_url('replicator-transfer/import'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-XSRF-TOKEN': decodeURIComponent(document.cookie.split('; ').find(r => r.startsWith('XSRF-TOKEN='))?.split('=')[1] ?? ''),
                },
                body: JSON.stringify({
                    file: confirmation.processed.name,
                }),
            });

            if (!response.ok) {
                throw new Error('Import failed.');
            }

            const data = await response.json();
            const importedSets = await Promise.all((data.value || []).map(async (set) => {
                const id = createId();
                const existingMeta = data.meta?.existing?.[set._id];
                const fetchedMeta = existingMeta || await fetchSetMeta(vm, set.type);

                return {
                    set: {
                        ...set,
                        _id: id,
                    },
                    meta: fetchedMeta ? [id, JSON.parse(JSON.stringify(fetchedMeta))] : null,
                };
            }));

            updateMeta({
                ...(meta || {}),
                existing: {
                    ...(meta?.existing || {}),
                    ...Object.fromEntries(importedSets.map(({ meta }) => meta).filter(Boolean)),
                },
            });

            update([
                ...(Array.isArray(value) ? value : []),
                ...importedSets.map(({ set }) => set),
            ]);
        },
    };
}

const createId = () => {
    return window.crypto?.randomUUID?.() || Math.random().toString(36).slice(2);
}

const fetchSetMeta = async (vm, type) => {
    if (!type || !vm?.fetchSet) {
        return null;
    }

    const set = await vm.fetchSet(type);

    return set.new || null;
}
