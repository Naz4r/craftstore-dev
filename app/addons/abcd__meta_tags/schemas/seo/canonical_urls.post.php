<?php

$schema['discussion']['view'] = [
    'base_url' => 'discussion.view&thread_id=[thread_id]',
    'request_handlers' => [
        'thread_id' => true,
    ],
];

return $schema;
