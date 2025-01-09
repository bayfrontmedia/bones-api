<?php

/*
 * API service errors to be used with the ApiError::respond method.
 * See: https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/exceptions.md#exception-handler
 */

return [
    400 => 'https://example.com/docs/400',
    401 => 'https://example.com/docs/401',
    402 => 'https://example.com/docs/402',
    403 => 'https://example.com/docs/403',
    404 => 'https://example.com/docs/404',
    405 => 'https://example.com/docs/405',
    406 => 'https://example.com/docs/406',
    409 => 'https://example.com/docs/409',
    429 => 'https://example.com/docs/429',
    500 => 'https://example.com/docs/500'
];