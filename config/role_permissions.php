<?php

return [
    'admin' => [
        'users.read',
        'users.update-role',
        'users.delete',
        'catalogs.read',
        'catalogs.write',
        'quotes.manage',
    ],
    'vendedor' => [
        'catalogs.read',
        'quotes.manage',
    ],
    'desarrollador' => [
        'catalogs.read',
        'catalogs.write',
        'quotes.manage',
    ],
];
