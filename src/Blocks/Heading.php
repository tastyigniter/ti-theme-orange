<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class Heading extends ContentBlock
{
    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'heading',
            'name' => 'igniter.orange::default.builder.block_heading',
            'description' => 'igniter.orange::default.builder.block_heading_desc',
            'icon' => 'fa fa-heading',
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return [
            'title' => [
                'label' => 'igniter.orange::default.builder.label_title',
                'type' => 'text',
                'validationRule' => ['required', 'string', 'max:255'],
            ],
            'subtitle' => [
                'label' => 'igniter.orange::default.builder.label_subtitle',
                'type' => 'textarea',
                'validationRule' => ['nullable', 'string', 'max:1000'],
            ],
            'level' => [
                'label' => 'igniter.orange::default.builder.label_heading_level',
                'type' => 'radiotoggle',
                'default' => 'h2',
                'span' => 'left',
                'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'],
                'validationRule' => ['in:h1,h2,h3,h4'],
            ],
            'alignment' => array_merge($this->alignmentField(), ['span' => 'right']),
        ];
    }
}
