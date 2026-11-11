<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class RichText extends ContentBlock
{
    protected array $htmlFields = ['content'];

    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'rich-text',
            'name' => 'igniter.orange::default.builder.block_rich_text',
            'description' => 'igniter.orange::default.builder.block_rich_text_desc',
            'icon' => 'fa fa-paragraph',
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return [
            'content' => [
                'label' => 'igniter.orange::default.builder.label_content',
                'type' => 'richeditor',
                'size' => 'large',
            ],
        ];
    }
}
