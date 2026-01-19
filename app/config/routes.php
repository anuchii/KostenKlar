<?php

return [
    ['path' => '/', 'method' => 'GET', 'handler' => 'show_home'],
    ['path' => '/login', 'method' => 'GET', 'handler' => 'show_login'],
    ['path' => '/login', 'method' => 'POST', 'handler' => 'process_login'],
    ['path' => '/register', 'method' => 'GET', 'handler' => 'show_register'],
    ['path' => '/register', 'method' => 'POST', 'handler' => 'process_register'],
    ['path' => '/dashboard', 'method' => 'GET', 'handler' => 'show_user_dashboard'],
    ['path' => '/admin/dashboard', 'method' => 'GET', 'handler' => 'show_admin_dashboard'],
    ['path' => '/transaction/new', 'method' => 'GET', 'handler' => 'show_new_transaction'],
    ['path' => '/transaction/new', 'method' => 'POST', 'handler' => 'process_new_transaction'],
    ['path' => '/transaction/show', 'method' => 'GET', 'handler' => 'show_transaction'],
    ['path' => '/transaction/edit', 'method' => 'GET', 'handler' => 'show_edit_transaction'],
    ['path' => '/transaction/edit', 'method' => 'POST', 'handler' => 'process_edit_transaction']
];