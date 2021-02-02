<?php

// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});
Breadcrumbs::for('edit_profil', function ($trail, $nip) {
    $trail->push('Edit Profil', route('edit_profil', $nip));
});
Breadcrumbs::for('manage_account', function ($trail) {
    $trail->push('Manage Account', route('manage_account'));
});
// Home
Breadcrumbs::for('submission', function ($trail) {
    $trail->push('Submission', route('submission'));
});

// Home > About
Breadcrumbs::for('edit_data_account', function ($trail,$nip) {
    $trail->parent('manage_account');
    $trail->push('Edit Account Data', route('edit_data_account',$nip));
});
Breadcrumbs::for('add_account', function ($trail) {
    $trail->parent('manage_account');
    $trail->push('Add New Account', route('add_account'));
});
// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
    $trail->parent('home');
    $trail->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});