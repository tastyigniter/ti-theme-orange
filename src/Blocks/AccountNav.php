<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class AccountNav extends ContentBlock
{
    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'account-nav',
            'name' => 'igniter.orange::default.builder.block_account_nav',
            'description' => 'igniter.orange::default.builder.block_account_nav_desc',
            'icon' => 'fa fa-bars',
            'unique' => true,
            'pages' => [
                'account.account',
                'account.address',
                'account.orders',
                'account.order',
                'account.reservations',
                'account.reservation',
            ],
        ];
    }
}
