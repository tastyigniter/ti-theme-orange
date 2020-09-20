---
title: 'main::lang.account.reset.title'
layout: default
permalink: '/forgot-password/:code?'
'[session]':
    security: guest
'[account]':
    accountPage: account/account
    addressPage: account/address
    ordersPage: account/orders
    reservationsPage: account/reservations
    reviewsPage: account/reset
    inboxPage: account/inbox
    loginPage: account/login
    activationPage: account/register
    agreeRegistrationTermsPage: 1
    redirectPage: checkout/success
'[resetPassword]': null
---
<div class="container">
    <div class="row">
        <div class="col-sm-6 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h4 mb-4 font-weight-normal">
                        <?= lang('main::lang.account.reset.text_heading'); ?>
                    </h1>

                    <?= component('resetPassword'); ?>
                </div>
            </div>
        </div>
    </div>
</div>