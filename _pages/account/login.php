---
title: 'main::lang.account.login.title'
layout: default
permalink: /login
'[session]':
    security: guest
'[account]': null
description: ''
'[socialite]':
    errorPage: account/login
    successPage: account/account
---
<div class="container">
    <div class="row">
        <div class="col-sm-4 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h4 mb-4 font-weight-normal">
                        <?= lang('main::lang.account.login.text_login'); ?>
                    </h1>

                    <?= partial('account::login'); ?>

                    <div class="row">
                        <div class="col-md-5 p-sm-0">
                            <a class="btn btn-link btn-lg" href="<?= site_url('account/reset'); ?>">
                                <span class="small"><?= lang('main::lang.account.login.text_forgot'); ?></span>
                            </a>
                        </div>
                        <?php if ((bool)$canRegister) { ?>
                        <div class="col-sm-7  text-sm-right">
                            <a
                                class="btn btn-link btn-lg"
                                href="<?= site_url('account/register'); ?>"
                            ><span class="small"><?= lang('main::lang.account.login.button_register'); ?></span>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
<!--                  <= component('socialite'); ?>-->
                </div>
            </div>
        </div>
    </div>
</div>