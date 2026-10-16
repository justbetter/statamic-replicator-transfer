import exportReplicator from './actions/exportReplicator';
import importReplicator from './actions/importReplicator';

Statamic.$fieldActions.add('replicator-fieldtype', exportReplicator());
Statamic.$fieldActions.add('replicator-fieldtype', importReplicator());
