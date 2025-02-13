import './page/bow-tag-management';
import './page/bow-log-viewer';
import enGB from './snippet/en-GB.json';
import deDE from './snippet/de-DE.json';

// Add ACL configuration
Shopware.Service('privileges').addPrivilegeMappingEntry({
    category: 'permissions',
    parent: 'marketing',
    key: 'bow_auto_links',
    roles: {
        viewer: {
            privileges: [
                'tag:read',
                'bow_auto_links:read'
            ],
            dependencies: []
        },
        editor: {
            privileges: [
                'tag:update',
                'bow_auto_links:update'
            ],
            dependencies: [
                'bow_auto_links.viewer'
            ]
        },
        creator: {
            privileges: [
                'tag:create',
                'bow_auto_links:create'
            ],
            dependencies: [
                'bow_auto_links.viewer',
                'bow_auto_links.editor'
            ]
        }
    }
});

// Register snippets for translations
Shopware.Application.addServiceProviderDecorator('snippetService', (service) => {
    service.extend('en-GB', enGB);
    service.extend('de-DE', deDE);
    return service;
});
