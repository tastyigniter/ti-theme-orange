---
title: 'main::lang.account.register.title'
permalink: /register
description: ''
layout: default

'[session]':
    security: guest

'[account]':
    accountPage: account/account
    redirectPage: account/account
    loginPage: account/login
    agreeRegistrationTermsPage: 1

---
<div class="container">
    <div class="row">
        <div class="col-sm-6 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h4 mb-4 font-weight-normal">
                        <?= lang('main::lang.account.login.text_register'); ?>
                    </h1>

                    <?= partial('account::register'); ?>
                </div>
            </div>
        </div>
    </div>
</div>