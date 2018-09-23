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

//Roles
Breadcrumbs::register('admin.roles.index', function( $crumbs){
    $crumbs->parent('home');
    $crumbs->push('Roles', route('admin.roles.index'));
});

Breadcrumbs::register('admin.roles.create', function( $crumbs){
    $crumbs->parent('admin.roles.index');
    $crumbs->push('Create roles', route('admin.roles.create'));
});

Breadcrumbs::register('admin.roles.edit', function( $crumbs, $id){
    $crumbs->parent('admin.roles.index');
    $crumbs->push('Edit roles', route('admin.roles.edit',$id));
});

Breadcrumbs::register('admin.roles.show', function( $crumbs, $id){
    $crumbs->parent('admin.roles.index');
    $crumbs->push('Show roles', route('admin.roles.show',$id));
});

// Regions

Breadcrumbs::register('admin.regions.index', function ($crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Regions', route('admin.regions.index'));
});

Breadcrumbs::register('admin.regions.create', function ($crumbs) {
    $crumbs->parent('admin.regions.index');
    $crumbs->push('Create', route('admin.regions.create'));
});

Breadcrumbs::register('admin.regions.show', function ($crumbs, $region) {
    $crumbs->parent('admin.regions.index');
    $crumbs->push($region->name, route('admin.regions.show', $region));
});

Breadcrumbs::register('admin.regions.edit', function ($crumbs, $region) {
    $crumbs->parent('admin.regions.show', $region);
    $crumbs->push('Edit', route('admin.regions.edit', $region));
});