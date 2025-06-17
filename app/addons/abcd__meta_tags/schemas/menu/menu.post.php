<?php

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

$schema['central']['ab__addons']['items']['abcd__meta_tags'] = [
    'attrs' => [
        'class' => 'is-addon',
    ],
    'href' => 'ab__dotd.help',
    'position' => 1000,
    'subitems' => [
        'abcd__meta_tags.settings' => [
            'href' => 'addons.update&addon=abcd__meta_tags',
            'alt' => 'addons.update&addon=abcd__meta_tags',
            'position' => 0,
        ],
        'abcd__meta_tags.settings_meta_tags' => [
            'href' => 'abcd__meta_tags.manage',
            'alt' => 'abcd__meta_tags.manage',
            'position' => 20,
        ],
    ],
];
$schema['central']['website']['items']['comments_and_reviews']['subitems']['abcd__meta_tags.manage'] = [
    'href'     => 'abcd__meta_tags.manage',
    'alt'      => 'abcd__meta_tags.manage',
    'position' => 10,
    'title'    => __('abcd__meta_tags.menu_title'),
];
$schema['central']['website']['items']['comments_and_reviews']['subitems']['discussion_manager.manage'] = [
    'href'     => 'discussion_manager.manage',
    'alt'      => 'discussion_manager.manage',
    'position' => 20,
    'title'    => __('discussion.comments_and_reviews_menu'),
];

return $schema;
