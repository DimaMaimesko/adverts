<?php

Breadcrumbs::register('home', function ( $crumbs) {
    $crumbs->push('Home', route('home'));
});

Breadcrumbs::register('login', function ($crumbs) {
$crumbs->parent('home');
    $crumbs->push('Login', route('login'));
});

Breadcrumbs::register('register', function ($crumbs) {
$crumbs->parent('home');
    $crumbs->push('Register', route('register'));
});

Breadcrumbs::register('verify', function ($crumbs, $token) {
$crumbs->parent('home');
    $crumbs->push('Verify', route('verify',['token' => $token]));
});

Breadcrumbs::register('password.request', function ($crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Reset Password', route('password.request'));
});

Breadcrumbs::register('password.reset', function ($crumbs) {
    $crumbs->parent('password.request');
    $crumbs->push('Change', route('password.reset'));
});
// Users

Breadcrumbs::register('admin.users.index', function ($crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Users', route('admin.users.index'));
});

Breadcrumbs::register('admin.users.create', function ($crumbs) {
    $crumbs->parent('admin.users.index');
    $crumbs->push('Create', route('admin.users.create'));
});

Breadcrumbs::register('admin.users.show', function ($crumbs, $user) {
    $crumbs->parent('admin.users.index');
    $crumbs->push($user->name, route('admin.users.show', $user));
});

Breadcrumbs::register('admin.users.edit', function ($crumbs, $user) {
    $crumbs->parent('admin.users.show', $user);
    $crumbs->push('Edit', route('admin.users.edit', $user));
});
//Permissions
Breadcrumbs::register('admin.permissions.index', function( $crumbs){
    $crumbs->parent('home');
    $crumbs->push('Permissions', route('admin.permissions.index'));
});

Breadcrumbs::register('admin.permissions.create', function( $crumbs){
    $crumbs->parent('admin.permissions.index');
    $crumbs->push('Create permission', route('admin.permissions.create'));
});

Breadcrumbs::register('admin.permissions.edit', function( $crumbs, $id){
    $crumbs->parent('admin.permissions.index');
    $crumbs->push('Edit permissions', route('admin.permissions.edit',$id));
});

Breadcrumbs::register('admin.permissions.show', function( $crumbs, $id){
    $crumbs->parent('admin.permissions.index');
    $crumbs->push('Show permissions', route('admin.permissions.show',$id));
});