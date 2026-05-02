# UKK SPP Payment System

Web-based school tuition payment management system developed as an individual competency test project (**Uji Kompetensi Keahlian / UKK**).  
This application helps manage student tuition payment transactions, payment history, and receipt generation efficiently.

## 📌 Project Information

- **Project Type:** Uji Kompetensi Keahlian (UKK)
- **Development:** Individual Project
- **Purpose:** School tuition payment management

## 📌 Features

### Petugas
- Transaksi Pembayaran SPP
- History Pembayaran
- Cetak PDF Kuitansi Pembayaran
- Cetak Kartu SPP

### Siswa
- History Pembayaran
- Ringkasan Pembayaran
- Data Siswa
- Detail Pembayaran Siswa

## 🛠️ Tech Stack

- **Framework:** Laravel
- **Authentication:** Laravel Breeze
- **Database:** MySQL
- **Frontend:** Blade Template
- **Styling:** Tailwind CSS

## 📂 Project Structure

```bash
UKK-SPP/
│
├── app/
├── database/
├── public/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── storage/
└── artisan
```

## ⚙️ Installation

### 1. Clone Repository
```bash
git clone https://github.com/your-username/ukk-spp.git
```

### 2. Move to Project Directory
```bash
cd ukk-spp
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Setup Environment
Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Configure Database
Edit `.env`

```env
DB_DATABASE=db_spp
DB_USERNAME=root
DB_PASSWORD=
```

Run migration:

```bash
php artisan migrate
```

### 6. Run Application
```bash
php artisan serve
npm run dev
```

Open browser:

```bash
http://127.0.0.1:8000
```

## 👥 User Roles

| Role | Access |
|---|---|
| Petugas | Payment transaction management |
| Siswa | Personal payment information |

## 📊 Workflow

1. Petugas processes student tuition payments.
2. Payment data is stored automatically into payment history.
3. Petugas can generate PDF receipts and student SPP cards.
4. Students can access their payment history and payment summary.

## 📄 PDF Features

- Payment Receipt PDF
- Student SPP Card PDF

## Demo Account

### Petugas
```bash
Username: petugas123
Password: petugas312
```

### Siswa
```bash
Username: siswa123
Password: siswa321
```

## 📸 Screenshots

```md
![Login](public/images/login.png)
![Dashboard](public/images/dashboard.png)
```

## 🚀 Future Improvements

- Payment status notification
- Export Excel reports
- Online payment gateway integration

## 👨‍💻 Author

**Salomo Halomoan**

- GitHub: https://github.com/SalomoOn7
