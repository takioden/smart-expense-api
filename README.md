# Smart Expense API

## 📌 Deskripsi
**Smart Expense API** adalah RESTful API untuk mengelola keuangan pribadi, termasuk pencatatan transaksi, kategori, dan **transaksi berulang (Recurring Transaction)**.

Salah satu fitur utama pada API ini adalah **sistem recurring transaction** yang dijalankan secara otomatis menggunakan **Command Pattern** dan **Laravel Scheduler**.

---

## 🚀 Fitur Utama
- CRUD transaksi pengeluaran & pemasukan
- Kategori transaksi
- Transaksi berulang (daily / weekly / monthly)
- Generate transaksi otomatis dari recurring
- Testing generate recurring via endpoint
- Arsitektur OOP & Design Pattern

---

## 🧩 Arsitektur & Design Pattern

### Pola yang Digunakan
- **Command Pattern** → menjalankan proses generate recurring
- **Service Layer** → logika bisnis
- **Repository Pattern** → akses data
- **Adapter Pattern** → transform data recurring ke transaksi
- **MVC (Laravel)**

---
