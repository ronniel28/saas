# Current App Status

Snapshot date: February 16, 2026

## 1. Platform and Dependencies

- Framework: Laravel 12
- PHP: ^8.2
- Authentication: Laravel Breeze (web/session) + Laravel Sanctum (API tokens)
- Authorization: Spatie Laravel Permission v6
- Frontend stack: Blade + Vite + Tailwind + Alpine

Primary references:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/composer.json`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/package.json`

## 2. Current Route Surface

### Web routes

- `/` (welcome page)
- `/dashboard` (named route: `dashboard`, auth-protected)
- `/companies` (auth-protected; super-admin only check in route closure)
- `/projects` (auth-protected)
- Profile routes (`/profile` edit/update/delete; auth-protected)
- Breeze auth routes from `routes/auth.php`

References:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/routes/web.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/routes/auth.php`

### API routes

- `GET /api/test`
- `POST /api/register` (creates company + owner + Sanctum token)
- A protected API resource group exists but is currently commented out

Reference:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/routes/api.php`

## 3. Database Schema Status

Migrations currently include:

- Core Laravel tables (`users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`)
- Tenant/business tables: `companies`, `plans`, `subscriptions`, `projects`, `tasks`
- Sanctum tokens table
- Spatie permission tables
- Multi-tenant user and role updates

Notable constraints:

- `users.company_id` exists and is nullable (for super admin/global users)
- user uniqueness is tenant-aware: `unique(company_id, email)`
- `roles.company_id` exists and index/unique key are present
- roles unique key at DB level: `unique(name, guard_name, company_id)`

References:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/database/migrations/2026_02_16_081452_add_company_id_to_users_table.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/database/migrations/2026_02_16_094440_make_company_id_nullable_in_users_table.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/database/migrations/2026_02_16_091340_add_company_id_to_roles_table.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/database/migrations/2026_02_16_094915_update_roles_unique_constraint.php`

## 4. Model Status

### User

- Traits: `HasApiTokens`, `HasFactory`, `HasRoles`, `Notifiable`
- Spatie guard name: `sanctum`
- Relationship: `company()`

Reference:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Models/User.php`

### Company

- Fillable tenant profile fields
- Relationships: `users()`, `projects()`, `subscriptions()`

Reference:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Models/Company.php`

### Project and Task

- Both use soft deletes
- Both use `BelongsToCompany` tenant trait

References:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Models/Project.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Models/Task.php`

### Plan and Subscription

- Models exist and map to migrated tables
- Logic is currently minimal

References:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Models/Plan.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Models/Subscription.php`

## 5. Multi-Tenant Behavior

Tenant scoping is implemented via trait:

- On create: auto-assign `company_id` from authenticated user if not supplied
- Global query scope: non-super-admin users are filtered by `company_id`

Reference:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/BelongsToCompany.php`

Middleware aliases:

- `tenant` -> `SetTenant`
- `subscription` -> `CheckSubscription`

Reference:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/bootstrap/app.php`

Middleware behavior:

- `SetTenant` binds `currentTenant` and blocks inactive/missing tenant
- `CheckSubscription` validates active, unexpired subscription
- `CheckSubscription` now gracefully handles missing tenant context

References:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Http/Middleware/SetTenant.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Http/Middleware/CheckSubscription.php`

## 6. RBAC Status

- Spatie roles and permissions are seeded idempotently
- Roles: `Owner`, `Admin`, `Member`
- Permissions: `manage_projects`, `manage_tasks`, `manage_users`
- Seeding uses `findOrCreate` and permission sync

Reference:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/app/Services/RoleService.php`

Note:
- App currently behaves with guard-global role names (`sanctum`) for compatibility with Spatie config (`teams` is `false`)

Reference:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/config/permission.php`

## 7. Seed Data Status

`UserSeeder` currently creates:

- `Super Admin` user (`superadmin@example.com`) with `is_super_admin = true`
- Company: `Alpha Corp`
- Company: `Beta LLC`
- Users in companies with assigned roles (`Owner`, `Admin`, `Member`)

References:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/database/seeders/DatabaseSeeder.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/database/seeders/UserSeeder.php`

## 8. UI Status

Main pages in use:

- Dashboard page
- Companies page
- Projects page

References:
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/resources/views/dashboard.blade.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/resources/views/companies/index.blade.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/resources/views/projects/index.blade.php`
- `/Volumes/PortableSSD/Development/portfolio_v2/Laravel_Projects/saas-admin/resources/views/layouts/admin.blade.php`

## 9. Testing Status

Current test outcome:

- `php artisan test` -> passing
- Result: 25 passed, 0 failed

Recent fixes that enabled this:

- Added missing `HasFactory` on `User` (factory-based tests)
- Added missing `Notifiable` on `User` (password reset notification tests)
- Secured route auth boundaries and fixed missing `Company::subscriptions()` relation

## 10. Security and Access Posture

- Sensitive web routes (`dashboard`, `companies`, `projects`, `profile`) are auth-protected
- `/companies` has super-admin gate check in route logic
- Tenant query scoping applies to `Project` and `Task` for non-super-admin users
- API self-registration endpoint remains public by design

## 11. Known Gaps / Next Work

- API resource group for tenant/subscription-protected endpoints is still commented out
- `Plan` and `Subscription` domain logic is minimal
- Sidebar includes `/users` link but no active `/users` route/controller yet
- If strict per-tenant RBAC isolation is needed inside Spatie, implement teams-based configuration end-to-end
