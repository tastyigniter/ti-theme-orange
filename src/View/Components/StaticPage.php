<?php

namespace Igniter\Pages\Components;

use Igniter\Pages\Models\Page;
use Igniter\System\Classes\BaseComponent;

class StaticPage extends BaseComponent
{
    /**
     * @var \Igniter\Pages\Models\Page
     */
    protected $staticPage;

    public function defineProperties(): array
    {
        return [
            'slug' => [
                'label' => 'igniter.pages::default.label_permalink_slug',
                'default' => '{{ :slug }}',
                'type' => 'text',
                'validationRule' => 'required|string',
            ],
        ];
    }

    public function onRun()
    {
        $this->page['staticPage'] = $this->staticPage = $this->loadPage();

        if ($this->staticPage) {
            $this->page->title = $this->staticPage->title;
            $this->page->description = $this->staticPage->description;
        }
    }

    public function content()
    {
        return $this->staticPage ? $this->staticPage->content : '';
    }

    protected function loadPage()
    {
        $slug = $this->param('slug', $this->property('slug'));

        $page = Page::where('permalink_slug', $slug);

        return $page->whereIsEnabled()->first();
    }
}
