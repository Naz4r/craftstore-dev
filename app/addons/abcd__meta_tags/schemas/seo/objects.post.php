<?php

$schema['t'] = [
    'table' => '?:abcd__meta_tags_descriptions',
    'description' => 'page_title',
    'dispatch' => 'discussion.view',
    'item' => 'thread_id',
    'condition' => '',
    'name' => 'page_name',
    'pager' => false,
    'option' => 'seo_other_type',
    'exist_function' => function ($thread_id) {
        return db_get_field('SELECT thread_id FROM ?:discussion WHERE thread_id = ?i', $thread_id);
    },
];

return $schema;