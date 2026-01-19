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
    ['path' => '/transaction/edit', 'method' => 'POST', 'handler' => 'process_edit_transaction'],
    ['path' => '/transaction/delete', 'method' => 'POST', 'handler' => 'process_delete_transaction'],
    ['path' => '/statistics', 'method' => 'GET', 'handler' => 'show_statistics'],
    ['path' => '/profile', 'method' => 'GET', 'handler' => 'show_profile'],
    ['path' => '/profile/update', 'method' => 'POST', 'handler' => 'update_profile'],
    ['path' => '/profile/avatar/upload', 'method' => 'POST', 'handler' => 'upload_avatar'],
    ['path' => '/admin/dashboard', 'method' => 'GET', 'handler' => 'show_admin_dashboard'],
    ['path' => '/admin/users', 'method' => 'GET', 'handler' => 'show_users_management'],
    ['path' => '/logout', 'method' => 'GET', 'handler' => 'process_logout']
];