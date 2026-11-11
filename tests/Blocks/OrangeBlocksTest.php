<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Blocks;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Classes\BlockManager;
use Igniter\Main\Classes\PageBuilder;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Orange\Blocks\AccountNav;
use Igniter\Orange\Blocks\BackLink;
use Igniter\Orange\Blocks\CallToAction;
use Igniter\Orange\Blocks\FulfillmentBlock;
use Igniter\Orange\Blocks\Heading;
use Igniter\Orange\Blocks\Html;
use Igniter\Orange\Blocks\Image;
use Igniter\Orange\Blocks\ImageText;
use Igniter\Orange\Blocks\OrangeBlocks;
use Igniter\Orange\Blocks\OrangeComponentBlock;
use Igniter\Orange\Blocks\RichText;
use Igniter\Orange\Blocks\Spacer;
use Igniter\System\Classes\ComponentManager;

beforeEach(function(): void {
    $this->theme = resolve(ThemeManager::class)->findTheme('igniter-orange');
});

it('registers the theme blocks', function(): void {
    $blocks = resolve(BlockManager::class)->listBlocks($this->theme);

    expect(array_keys($blocks))->toContain(
        'heading', 'rich-text', 'image', 'image-text', 'call-to-action', 'html', 'spacer', 'back-link', 'account-nav',
        'slider', 'banner-preview', 'featured-items', 'local-search', 'checkout', 'booking', 'login',
    )->and($blocks['slider'])->toBeInstanceOf(OrangeComponentBlock::class);
});

it('wraps only registered configurable components', function(): void {
    $manager = resolve(ComponentManager::class);

    foreach (array_keys(OrangeBlocks::componentDetails()) as $componentCode) {
        expect($manager->isConfigurableComponent($componentCode))->toBeTrue($componentCode.' is not a configurable component');
    }
});

it('limits functional blocks to their pages', function(): void {
    $manager = resolve(BlockManager::class);

    expect($manager->findBlock($this->theme, 'checkout', 'home'))->toBeNull()
        ->and($manager->findBlock($this->theme, 'checkout', 'checkout.checkout'))->not->toBeNull()
        ->and($manager->findBlock($this->theme, 'account-nav', 'home'))->toBeNull()
        ->and($manager->findBlock($this->theme, 'account-nav', 'account.orders'))->not->toBeNull()
        ->and($manager->findBlock($this->theme, 'featured-items', 'home'))->not->toBeNull();
});

it('builds component block fields from the component properties', function(): void {
    $block = resolve(BlockManager::class)->findBlock($this->theme, 'featured-items');

    expect(array_keys($block->defineFields()))->toBe(['title', 'items', 'limit', 'itemsPerRow', 'showThumb', 'itemWidth', 'itemHeight', 'wrapper_card', 'wrapper_class'])
        ->and($block->defaults())->toMatchArray(['limit' => 6, 'itemsPerRow' => 3]);
});

it('defines content block details and fields', function(string $class, string $code, array $fields): void {
    $block = new $class;

    expect($block->getCode())->toBe($code)
        ->and(array_keys($block->defineFields()))->toBe($fields);
})->with([
    [Heading::class, 'heading', ['title', 'subtitle', 'level', 'alignment']],
    [RichText::class, 'rich-text', ['content']],
    [Image::class, 'image', ['image', 'alt', 'link', 'rounded']],
    [ImageText::class, 'image-text', ['image', 'image_position', 'title', 'content', 'button_text', 'button_link']],
    [CallToAction::class, 'call-to-action', ['title', 'text', 'button_text', 'button_link', 'style', 'alignment']],
    [Html::class, 'html', ['html']],
    [Spacer::class, 'spacer', ['size', 'divider']],
    [BackLink::class, 'back-link', ['text', 'page']],
    [AccountNav::class, 'account-nav', []],
]);

it('removes unsafe markup from html settings', function(): void {
    $settings = (new RichText)->sanitize(['content' => '<p>Hello</p><script>alert(1)</script>', 'unknown' => 'x']);
    $html = (new Html)->sanitize(['html' => '<a href="javascript:alert(1)" onclick="x()">Link</a>']);

    $embed = (new Html)->sanitize(['html' => '<iframe src="https://www.youtube.com/embed/abc"></iframe><iframe src="https://evil.example/x"></iframe>']);

    expect($settings)->toBe(['content' => '<p>Hello</p>'])
        ->and($html['html'])->not->toContain('javascript:')->not->toContain('onclick')
        ->and($embed['html'])->toContain('https://www.youtube.com/embed/abc')->not->toContain('evil.example');
});

it('resolves image urls', function(): void {
    $image = new Image;
    $imageText = new ImageText;

    expect($image->resolve(array_merge($image->defaults(), ['image' => 'photo.jpg']))['url'])->toEndWith('photo.jpg')
        ->and($image->resolve($image->defaults())['url'])->toBeNull()
        ->and($imageText->resolve($imageText->defaults())['url'])->toBeNull()
        ->and($image->summary(['alt' => '', 'image' => 'photo.jpg']))->toBe('photo.jpg')
        ->and($image->summary(['alt' => 'Our dining room', 'image' => 'photo.jpg']))->toBe('Our dining room')
        ->and((new Spacer)->summary(['size' => 'lg']))->toBe('');
});

it('validates button links', function(): void {
    $rules = (new CallToAction)->validationRules();

    expect(validator(['title' => 'Order now', 'button_link' => 'javascript:alert(1)', 'style' => 'primary'], $rules)->fails())->toBeTrue()
        ->and(validator(['title' => 'Order now', 'button_link' => '/local/menus', 'style' => 'primary'], $rules)->passes())->toBeTrue();
});

it('declares the home page default layout', function(): void {
    $page = $this->theme->getBuildablePage('home');

    expect($page['default'])->toHaveCount(3)
        ->and(array_column($page['default'], 'layout'))->toBe(['cols-1', 'center-3', 'cols-1']);
});

it('renders content blocks with the theme views', function(): void {
    $html = resolve(PageBuilder::class)->renderBlade($this->theme, resolve(PageBuilder::class)->normalize($this->theme, [
        [
            'id' => 's_content',
            'layout' => 'sidebar-left-3',
            'settings' => ['anchor' => 'About Us', 'background_color' => '#fff000', 'css_class' => 'about'],
            'columns' => [
                ['blocks' => [
                    ['code' => 'spacer', 'settings' => ['divider' => true]],
                ]],
                ['blocks' => [
                    ['code' => 'heading', 'settings' => ['title' => 'Our story', 'subtitle' => 'Since 1999', 'level' => 'h1', 'alignment' => 'center']],
                    ['code' => 'rich-text', 'settings' => ['content' => '<p>Fresh food</p>']],
                    ['code' => 'image', 'settings' => ['image' => 'photo.jpg', 'alt' => 'Room', 'link' => '/contact']],
                    ['code' => 'image-text', 'settings' => ['image' => 'photo.jpg', 'title' => 'Kitchen', 'content' => '<p>Open</p>', 'image_position' => 'end', 'button_text' => 'Book', 'button_link' => '/reservation']],
                    ['code' => 'call-to-action', 'settings' => ['title' => 'Hungry?', 'text' => 'Order now', 'button_text' => 'Menu', 'button_link' => '/local/menus', 'style' => 'dark']],
                    ['code' => 'html', 'settings' => ['html' => '<div class="custom">Custom</div>']],
                ]],
            ],
        ],
        ['id' => 's_equal', 'layout' => 'cols-5', 'settings' => ['container' => 'full', 'background_color' => 'red; x', 'background_image' => 'bg.jpg']],
    ], 'home'));

    expect($html)
        ->toContain('id="about-us"')
        ->toContain('background-color: #fff000')
        ->not->toContain('red; x')
        ->toContain('background-image: url(')
        ->toContain('class="col-12 col-lg-9"')
        ->toContain('col-12 col-lg d-none d-lg-block')
        ->toContain('<h1 class="mb-2">Our story</h1>')
        ->toContain('<p>Fresh food</p>')
        ->toContain('alt="Room"')
        ->toContain('order-md-last')
        ->toContain('bg-dark text-white')
        ->toContain('<div class="custom">Custom</div>')
        ->toContain('<hr class="my-0"/>');
});

it('renders the home page from the page builder sections', function(): void {
    $this->get(route('igniter.theme.home'))
        ->assertOk()
        ->assertSee('id="s_home_slider"', false)
        ->assertSee('id="s_home_search"', false)
        ->assertSee('b_home_search');
});

it('loads the admin page builder for the home page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.main.themes', ['slug' => 'builder/igniter-orange/home']))
        ->assertOk()
        ->assertSee('data-control="page-builder"', false)
        ->assertSee('b_home_search')
        ->assertSee('featured-items');
});

it('loads component and content block settings forms in the admin', function(string $code, string $expected): void {
    actingAsSuperUser()
        ->post(route('igniter.main.themes', ['slug' => 'builder/igniter-orange/home']), [
            'code' => $code,
            'settings' => '{}',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'builderFormSections::onLoadBlockForm',
        ])
        ->assertOk()
        ->assertSee($expected, false);
})->with([
    ['featured-items', 'builderFormSectionsSettings[itemsPerRow]'],
    ['slider', 'builderFormSectionsSettings[delayInterval]'],
    ['rich-text', 'builderFormSectionsSettings[content]'],
    ['image', 'builderFormSectionsSettings[image]'],
]);

it('saves block settings from the admin form', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.main.themes', ['slug' => 'builder/igniter-orange/home']), [
            'code' => 'call-to-action',
            'builderFormSectionsSettings' => [
                'title' => 'Hungry?',
                'button_text' => 'Order',
                'button_link' => '/local/menus',
                'style' => 'dark',
                'alignment' => 'center',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'builderFormSections::onValidateBlockForm',
        ])
        ->assertOk()
        ->assertJsonPath('settings.title', 'Hungry?')
        ->assertJsonPath('settings.style', 'dark')
        ->assertJsonPath('summary', 'Hungry?');
});

it('keeps every block of each page default when normalized', function(): void {
    $builder = resolve(PageBuilder::class);

    foreach ($this->theme->getBuildablePages() as $pageCode => $page) {
        $expected = collect($page['default'])->flatMap(fn($section) => collect($section['columns'])->flatMap(fn($column): array => array_column($column['blocks'], 'code')))->all();
        $normalized = collect($builder->forPage($this->theme, $pageCode))->flatMap(fn($section) => collect($section['columns'])->flatMap(fn($column): array => array_column($column['blocks'], 'code')))->all();

        expect($normalized)->toBe($expected, $pageCode.' default lost blocks')
            ->and(array_diff($page['required'], $normalized))->toBe([], $pageCode.' default is missing required blocks');
    }
});

it('declares buildable pages for the theme pages', function(): void {
    expect(array_keys($this->theme->getBuildablePages()))->toBe([
        'home', 'local.menus', 'local.reviews', 'cart', 'checkout.checkout', 'checkout.success',
        'reservation.reservation', 'reservation.success', 'contact', 'locations',
        'account.login', 'account.register', 'account.reset', 'account.account', 'account.address',
        'account.orders', 'account.order', 'account.reservations', 'account.reservation',
    ]);
});

it('adds card and class options to component blocks', function(): void {
    $block = resolve(BlockManager::class)->findBlock($this->theme, 'featured-items');

    expect($block)->toBeInstanceOf(OrangeComponentBlock::class)
        ->and($block->defineFields())->toHaveKeys(['wrapper_card', 'wrapper_class'])
        ->and($block->defaults())->toMatchArray(['wrapper_card' => false, 'wrapper_class' => null])
        ->and($block->summary(['title' => '', 'wrapper_class' => 'shadow']))->toBe('');
});

it('wraps component blocks in a card or css class', function(): void {
    $block = OrangeComponentBlock::make('igniter-orange::slider');
    $settings = array_merge($block->defaults(), ['code' => 'home-slider']);

    $plain = $block->render('igniter-orange', ['id' => 'b_1', 'settings' => $settings]);
    $card = $block->render('igniter-orange', ['id' => 'b_2', 'settings' => array_merge($settings, ['wrapper_card' => true, 'wrapper_class' => 'shadow-sm'])]);
    $classed = $block->render('igniter-orange', ['id' => 'b_3', 'settings' => array_merge($settings, ['wrapper_class' => 'd-none d-lg-block <script>'])]);

    expect($plain)->not->toContain('class="card mb-3')
        ->and($card)->toStartWith('<div class="card mb-3 shadow-sm"><div class="card-body">')
        ->and($classed)->toStartWith('<div class="d-none d-lg-block script">')
        ->and($plain)->not->toContain('wrapper_card');
});

it('renders the back link block', function(): void {
    $block = new BackLink;
    $settings = array_merge($block->defaults(), ['page' => 'locations']);

    $html = $block->render('igniter-orange', ['settings' => $settings, 'data' => $settings]);

    expect($html)->toContain('fa-arrow-left-long')
        ->toContain(lang('igniter.orange::default.button_back'))
        ->and($block->summary($settings))->toBe(lang('igniter.orange::default.button_back').' → locations')
        ->and(array_keys($block->defineFields()['page']['options']()))->toContain('home');
});

it('renders theme pages from the page builder sections', function(string $route, string $sectionId): void {
    $this->get(route($route))
        ->assertOk()
        ->assertSee('id="'.$sectionId.'"', false);
})->with([
    ['igniter.theme.account.login', 's_login'],
    ['igniter.theme.account.register', 's_register'],
    ['igniter.theme.account.reset', 's_reset'],
    ['igniter.theme.contact', 's_contact'],
    ['igniter.theme.locations', 's_locations'],
]);

it('renders the fulfillment modal once with the fulfillment block', function(): void {
    Location::setModel(LocationModel::factory()->create());
    $block = resolve(BlockManager::class)->findBlock($this->theme, 'fulfillment', 'local.menus');
    $settings = $block->defaults();

    $first = $block->render('igniter-orange', ['id' => 'b_1', 'settings' => $settings]);
    $second = $block->render('igniter-orange', ['id' => 'b_2', 'settings' => $settings]);

    expect($block)->toBeInstanceOf(FulfillmentBlock::class)
        ->and(substr_count($first, 'id="fulfillmentModal"'))->toBe(1)
        ->and($second)->not->toContain('id="fulfillmentModal"')
        ->and(resolve(BlockManager::class)->findBlock($this->theme, 'fulfillment', 'checkout.checkout'))->toBeNull();
});

it('uses the 8/4 layout on the menus and reviews pages', function(): void {
    foreach (['local.menus', 'local.reviews'] as $pageCode) {
        $layouts = array_column($this->theme->getBuildablePage($pageCode)['default'], 'layout');

        expect($layouts)->toContain('sidebar-right-4')->not->toContain('sidebar-right-3');
    }
});
