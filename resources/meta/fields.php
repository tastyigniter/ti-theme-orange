<?php

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
                    'rules' => 'nullable|string',
                ],
                'favicon' => [
                    'label' => 'Favicon',
                    'type' => 'mediafinder',
                    'span' => 'right',
                    'comment' => 'Upload your favicon ( png, ico, jpg, gif or bmp ).',
                    'rules' => 'nullable|string',
                ],
                'logo_text' => [
                    'label' => 'Logo Text',
                    'type' => 'text',
                    'span' => 'left',
                    'rules' => 'nullable|string',
                ],
                'logo_height' => [
                    'label' => 'Logo Height',
                    'type' => 'text',
                    'span' => 'right',
                    'default' => '40px',
                    'rules' => 'required',
                    'assetVar' => 'logo-height',
                ],
                'font-url' => [
                    'label' => 'Base Google Fonts Url',
                    'type' => 'text',
                    'cssClass' => 'col-4',
                    'default' => 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap',
                    'comment' => 'Grab your CSS URL from <a href="https://fonts.google.com/" target="_blank">Google Fonts</a> and paste it here.',
                    'rules' => 'required|startsWith:https://fonts.googleapis.com/',
                    'assetVar' => 'font-family-sans-serif',
                ],
                'font-download' => [
                    'label' => 'Download fonts locally',
                    'type' => 'switch',
                    'cssClass' => 'col-2',
                    'default' => false,
                    'rules' => 'boolean',
                ],
                'font-family' => [
                    'label' => 'Base Font Family',
                    'type' => 'text',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'default' => '"Inter",Arial,sans-serif',
                    'comment' => 'The font family to use for the main body text.',
                    'rules' => 'required',
                    'assetVar' => 'font-family-sans-serif',
                ],
                'font-weight' => [
                    'label' => 'Base Font Weight',
                    'type' => 'text',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'rules' => 'required',
                    'default' => '400',
                    'assetVar' => 'font-weight-normal',
                ],
            ],
        ],
        'colors' => [
            'title' => 'Colors',
            'fields' => [
                'heading-background' => [
                    'label' => 'Nav background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'rules' => 'required',
                    'default' => '#FFFFFF',
                    'assetVar' => 'navbar-top-bg',
                ],
                'heading-color' => [
                    'label' => 'Nav font color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#FF4900',
                    'rules' => 'required',
                    'assetVar' => 'navbar-link-color',
                ],
                'footer-background' => [
                    'label' => 'Footer background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'default' => '#212529',
                    'rules' => 'required',
                    'assetVar' => 'footer-bg',
                ],
                'footer-font_color' => [
                    'label' => 'Footer font color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#FFFFFF',
                    'rules' => 'required',
                    'assetVar' => 'footer-link-color',
                ],
                'body-background' => [
                    'label' => 'Body background color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'default' => '#FFFFFF',
                    'rules' => 'required',
                    'assetVar' => 'body-bg',
                ],
                'font-color' => [
                    'label' => 'Font Color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#333333',
                    'rules' => 'required',
                    'assetVar' => 'body-color',
                ],
                'border-color' => [
                    'label' => 'Border Color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#e9ecef',
                    'rules' => 'required',
                    'assetVar' => 'border-color',
                ],
                'color-primary' => [
                    'label' => 'Primary color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'default' => '#ff4900',
                    'rules' => 'required',
                    'assetVar' => 'primary',
                ],
                'color-default' => [
                    'label' => 'Secondary color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#6C757D',
                    'rules' => 'required',
                    'assetVar' => 'secondary',
                ],
                'color-success' => [
                    'label' => 'Success color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'default' => '#28A745',
                    'rules' => 'required',
                    'assetVar' => 'success',
                ],
                'color-info' => [
                    'label' => 'Info color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#17A2b8',
                    'rules' => 'required',
                    'assetVar' => 'info',
                ],
                'color-warning' => [
                    'label' => 'Warning color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'default' => '#FFC107',
                    'rules' => 'required',
                    'assetVar' => 'warning',
                ],
                'color-danger' => [
                    'label' => 'Danger color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#DC3545',
                    'rules' => 'required',
                    'assetVar' => 'danger',
                ],
                'color-light' => [
                    'label' => 'Light color',
                    'type' => 'colorpicker',
                    'span' => 'left',
                    'cssClass' => 'flex-width',
                    'default' => '#efeded',
                    'rules' => 'required',
                    'assetVar' => 'gray-100',
                ],
                'color-dark' => [
                    'label' => 'Dark color',
                    'type' => 'colorpicker',
                    'span' => 'right',
                    'cssClass' => 'flex-width',
                    'default' => '#372b27',
                    'rules' => 'required',
                    'assetVar' => ['gray-800', 'gray-700'],
                ],
            ],
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
                                'type' => 'url',
                                'rules' => 'required|url',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'advanced' => [
            'title' => 'Advanced',
            'fields' => [
                'hide_search' => [
                    'label' => 'Hide location search bar on homepage',
                    'type' => 'switch',
                    'rules' => 'boolean',
                ],
                'ga_tracking_code' => [
                    'label' => 'Google Analytics Tracking Code',
                    'type' => 'codeeditor',
                    'size' => 'small',
                    'mode' => 'js',
                    'comment' => 'Paste your Google Analytics Tracking Code here.',
                    'rules' => 'nullable|string',
                ],
                'custom_css' => [
                    'label' => 'Add custom CSS',
                    'comment' => 'Paste your custom CSS code here.',
                    'type' => 'codeeditor',
                    'span' => 'left',
                    'size' => 'small',
                    'rules' => 'nullable|string',
                ],
                'custom_js' => [
                    'label' => 'Add custom Javascript',
                    'comment' => 'Paste your custom Javascript code here.',
                    'type' => 'codeeditor',
                    'size' => 'small',
                    'span' => 'right',
                    'mode' => 'js',
                    'rules' => 'nullable|string',
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
                    'rules' => 'boolean',
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
                    'options' => [\Igniter\Pages\Models\Page::class, 'getDropdownOptions'],
                    'rules' => 'nullable|string',
                ],
                'gdpr_background_color' => [
                    'label' => 'Cookie banner CSS background color attribute',
                    'type' => 'colorpicker',
                    'default' => '#000',
                    'rules' => 'required|string',
                ],
                'gdpr_text_color' => [
                    'label' => 'Cookie banner CSS text color attribute',
                    'type' => 'colorpicker',
                    'default' => '#FFF',
                    'rules' => 'required|string',
                ],
            ],
        ],
    ],
];
