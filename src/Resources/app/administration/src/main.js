import './module/bow-tag-management';

// Initialize Shopware
const { Module } = Shopware;

// Register the module
if (Module.register('bow-tag-management')) {
    console.log('BOW Auto Internal Links module registered successfully');
}
