<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class Html extends ContentBlock
{
    protected array $htmlFields = ['html'];

    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'html',
            'name' => 'igniter.orange::default.builder.block_html',
            'description' => 'igniter.orange::default.builder.block_html_desc',
            'icon' => 'fa fa-code',
        ];
    }

    /**
     * Allows layout markup, classes and embeds from trusted video and map
     * providers. Scripts, event handlers and unsafe URLs are still removed.
     */
    #[Override]
    protected function purifierConfig(): array
    {
        return [
            'Core.Encoding' => 'utf-8',
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => implode(',', [
                'div[class|id|style]', 'section[class|id|style]', 'span[class|style]', 'p[class|style]',
                'h1[class]', 'h2[class]', 'h3[class]', 'h4[class]', 'h5[class]', 'h6[class]',
                'a[href|title|target|rel|class]', 'img[src|alt|width|height|class]', 'figure[class]', 'figcaption',
                'ul[class]', 'ol[class]', 'li[class]', 'strong', 'b', 'em', 'i', 'u', 's', 'small', 'br', 'hr',
                'blockquote[class]', 'table[class]', 'thead', 'tbody', 'tr', 'th[class]', 'td[class]',
                'iframe[src|width|height|title|frameborder|class]',
            ]),
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^https://(www\.youtube(-nocookie)?\.com/embed/|player\.vimeo\.com/video/|www\.google\.com/maps/embed)%',
            'Attr.EnableID' => true,
            'Attr.AllowedFrameTargets' => '_blank',
            'CSS.AllowedProperties' => 'color,background-color,text-align,font-size,font-weight,font-style,text-decoration,'
                .'margin,margin-top,margin-bottom,padding,padding-top,padding-bottom,width,max-width,height',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => false,
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return [
            'html' => [
                'label' => 'igniter.orange::default.builder.label_html',
                'type' => 'codeeditor',
                'mode' => 'html',
                'comment' => 'igniter.orange::default.builder.help_html',
            ],
        ];
    }
}
