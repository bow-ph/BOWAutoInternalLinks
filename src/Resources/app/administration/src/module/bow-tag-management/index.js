import './component/bow-tag-management';
import './component/bow-log-viewer';
import './page/bow-tag-management-index';
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
            children: {
                management: {
                    component: 'bow-tag-management',
                    path: 'management',
                    meta: {
                        privilege: 'bow_auto_links.viewer',
                        parentPath: 'sw.marketing.index'
                    }
                },
                logs: {
                    component: 'bow-log-viewer',
                    path: 'logs',
                    meta: {
                        privilege: 'bow_auto_links.viewer',
                        parentPath: 'sw.marketing.index'
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
