export const isTransferableReplicator = (payload) => {
    const handles = Statamic.$config.get('replicatorTransferHandles') || [];

    return handles.includes(payload?.vm?.handle);
};
