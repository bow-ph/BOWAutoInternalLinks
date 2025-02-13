import './page/bow-tag-management';
import './page/bow-log-viewer';
import enGB from './snippet/en-GB.json';
import deDE from './snippet/de-DE.json';

Shopware.Module.register('bow-tag-management', {
    type: 'plugin',
    name: 'BOW Auto Internal Links',
    title: 'bow-tag-management.general.mainMenuItemGeneral',
    description: 'bow-tag-management.general.descriptionTextModule',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',

    snippets: {
        'en-GB': enGB,
        'de-DE': deDE
    },

    routes: {
        index: {
            component: 'bow-tag-management',
            path: 'index'
        },
        logs: {
            component: 'bow-log-viewer',
            path: 'logs'
        }
    },

    navigation: [{
        label: 'bow-tag-management.general.mainMenuItemGeneral',
        color: '#ff3d58',
        path: 'bow.tag.management.index',
        icon: 'default-shopping-paper-bag-product',
        position: 100,
        parent: 'sw-marketing'
    }]
});
