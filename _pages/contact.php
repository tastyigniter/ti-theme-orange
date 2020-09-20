---
title: 'main::lang.contact.title'
layout: default
permalink: /contact
'[contact]': null
description: ''
---
<div class="container">
    <div class="row">
        <div class="col-md-6 m-auto py-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="contact-title mb-3"><?= lang('igniter.frontend::default.contact.text_summary'); ?></h4>
                    <?= component('contact'); ?>
                </div>
            </div>
        </div>
    </div>
</div>