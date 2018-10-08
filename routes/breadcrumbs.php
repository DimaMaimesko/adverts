<?php
use App\Http\Router\AdvertsPath;
use App\Models\Adverts\Advert;

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

//ADMIN Adverts

Breadcrumbs::register('admin.home', function ( $crumbs) {
    $crumbs->push('Admin', route('admin.home'));
});

Breadcrumbs::register('admin.adverts.index', function ($crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Adverts', route('admin.adverts.index'));
});
Breadcrumbs::register('admin.adverts.show', function ($crumbs, $advert) {
    $crumbs->parent('admin.adverts.index');
    $crumbs->push('Show', route('admin.adverts.show', $advert));
});

// Users

Breadcrumbs::register('admin.users.index', function ($crumbs) {
    $crumbs->parent('admin.home');
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
    $crumbs->parent('admin.home');
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
    $crumbs->parent('admin.home');
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
    $crumbs->parent('admin.home');
    $crumbs->push('Regions', route('admin.regions.index'));
});

Breadcrumbs::register('admin.regions.create', function ($crumbs) {
    $crumbs->parent('admin.regions.index');
    $crumbs->push('Create', route('admin.regions.create'));
});

Breadcrumbs::register('admin.regions.show', function ($crumbs, $region) {
    if ($parent = $region->parent){
        $crumbs->parent('admin.regions.show',$parent);
    }else{
        $crumbs->parent('admin.regions.index');
    }
    $crumbs->push($region->name, route('admin.regions.show', $region));
});

Breadcrumbs::register('admin.regions.edit', function ($crumbs, $region) {
    $crumbs->parent('admin.regions.show', $region);
    $crumbs->push('Edit', route('admin.regions.edit', $region));
});

// Categories

Breadcrumbs::register('admin.categories.index', function ($crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Categories', route('admin.categories.index'));
});

Breadcrumbs::register('admin.categories.create', function ($crumbs) {
    $crumbs->parent('admin.categories.index');
    $crumbs->push('Create', route('admin.categories.create'));
});

Breadcrumbs::register('admin.categories.show', function ($crumbs, $category) {
    if ($parent = $category->parent){
        $crumbs->parent('admin.categories.show',$parent);
    }else{
        $crumbs->parent('admin.categories.index');
    }
    $crumbs->push($category->name, route('admin.categories.show', $category));
});

Breadcrumbs::register('admin.categories.edit', function ($crumbs, $category) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push('Edit', route('admin.categories.edit', $category));
});

// Advert Category Attributes

Breadcrumbs::register('admin.categories.attributes.create', function ($crumbs, $category) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push('Create', route('admin.categories.attributes.create', $category));
});

Breadcrumbs::register('admin.categories.attributes.show', function ( $crumbs,  $category,  $attribute) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push($attribute->name, route('admin.categories.attributes.show', [$category, $attribute]));
});

Breadcrumbs::register('admin.categories.attributes.edit', function ( $crumbs,  $category,  $attribute) {
    $crumbs->parent('admin.categories.attributes.show', $category, $attribute);
    $crumbs->push('Edit', route('admin.categories.attributes.edit', [$category, $attribute]));
});

// Cabinet
Breadcrumbs::register('cabinet.home', function ( $crumbs) {
    $crumbs->push('Cabinet', route('cabinet.home'));
});

Breadcrumbs::register('cabinet.profile.home', function ( $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Profile', route('cabinet.profile.home'));
});

Breadcrumbs::register('cabinet.profile.edit', function ( $crumbs) {
    $crumbs->parent('cabinet.profile.home');
    $crumbs->push('Edit', route('cabinet.profile.edit'));
});

Breadcrumbs::register('cabinet.profile.phone', function ( $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Phone', route('cabinet.profile.phone'));
});

Breadcrumbs::register('cabinet.adverts.home', function ( $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Adverts', route('cabinet.adverts.home'));
});

Breadcrumbs::register('cabinet.adverts.edit', function ( $crumbs, $advert) {
    $crumbs->parent('cabinet.adverts.home');
    $crumbs->push('Edit', route('cabinet.adverts.edit',  $advert));
});

// Adverts

Breadcrumbs::register('adverts.inner_region', function ( $crumbs, AdvertsPath $path) {
    if ($path->region && $parent = $path->region->parent) {
        $crumbs->parent('adverts.inner_region', $path->withRegion($parent));
    } else {
        $crumbs->parent('home');
        $crumbs->push('Adverts', route('adverts.index'));
    }
    if ($path->region) {
        $crumbs->push($path->region->name, route('adverts.index', $path));
    }
});

Breadcrumbs::register('adverts.inner_category', function ( $crumbs, AdvertsPath $path, AdvertsPath $orig) {
    if ($path->category && $parent = $path->category->parent) {
        $crumbs->parent('adverts.inner_category', $path->withCategory($parent), $orig);
    } else {
        $crumbs->parent('adverts.inner_region', $orig);
    }
    if ($path->category) {
        $crumbs->push($path->category->name, route('adverts.index', $path));
    }
});

Breadcrumbs::register('adverts.index', function ( $crumbs, AdvertsPath $path = null) {
    $path = $path ?: adverts_path(null, null);
    $crumbs->parent('adverts.inner_category', $path, $path);
});

Breadcrumbs::register('adverts.show', function ( $crumbs, Advert $advert) {
    $crumbs->parent('adverts.index', adverts_path($advert->region, $advert->category));
    $crumbs->push($advert->title, route('adverts.show', $advert));
});