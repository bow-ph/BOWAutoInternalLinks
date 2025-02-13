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
                label: 'Type'
            }, {
                property: 'count',
                label: 'Count'
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
                this.logStats = response.data;
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
