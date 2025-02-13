import template from './bow-tag-management.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('bow-tag-management', {
    template,

    inject: [
        'repositoryFactory'
    ],

    mixins: [
        Mixin.getByName('notification')
    ],

    data() {
        return {
            isLoading: false,
            tags: [],
            tagStats: {},
            columns: [{
                property: 'name',
                label: 'Name',
                routerLink: 'sw.tag.detail',
                primary: true
            }, {
                property: 'productCount',
                label: 'Products'
            }, {
                property: 'categoryCount',
                label: 'Categories'
            }, {
                property: 'linkCount',
                label: 'Auto Links'
            }, {
                property: 'priority',
                label: 'Priority'
            }]
        };
    },

    computed: {
        tagRepository() {
            return this.repositoryFactory.create('tag');
        }
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.loadTags();
        },

        async loadTags() {
            this.isLoading = true;

            const criteria = new Criteria();
            criteria.addAssociation('products');
            criteria.addAssociation('categories');

            try {
                const tags = await this.tagRepository.search(criteria, Shopware.Context.api);
                this.tags = tags;
                await this.loadTagStats();
            } catch (e) {
                this.createNotificationError({
                    title: 'Error',
                    message: e.message
                });
            } finally {
                this.isLoading = false;
            }
        },

        async loadTagStats() {
            try {
                const response = await this.httpClient.get(
                    '/_action/bow-auto-links/tag-stats',
                    { headers: this.syncService.getBasicHeaders() }
                );
                this.tagStats = response.data;
            } catch (e) {
                this.createNotificationError({
                    title: 'Error',
                    message: e.message
                });
            }
        },

        async updatePriority(tag) {
            try {
                await this.httpClient.post(
                    `/_action/bow-auto-links/tag-priority/${tag.id}`,
                    { priority: tag.priority },
                    { headers: this.syncService.getBasicHeaders() }
                );
                this.createNotificationSuccess({
                    title: 'Success',
                    message: 'Priority updated successfully'
                });
            } catch (e) {
                this.createNotificationError({
                    title: 'Error',
                    message: e.message
                });
            }
        }
    }
};
