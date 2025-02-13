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

// Register module
Module.register('bow-tag-management', {
    type: 'plugin',
    name: 'BOW Auto Internal Links',
    title: 'bow-tag-management.general.mainMenuItemGeneral',
    description: 'bow-tag-management.general.descriptionTextModule',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',
    entity: 'tag',


    snippets: {
        'en-GB': enGB,
        'de-DE': deDE
    },

    routes: {
        index: {
            component: 'bow-tag-management',
            path: 'index',
            meta: {
                parentPath: 'sw.marketing.index',
                privilege: 'bow_auto_links.viewer'
            }
        },
        logs: {
            component: 'bow-log-viewer',
            path: 'logs',
            meta: {
                parentPath: 'sw.marketing.index',
                privilege: 'bow_auto_links.viewer'
            }
        }
    },

    navigation: [{

        id: 'bow-tag-management',
        path: 'bow.tag.management.index',
        label: 'bow-tag-management.general.mainMenuItemGeneral',
        parent: 'sw.marketing.index',
        privilege: 'bow_auto_links.viewer',
        position: 100

    }]
});
