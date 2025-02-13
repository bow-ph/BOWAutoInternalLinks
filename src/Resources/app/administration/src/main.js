import './module/bow-tag-management';

// Register the module
Shopware.Module.register('bow-tag-management', {
    type: 'plugin',
    name: 'BOW Auto Internal Links',
    title: 'bow-tag-management.general.mainMenuItemGeneral',
    description: 'bow-tag-management.general.descriptionTextModule',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',
    entity: 'tag',

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
        parent: 'sw-marketing',
        privilege: 'bow_auto_links.viewer',
        position: 100
    }]
});
