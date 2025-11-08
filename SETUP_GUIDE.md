# Gym SaaS Platform 🏋️

Platform SaaS manajemen membership gym yang dibangun dengan **Laravel 12**, **Filament 3.0**, **Spatie Permission**, dan **Midtrans Payment Gateway**.

## 🚀 Fitur Utama

### Backend (Admin Panel)

-   **Multi-Role Authentication** (Super Admin, Gym Owner, Member)
-   **Gym Management** - Kelola data gym dengan mudah
-   **Plan Management** - Buat dan kelola paket membership
-   **Member Management** - Lihat dan kelola data member
-   **Transaction Management** - Monitor semua transaksi
-   **Subscription Management** - Kelola subscription aktif
-   **Role-Based Access Control** - Data isolation berdasarkan role

### Frontend (Customer)

-   **Homepage** - Tampilan gym unggulan
-   **Gym Listing** - Cari gym dengan filter kota dan pencarian
-   **Gym Detail** - Lihat detail gym dan paket membership
-   **Checkout System** - Form pendaftaran member
-   **Payment Integration** - Integrasi Midtrans Snap
-   **Thank You Page** - Konfirmasi pembayaran dan membership

### Payment Gateway

-   **Midtrans Integration** - Multiple payment methods
-   **Auto Subscription Activation** - Otomatis aktif setelah pembayaran
-   **Payment Callback** - Handle notification dari Midtrans
-   **Transaction Status Tracking** - Monitor status pembayaran real-time

## 🛠️ Tech Stack

-   **Framework**: Laravel 12 (PHP 8.2+)
-   **Admin Panel**: Filament 3.0
-   **Authorization**: Spatie Laravel Permission 6.23
-   **Payment Gateway**: Midtrans PHP SDK
-   **Database**: MySQL
-   **Frontend**: Blade Templates + Tailwind CSS
-   **Icons**: Font Awesome 6.0

## 📋 Prerequisites

-   PHP >= 8.2
-   Composer
-   MySQL >= 5.7 atau MariaDB >= 10.3
-   Node.js & NPM (optional, untuk asset compilation)

## 📥 Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd gym-saas-app
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gym_saas
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Midtrans Configuration

Daftar di [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/) dan dapatkan credentials.

Edit `.env`:

```env
MIDTRANS_SERVER_KEY=your_server_key_here
MIDTRANS_CLIENT_KEY=your_client_key_here
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### 6. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

### 7. Start Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://127.0.0.1:8000`

## 👤 Default Login Credentials

### Super Admin

-   URL: `http://127.0.0.1:8000/admin`
-   Email: `admin@gym-saas.com`
-   Password: `password`

### Gym Owner (Example)

-   Email: `owner1@gym-saas.com`
-   Password: `password`

## 🗂️ Database Schema

### Tables

-   **users** - User accounts (Super Admin, Gym Owner)
-   **gyms** - Gym locations
-   **plans** - Membership plans
-   **members** - Customer/member accounts
-   **subscriptions** - Active memberships
-   **transactions** - Payment records

### Relationships

```
User (1) -> (N) Gym
Gym (1) -> (N) Plan
Member (1) -> (N) Transaction
Transaction (1) -> (1) Subscription
Plan (1) -> (N) Transaction
```

## 🔐 Roles & Permissions

### Super Admin

-   Akses penuh ke semua data
-   Dapat melihat dan mengelola semua gym, plans, members, transactions

### Gym Owner

-   Hanya dapat melihat dan mengelola gym miliknya sendiri
-   Dapat melihat plans dari gym mereka
-   Dapat melihat members yang subscribe ke gym mereka
-   Dapat melihat transactions terkait gym mereka

### Member (Future)

-   Akses ke member area
-   Lihat subscription status
-   Manage profile

## 🌐 Routes

### Frontend

-   `/` - Homepage
-   `/gyms` - Gym listing dengan search & filter
-   `/gyms/{slug}` - Gym detail
-   `/checkout/{plan}` - Checkout form
-   `/thank-you` - Thank you page

### Backend

-   `/admin` - Filament admin panel

### API

-   `POST /midtrans/callback` - Midtrans payment notification

## 💳 Payment Flow

1. **Customer memilih gym dan plan**
2. **Mengisi form checkout** (data member)
3. **Sistem membuat transaction** dengan status "pending"
4. **Redirect ke Midtrans Snap** untuk pembayaran
5. **Customer memilih metode pembayaran** (Bank Transfer, E-Wallet, Credit Card, dll)
6. **Midtrans mengirim callback** ke sistem
7. **Sistem update transaction status** dan create subscription jika "paid"
8. **Customer diarahkan ke thank you page** dengan detail membership

## 🧪 Testing

### Test Midtrans Payment (Sandbox)

#### Credit Card (Success)

-   Card Number: `4811 1111 1111 1114`
-   CVV: `123`
-   Exp Date: `01/25`
-   OTP/3DS: `112233`

#### Credit Card (Failed)

-   Card Number: `4911 1111 1111 1113`
-   CVV: `123`
-   Exp Date: `01/25`

#### Other Payment Methods

-   Semua metode di sandbox akan auto-approve
-   Gunakan nomor test yang disediakan Midtrans

## 📊 Factory & Seeder

Sistem sudah include factory dan seeder untuk testing:

```bash
php artisan migrate:fresh --seed
```

Data yang di-generate:

-   1 Super Admin
-   3 Gym Owners dengan 3 Gyms
-   12 Plans (4 per gym)
-   20 Members
-   Random Transactions & Subscriptions

## 🔧 Development

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Generate IDE Helper (Optional)

```bash
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models
```

## 📝 TODO / Future Enhancements

-   [ ] Member login area
-   [ ] Email notifications (transaction confirmation)
-   [ ] QR Code untuk membership card
-   [ ] Check-in system
-   [ ] Attendance tracking
-   [ ] Member dashboard
-   [ ] Renewal reminder notifications
-   [ ] Admin dashboard dengan statistics
-   [ ] Export reports (PDF/Excel)
-   [ ] Multi-language support

## 🐛 Troubleshooting

### Error: "SQLSTATE[HY000] [2002] Connection refused"

-   Pastikan MySQL service sudah running
-   Cek credentials database di `.env`

### Error: "Class 'Midtrans\Config' not found"

-   Jalankan: `composer dump-autoload`
-   Pastikan `midtrans/midtrans-php` sudah terinstall

### Midtrans Snap tidak muncul

-   Cek apakah `MIDTRANS_CLIENT_KEY` sudah benar
-   Buka browser console untuk lihat error
-   Pastikan menggunakan Sandbox credentials untuk testing

### Transaction stuck di "pending"

-   Cek apakah Midtrans callback URL sudah diset
-   Pastikan route `midtrans/callback` tidak ter-block CSRF
-   Lihat log di `storage/logs/laravel.log`

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Credits

Tutorial by [BuildWithAngga](https://buildwithangga.com)

-   Laravel 12 + Filament + Spatie + Midtrans Tutorial
-   Building SaaS Gym Membership Platform
