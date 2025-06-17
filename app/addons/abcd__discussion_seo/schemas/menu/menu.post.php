<?php

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

$schema['central']['ab__addons']['items']['abcd__discussion_seo'] = [
    'attrs' => [
        'class' => 'is-addon',
    ],
    'href' => 'abcd__discussion_seo.manage',
    'position' => 1000,
    'subitems' => [
        'abcd__discussion_seo.settings_discussion_seo' => [
            'href' => 'abcd__discussion_seo.manage',
            'alt' => 'abcd__discussion_seo.manage',
            'position' => 20,
        ],
    ],
];
$schema['central']['website']['items']['comments_and_reviews']['subitems']['abcd__discussion_seo.manage'] = [
    'href'     => 'abcd__discussion_seo.manage',
    'alt'      => 'abcd__discussion_seo.manage',
    'position' => 10,
    'title'    => __('abcd__discussion_seo.menu_title'),
];
$schema['central']['website']['items']['comments_and_reviews']['subitems']['discussion_manager.manage'] = [
    'href'     => 'discussion_manager.manage',
    'alt'      => 'discussion_manager.manage',
    'position' => 20,
    'title'    => __('discussion.comments_and_reviews_menu'),
];

return $schema;
