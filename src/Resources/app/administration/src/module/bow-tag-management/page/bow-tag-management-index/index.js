import template from './bow-tag-management-index.html.twig';

const { Component } = Shopware;

Component.register('bow-tag-management-index', {
    template,

    inject: [
        'repositoryFactory'
    ],

    metaInfo() {
        return {
            title: this.$tc('bow-tag-management.general.mainMenuItemGeneral')
        };
    },

    created() {
        if (this.$route.name === 'bow.tag.management.index') {
            this.$router.push({ name: 'bow.tag.management.management' });
        }
    }
});
