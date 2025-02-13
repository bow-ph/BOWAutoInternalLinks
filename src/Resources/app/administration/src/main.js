// Import and register module
import './module/bow-tag-management';

// Register the module
Shopware.Module.register('bow-tag-management', {
    flag: 'BOW_AUTO_INTERNAL_LINKS',
    type: 'plugin',
    name: 'BOW Auto Internal Links',
    title: 'bow-tag-management.general.mainMenuItemGeneral',
    description: 'bow-tag-management.general.descriptionTextModule',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',
    entity: 'tag',

    routes: {
        index: {
            component: 'bow-tag-management-index',
            path: 'index',
            name: 'bow.tag.management.index',
            meta: {
                parentPath: 'sw.marketing.index',
                privilege: 'bow_auto_links.viewer'
            },
            children: {
                management: {
                    component: 'bow-tag-management',
                    path: 'management',
                    name: 'bow.tag.management.management',
                    meta: {
                        privilege: 'bow_auto_links.viewer',
                        parentPath: 'bow.tag.management.index'
                    }
                },
                logs: {
                    component: 'bow-log-viewer',
                    path: 'logs',
                    name: 'bow.tag.management.logs',
                    meta: {
                        privilege: 'bow_auto_links.viewer',
                        parentPath: 'bow.tag.management.index'
                    }
                }
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
