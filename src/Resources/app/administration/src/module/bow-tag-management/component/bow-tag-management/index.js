import template from './bow-tag-management.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('bow-tag-management', {
    template,

    inject: [
        'repositoryFactory',
        'httpClient',
        'syncService'
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
                label: this.$tc('bow-tag-management.list.columnName'),
                routerLink: 'sw.tag.detail',
                primary: true,
                visible: true,
                rawData: true,
                inlineEdit: 'string'
            }, {
                property: 'products',
                label: this.$tc('bow-tag-management.list.columnProducts'),
                visible: true,
                sortable: false,
                data: item => item.products ? item.products.length : 0
            }, {
                property: 'categories',
                label: this.$tc('bow-tag-management.list.columnCategories'),
                visible: true,
                sortable: false,
                data: item => item.categories ? item.categories.length : 0
            }, {
                property: 'tagStats',
                label: this.$tc('bow-tag-management.list.columnLinks'),
                visible: true,
                sortable: false,
                data: item => this.tagStats[item.id] ? this.tagStats[item.id].linkCount : 0
            }, {
                property: 'priority',
                label: this.$tc('bow-tag-management.list.columnPriority'),
                visible: true,
                inlineEdit: 'number'
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
            criteria.addAssociation('customFields');

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
        },

        onEditTag(item) {
            this.$router.push({
                name: 'sw.tag.detail',
                params: { id: item.id }
            });
        },

        onViewLinks(item) {
            this.$router.push({
                name: 'bow.tag.management.index.logs',
                query: { tagId: item.id }
            });
        }
    }
});
