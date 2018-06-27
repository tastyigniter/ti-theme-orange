---
title: main::default.contact.title
layout: default
permalink: /contact

'[contact]':
---
<div class="container">
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card mb-3">
                <div class="card-body">
                    <h1 class="h3 card-title"><?= $contact->location->getName(); ?></h1>
                    <div class="row contact-info mb-2">
                        <div class="col-1"><i class="fa fa-globe"></i></div>
                        <div class="col"><?= format_address($contact->location->getAddress()); ?></div>
                    </div>
                    <div class="row contact-info">
                        <div class="col-1"><i class="fa fa-phone"></i></div>
                        <div class="col"><?= $contact->location->getTelephone(); ?></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="contact-title mb-3"><?= lang('sampoyigi.frontend::default.contact.text_summary'); ?></h4>
                    <?= component('contact'); ?>
                </div>
            </div>
        </div>
    </div>
</div>