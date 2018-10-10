---
title: main::lang.pages.title
layout: default
permalink: /pages/:slug

'[sitePage]':
    slug: ':slug'
---
<?
function onEnd()
{
    $this->title = $this['sitePage'] ? $this['sitePage']->title : $this->title;
}
?>
---
<div class="container py-4">
    <div id="heading" class="row">
        <div class="col-md-12">
            <div class="heading-section">
                <h2><?= $sitePage ? $sitePage->title : null; ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= partial('pageNav::sidebar'); ?>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <?= component('sitePage'); ?>
                </div>
            </div>
        </div>
    </div>
</div>