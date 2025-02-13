import template from './bow-tag-management-index.html.twig';

const { Component } = Shopware;

Component.register('bow-tag-management-index', {
    template,

    metaInfo() {
        return {
            title: this.$tc('bow-tag-management.general.mainMenuItemGeneral')
        };
    }
});
