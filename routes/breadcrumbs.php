<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Brand;
use App\Models\Company\Company;
use App\Models\FiscalYear;
use App\Models\Item\Item;
use App\Models\PaymentMethod;
use App\Models\Student;
use App\Models\Subscription\SubscriptionPlan;
use App\Models\Subscription\SubscriptionPlanFeature;
use App\Models\TenantPermission;
use App\Models\TenantRole;
use App\Models\User;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Spatie\Permission\Models\Role;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Permission;

// Dashboard as Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(__('pageTitle.custom.home'), route('dashboard'));
});

// Settings
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.configuration.parentInfo'), route('configurations.details'));
});

// Settings - Basic Info
Breadcrumbs::for('settingsBasicInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.basicInfo'), route('configurations.basicInfo'));
});

// Settings - Additional Info
Breadcrumbs::for('settingsAdditionalInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.additionalInfo'), route('configurations.additionalInfo'));;
});

// Settings - Contact Info
Breadcrumbs::for('settingsContactInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.contactInfo'), route('configurations.contactInfo'));
});

// Settings - Global Info
Breadcrumbs::for('settingsGlobalInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.globalInfo'), route('configurations.globalInfo'));
});

// Settings - SMS Service
Breadcrumbs::for('settingsSmsService', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.smsService'), route('configurations.smsService'));
});

// User Management Menu
Breadcrumbs::for('userManagement', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.user.parentInfo'));
});

// Permissions
Breadcrumbs::for('permissions', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.permission.childInfo.index'), route('permissions.index'));
});

// Add Permission
Breadcrumbs::for('addPermission', function (BreadcrumbTrail $trail) {
    $trail->parent('permissions');
    $trail->push(__('breadcrumb.custom.permission.childInfo.create'), route('permissions.create'));
});

// Edit Permission
Breadcrumbs::for('editPermission', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->parent('permissions');
    $trail->push(__('breadcrumb.custom.permission.childInfo.edit'), route('permissions.edit', $permission));
});

// Roles
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.role.childInfo.index'), route('roles.index'));
});

// Add Roles
Breadcrumbs::for('addRole', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.create'), route('roles.create'));
});

// Edit Roles
Breadcrumbs::for('editRole', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.edit'), route('roles.edit', $role));
});

// Roles Details
Breadcrumbs::for('roleDetails', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.details'), route('roles.show', $role));
});

// User List
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.user.childInfo.index'), route('users.index'));
});

// Add User
Breadcrumbs::for('addUser', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.create'), route('users.create'));
});

// Edit User
Breadcrumbs::for('editUser', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.edit'), route('users.edit', $user));
});

// User Details
Breadcrumbs::for('userDetails', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.details'), route('users.show', $user));
});

// My Profile
Breadcrumbs::for('myProfile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.user.childInfo.profile'), route('profile.edit'));
});

//students list
Breadcrumbs::for('students', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Student Management', route('students.index'));
});

//students list
Breadcrumbs::for('studentList', function (BreadcrumbTrail $trail) {
    $trail->parent('students');
    $trail->push('Students List', route('students.index'));
});

//students list
Breadcrumbs::for('createStudent', function (BreadcrumbTrail $trail) {
    $trail->parent('students');
    $trail->push('Add', route('students.create'));
});

//students list
Breadcrumbs::for('editStudent', function (BreadcrumbTrail $trail, Student $student) {
    $trail->parent('students');
    $trail->push('Edit', route('students.edit', $student));
});
