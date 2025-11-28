# Database Migration Cleanup Instructions

## Files to DELETE (Empty/Duplicate Migrations):

1. `2025_09_28_131322_add_patroller_fields_to_users_table.php` - EMPTY
2. `2025_09_28_131607_add_patroller_fields_to_users_table.php` - EMPTY  
3. `2025_10_03_023435_create_verification_documents_table.php` - DUPLICATE
4. `2025_10_03_023558_create_verification_documents_table.php` - DUPLICATE
5. `2025_10_03_023603_add_verification_columns_to_users_table.php` - EMPTY

## Files to KEEP (Core Migrations):

1. `0001_01_01_000000_create_users_table.php` - Base users table
2. `0001_01_01_000001_create_cache_table.php` - Laravel cache
3. `0001_01_01_000002_create_jobs_table.php` - Laravel jobs
4. `2024_01_28_000001_create_ecological_submissions_table.php` - Ecological submissions
5. `2024_01_28_000002_add_admin_fields_to_users_table.php` - Admin fields
6. `2024_09_20_000000_add_profile_picture_to_users_table.php` - Profile pictures
7. `2024_10_03_103422_create_verification_documents_table.php` - Verification docs (KEEP FIRST ONE)
8. `2024_10_03_103423_add_verification_columns_to_users_table.php` - Verification columns
9. `2024_10_13_001500_create_patrol_reports_table.php` - NEW Patrol reports
10. `2025_01_18_000001_add_username_to_users_table.php` - Username field
11. `2025_01_19_000001_add_role_to_users_table.php` - Role field
12. `2025_09_20_153746_create_game_activities_table.php` - Game activities
13. `2025_09_26_113801_drop_patrol_reports_tables.php` - Drop old patrol reports
14. `2025_09_28_000001_add_patroller_fields_to_users_table.php` - Patroller fields (KEEP FIRST ONE)
15. `2025_09_28_140000_create_patrollers_table.php` - Patrollers table
16. `2025_09_29_000000_remove_patrol_fields_and_add_created_by.php` - Cleanup fields

## Recommended Action:
Delete the empty/duplicate files listed above, then run `php artisan migrate`
