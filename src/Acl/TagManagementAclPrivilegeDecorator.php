<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Acl;

use Shopware\Core\Framework\Api\Acl\Role\AclRoleDefinition;
use Shopware\Core\Framework\Api\Acl\AclPrivilegeCollection;

class TagManagementAclPrivilegeDecorator
{
    private AclPrivilegeCollection $privileges;

    public function __construct(AclPrivilegeCollection $privileges)
    {
        $this->privileges = $privileges;
    }

    public function getPrivileges(): array
    {
        return [
            'bow_auto_links.viewer' => [
                'tag:read',
                'bow_auto_link:read'
            ]
        ];
    }

    public function getPrivilegeParents(): array
    {
        return [AclRoleDefinition::ALL_ROLE_KEY];
    }
}
