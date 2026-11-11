<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class ImageText extends ContentBlock
{
    protected array $htmlFields = ['content'];

    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'image-text',
            'name' => 'igniter.orange::default.builder.block_image_text',
            'description' => 'igniter.orange::default.builder.block_image_text_desc',
            'icon' => 'fa fa-panorama',
            'wide' => true,
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return array_merge([
            'image' => [
                'label' => 'igniter.orange::default.builder.label_image',
                'type' => 'mediafinder',
                'span' => 'left',
                'validationRule' => ['required', 'string'],
            ],
            'image_position' => [
                'label' => 'igniter.orange::default.builder.label_image_position',
                'type' => 'radiotoggle',
                'default' => 'start',
                'span' => 'right',
                'options' => [
                    'start' => 'igniter.orange::default.builder.text_left',
                    'end' => 'igniter.orange::default.builder.text_right',
                ],
                'validationRule' => ['in:start,end'],
            ],
            'title' => [
                'label' => 'igniter.orange::default.builder.label_title',
                'type' => 'text',
                'validationRule' => ['nullable', 'string', 'max:255'],
            ],
            'content' => [
                'label' => 'igniter.orange::default.builder.label_content',
                'type' => 'richeditor',
            ],
        ], $this->buttonFields());
    }

    #[Override]
    public function resolve(array $settings): array
    {
        return array_merge($settings, [
            'url' => $settings['image'] ? media_url($settings['image']) : null,
        ]);
    }
}
