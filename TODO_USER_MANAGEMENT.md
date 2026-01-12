# Plan: Admin User Management Feature

## Objective
Create a user management page in the admin panel where admins can:
- View all users in the database
- Search users by name/npm
- Edit user information
- Delete users
- NO add button (view/edit/delete only)

## Implementation Status: ✅ COMPLETED

### 1. Create UserController ✅
**File**: `app/Http/Controllers/UserController.php`
- `index()` - Display all users with pagination and search by name/npm
- `edit()` - Show edit form for a user
- `update()` - Update user data (name, email, npm, role)
- `destroy()` - Delete a user

### 2. Create User Views ✅
**Directory**: `resources/views/admin/users/`

#### a. `resources/views/admin/users/index.blade.php`
- Table displaying all users with columns: No, NPM, Name, Email, Role, Actions
- Search form for name/npm
- No "Add User" button
- Edit and Delete buttons for each user
- Confirmation dialog for delete

#### b. `resources/views/admin/users/form.blade.php`
- Edit form with fields: NPM, Name, Email, Role, Password (optional)
- Similar styling to book form

### 3. Modify Routes ✅
**File**: `routes/web.php`
- Added resource route for admin users (index, edit, update, destroy only - NO create/store)

### 4. Update Sidebar ✅
**File**: `resources/views/components/sidebar.blade.php`
- Updated "Kelola Users" link to point to `route('admin.users.index')`
- Added active state condition `request()->routeIs('admin.users.*')`

## Files Created/Modified
1. **Created**: `app/Http/Controllers/UserController.php`
2. **Created**: `resources/views/admin/users/index.blade.php`
3. **Created**: `resources/views/admin/users/form.blade.php`
4. **Modified**: `routes/web.php`
5. **Modified**: `resources/views/components/sidebar.blade.php`

## Success Criteria ✅
- Admin can view all users in a paginated table
- Admin can search users by name or npm
- Admin can edit any user's information (name, email, npm, role)
- Admin can delete any user with confirmation
- No "Add User" button is present
- Design is consistent with existing admin pages

## Routes Available
- GET `/admin/users` - List all users (index)
- GET `/admin/users/{user}/edit` - Edit user form
- PUT `/admin/users/{user}` - Update user
- DELETE `/admin/users/{user}` - Delete user

## Testing
Run the application and navigate to `/admin/users` to test the functionality.

