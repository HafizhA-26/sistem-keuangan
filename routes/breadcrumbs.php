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
Breadcrumbs::for('new_submission', function ($trail) {
    $trail->parent('submission');
    $trail->push('New Submissions', route('new_submission'));
});
Breadcrumbs::for('inprogress_submission', function ($trail) {
    $trail->parent('submission');
    $trail->push('In-progress Submission', route('inprogress_submission'));
});
Breadcrumbs::for('add_submission', function ($trail) {
    $trail->parent('submission');
    $trail->push('Add New Submission', route('add_submission'));
});
Breadcrumbs::for('add_submission2', function ($trail) {
    $trail->push('Add New Submission', route('add_submission2'));
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
Breadcrumbs::for('report', function ($trail) {
    $trail->push('Report', route('report'));
});

// Home > Blog > [Category]
Breadcrumbs::for('report_transaction', function ($trail) {
    $trail->parent('report');
    $trail->push('Report Transaction', route('report_transaction'));
});
Breadcrumbs::for('report_submission', function ($trail) {
    $trail->parent('report');
    $trail->push('Report Submission', route('report_submission'));
});
Breadcrumbs::for('report_submission2', function ($trail) {
    $trail->push('Report Submission', route('report_submission2'));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});