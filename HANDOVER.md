# WargaConnect Handover Document

## 1. Credentials
**Administrator**
- **URL**: https://rt35.simpleakunting.my.id
- **Email**: `admin@simpleakunting.my.id`
- **Password**: `WargaConnect2025!`

**Resident (Dummy Account)**
- **Email**: `warga1@rt35.warga`
- **Password**: `password`

## 2. Deployment Status
- **Server**: Arenhost (cPanel/Laravel)
- **Domain**: `rt35.simpleakunting.my.id`
- **Database**: `simplea2_wargaconnect` (Verified)
- **Codebase**: GitHub `solusigroup/WargaConnect` (Branch: `main`)

## 3. Key Fixes Implemented
- **Dashboard 500 Error**: Resolved by fixing Blade template syntax (removed stray `@endif`).
- **Admin Verification Link**: Added a dedicated "Admin Panel" to the Dashboard (visible only to Admins) to access the Resident Verification page.
- **Middleware Lockout**: Updated `DatabaseSeeder` to ensure the default Admin and dummy Residents are created with `status = verified` to prevent immediate lockout.
- **Payment Verification**: Created `php artisan app:simulate-payment` to verify the full billing and payment flow (Bill -> QRIS Pending -> Success).

## 4. Next Steps for Admin
1. **Login** to the Dashboard.
2. Click **"Verifikasi"** (Shield Icon) in the Admin Panel.
3. Approve any pending new resident registrations.
4. Use **Master Iuran** to set up real contribution categories (Keamanan, Sampah, etc.).

## 5. Maintenance
- To update the site:
  ```bash
  cd /public_html
  git pull origin main
  php artisan migrate --force
  php artisan optimize
  ```
