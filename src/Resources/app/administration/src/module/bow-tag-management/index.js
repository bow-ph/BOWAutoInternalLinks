import './page/bow-tag-management-index';
import './page/bow-tag-management';
import './page/bow-log-viewer';
import './acl';

import enGB from './snippet/en-GB.json';
import deDE from './snippet/de-DE.json';

// Register snippets
Shopware.Application.addServiceProviderDecorator('snippetService', (service) => {
    service.extend('en-GB', enGB);
    service.extend('de-DE', deDE);
    return service;
});

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
            component: 'bow-tag-management-index',
            path: 'index',
            name: 'bow.tag.management.index',
            meta: {
                parentPath: 'sw.marketing.index',
                privilege: 'bow_auto_links.viewer'
            },
            redirect: {
                name: 'bow.tag.management.management'
            },
            children: {
                management: {
                    component: 'bow-tag-management',
                    path: 'management',
                    name: 'bow.tag.management.management',
                    meta: {
                        parentPath: 'bow.tag.management.index',
                        privilege: 'bow_auto_links.viewer'
                    }
                },
                logs: {
                    component: 'bow-log-viewer',
                    path: 'logs',
                    name: 'bow.tag.management.logs',
                    meta: {
                        parentPath: 'bow.tag.management.index',
                        privilege: 'bow_auto_links.viewer'
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
