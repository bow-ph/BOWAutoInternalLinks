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

                // Transform data for grid display with safe access
                const generationsByType = response.data?.generationsByType || {};
                this.logStats = Object.entries(generationsByType).map(([type, count]) => ({
                    type: type || 'unknown',
                    count: count || 0
                }));
            } catch (e) {
                this.createNotificationError({
                    title: 'Error',
                    message: e.message
                });
                this.logStats = [];
            } finally {
                this.isLoading = false;
            }
        }
    }
});
