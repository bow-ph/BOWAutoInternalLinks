import template from './bow-log-viewer.html.twig';

const { Component, Mixin } = Shopware;

Component.register('bow-log-viewer', {
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
            logStats: null,
            columns: [{
                property: 'type',
                label: this.$tc('bow-tag-management.list.columnType'),
                visible: true,
                rawData: true
            }, {
                property: 'count',
                label: this.$tc('bow-tag-management.list.columnCount'),
                visible: true,
                rawData: true,
                align: 'right'
            }]
        };
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.loadLogStats();
        },

        async loadLogStats() {
            this.isLoading = true;

            try {
                const response = await this.httpClient.get(
                    '/_action/bow-auto-links/log-stats',
                    { headers: this.syncService.getBasicHeaders() }
                );

                // Transform data for grid display
                this.logStats = Object.entries(response.data.generationsByType).map(([type, count]) => ({
                    type,
                    count
                }));
            } catch (e) {
                this.createNotificationError({
                    title: 'Error',
                    message: e.message
                });
            } finally {
                this.isLoading = false;
            }
        }
    }
});
