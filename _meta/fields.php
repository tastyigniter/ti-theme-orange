<?php

/**
 * Theme config file
 *
 */

$backgroundOptions = [
    'contain' => 'Contain',
    'tiled' => 'Tiled',
    'cover' => 'Cover',
    'centered' => 'Centered',
];

return [
    // Set form fields for the admin theme customisation.
    'form' => [
        'general' => [
            'title' => 'General',
            'fields' => [
                'logo_image' => [
                    'label' => 'Logo Image',
                    'span' => 'left',
                    'comment' => 'Upload custom logo or text to your website.',
                    'type' => 'mediafinder',
                ],
                'favicon' => [
                    'label' => 'Favicon',
                    'type' => 'mediafinder',
                    'span' => 'right',
                    'comment' => 'Upload your favicon ( png, ico, jpg, gif or bmp ).',
                ],
                'logo_text' => [
                    'label' => 'Logo Text',
                    'type' => 'text',
                    'span' => 'left',
                ],
                'logo_height' => [
                    'label' => 'Logo Height',
                    'type' => 'text',
                    'span' => 'right',
                    'default' => '40px',
                    'rules' => 'required',
                ],
                'font.family' => [
                    'label' => 'Font Family',
                    'type' => 'text',
                    'span' => 'left',
                    'default' => '"Titillium Web",Arial,sans-serif',
                    'comment' => 'The font family to use for the main body text.',
                    'rules' => 'required',
                    'assetVar' => 'font-family-sans-serif',
                ],
                'font.weight' => [
                    'label' => 'Font Weight',
                    'type' => 'text',
                    'span' => 'right',
                    'rules' => 'required',
                    'default' => '400',
                    'assetVar' => 'font-weight-normal',
                ],
            ],
        ],
        'colors' => [
            'title' => 'Colors',
            'fields' => [
                'body.background' => [
                    'label' => 'Body background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'default' => '#F5F5F5',
                    'rules' => 'required',
                    'assetVar' => 'body-bg',
                ],
                'font.color' => [
                    'label' => 'Font Color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'default' => '#333333',
                    'rules' => 'required',
                    'assetVar' => 'body-color',
                ],
                'button.default.background' => [
                    'label' => 'Default background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'default' => '#64544d',
                    'rules' => 'required',
                ],
                'button.primary.background' => [
                    'label' => 'Primary background color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'default' => '#ed561a',
                    'rules' => 'required',
                    'assetVar' => 'primary',
                ],
                'button.success.background' => [
                    'label' => 'Success background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'default' => '#28A745',
                    'rules' => 'required',
                    'assetVar' => 'success',
                ],
                'button.info.background' => [
                    'label' => 'Info background color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'default' => '#17A2b8',
                    'rules' => 'required',
                    'assetVar' => 'info',
                ],
                'button.warning.background' => [
                    'label' => 'Warning background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'default' => '#FFC107',
                    'rules' => 'required',
                    'assetVar' => 'warning',
                ],
                'button.danger.background' => [
                    'label' => 'Danger background color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'default' => '#DC3545',
                    'rules' => 'required',
                    'assetVar' => 'danger',
                ],
            ]
        ],
        'navigation' => [
            'title' => 'Navigation',
            'fields' => [
                'heading.background' => [
                    'label' => 'Nav background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'rules' => 'required',
                    'default' => '#FFFFFF',
                    'assetVar' => 'navbar-top-bg',
                ],
                'heading.color' => [
                    'label' => 'Nav font color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'default' => '#ED561A',
                    'rules' => 'required',
                    'assetVar' => 'navbar-link-color',
                ],
                'footer.background' => [
                    'label' => 'Top footer background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'default' => '#64544d',
                    'rules' => 'required',
                    'assetVar' => 'footer-top-bg',
                ],
                'footer.font_color' => [
                    'label' => 'Top footer font color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'default' => 'rgba(255, 255, 255, 0.75)',
                    'rules' => 'required',
                    'assetVar' => 'footer-link-color',
                ],
                'footer.bottom_background' => [
                    'label' => 'Bottom footer background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'default' => '#372b27',
                    'rules' => 'required',
                    'assetVar' => 'footer-bottom-bg',
                ],
            ]
        ],
        'social' => [
            'title' => 'Social',
            'fields' => [
                'social' => [
                    'type' => 'repeater',
                    'commentAbove' => 'Add full URL for your social network profiles',
                    'form' => [
                        'fields' => [
                            'class' => [
                                'label' => 'Icon css class',
                                'type' => 'text',
                                'rules' => 'required',
                                'default' => 'fab fa-facebook',
                            ],
                            'title' => [
                                'label' => 'Icon title',
                                'type' => 'text',
                                'rules' => 'required',
                                'default' => 'Facebook',
                            ],
                            'url' => [
                                'label' => 'Icon Url',
                                'type' => 'text',
                                'rules' => 'required',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'advanced' => [
            'title' => 'Advanced',
            'fields' => [
                'display_crumbs' => [
                    'label' => 'Display Breadcrumbs',
                    'type' => 'switch',
                    'span' => 'left',
                    'default' => 1,
                    'rules' => 'required|numeric',
                ],
                'hide_admin_link' => [
                    'label' => 'Hide footer admin link',
                    'type' => 'switch',
                    'span' => 'right',
                    'rules' => 'required|numeric',
                ],
                'ga_tracking_code' => [
                    'label' => 'GA Tracking Code',
                    'type' => 'textarea',
                    'comment' => 'Paste your Google Analytics Tracking Code here.',
                    'attribute' => [
                        'rows' => '10',
                    ],
                ],
                'custom_css' => [
                    'label' => 'Add custom CSS',
                    'comment' => 'Paste your custom CSS code here.',
                    'type' => 'textarea',
                    'rows' => '9',
                ],
                'custom_js' => [
                    'label' => 'Add custom Javascript',
                    'comment' => 'Paste your custom Javascript code here.',
                    'type' => 'textarea',
                    'rows' => '9',
                ],
            ],
        ],
        'gdpr' => [
            'title' => 'GDPR (EU cookie settings)',
            'fields' => [
                'enable_gdpr' => [
                    'label' => 'Enable Cookie Banner',
                    'type' => 'switch',
                    'default' => true,
                ],
                'gdpr_cookie_message' => [
                    'label' => 'Cookie Message',
                    'type' => 'textarea',
                    'default' => 'We use own and third party cookies to improve our services. If you continue to browse, consider accepting its use',
                    'rules' => 'required|string',
                    'attribute' => [
                        'rows' => '10',
                    ],
                ],
                'gdpr_accept_text' => [
                    'label' => 'Accept cookie text',
                    'type' => 'text',
                    'default' => 'OK',
                    'rules' => 'required|max:128',
                ],
                'gdpr_more_info_text' => [
                    'label' => 'More information text',
                    'type' => 'text',
                    'default' => 'More Information',
                    'rules' => 'required|max:128',
                ],
                'gdpr_more_info_link' => [
                    'label' => 'More information link',
                    'type' => 'select',
                    'options' => [\System\Models\Pages_model::class, 'getDropdownOptions'],
                    'rules' => 'required|string',
                ],
                'gdpr_background_color' => [
                    'label' => 'Cookie banner CSS background color attribute',
                    'type' => 'colorpicker',
                    'default' => '#FFF',
                    'rules' => 'required|string',
                ],
                'gdpr_text_color' => [
                    'label' => 'Cookie banner CSS text color attribute',
                    'type' => 'colorpicker',
                    'default' => '#000',
                    'rules' => 'required|string',
                ],
            ],
        ],
    ],
];
