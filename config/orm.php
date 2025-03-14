<?php

/*
 * Configuration required by the ORM service.
 *
 * For more information, see:
 * https://github.com/bayfrontmedia/bones-service-orm/blob/master/docs/setup.md#configuration
 */

return [
    'resource' => [
        'default_limit' => 100, // Default resource query limit when none is specified
        'max_limit' => -1, // Default resource maximum limit allowed to query, or -1 for unlimited
        'max_related_depth' => 3 // Default resource maximum related field depth allowed to query
    ]
];