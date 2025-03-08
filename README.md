# 🌟 E-Commerce API

## 📌 Overview
This project is a feature-rich **E-Commerce Application** built with Laravel. It supports **user authentication**, **product & category management**, **shopping cart**, **orders**, **OTP verification**, and **password recovery**.

---

## 🚀 Features
✅ **User Authentication** (Register, Login, Logout, Profile) via Laravel Sanctum  
✅ **Product & Category Management**  
✅ **Shopping Cart** (Add to Cart, Remove from Cart)  
✅ **Order Management** (Create & Remove Orders)  
✅ **Password Management** (Forgot Password, Reset Password, Change Password)  
✅ **Database Seeding & Factories**  

---

## 🛠 Installation & Setup
### Step 1️⃣: Clone the Repository
```bash
 git clone https://github.com/MomenAnoh/E-commerc-app.git
 cd E-commerc-app
```

### Step 2️⃣: Install Dependencies
```bash
 composer install
 npm install
```

### Step 3️⃣: Setup Environment
```bash
 cp .env.example .env
```
Edit `.env` file and configure **Database & Application** settings.

### Step 4️⃣: Generate Application Key
```bash
 php artisan key:generate
```

### Step 5️⃣: Run Migrations & Seed Database
```bash
 php artisan migrate --seed
```

### Step 6️⃣: Start Development Server
```bash
 php artisan serve
```
---

## 📡 API Endpoints
### 🔐 Authentication
🔹 **Register:** `POST /api/register`  
🔹 **Login:** `POST /api/login`  
🔹 **Logout:** `POST /api/logout` (🔒 Requires Authentication)  
🔹 **User Profile:** `GET /api/profile` (🔒 Requires Authentication)  

### 📂 Categories
🔹 **Get All Categories:** `GET /api/all-categories`  
🔹 **Get Category by ID:** `GET /api/one-categore/{id}`  
🔹 **Create Category:** `POST /api/store-categories` (🔒 Requires Authentication)  

### 📦 Products
🔹 **Get All Products:** `GET /api/all-products`  
🔹 **Get Product by ID:** `GET /api/one-product/{id}`  
🔹 **Create Product:** `POST /api/store-product` (🔒 Requires Authentication)  
🔹 **Get Products by Category:** `GET /api/products-of-categore`  

### 🛒 Shopping Cart
🔹 **Add to Cart:** `POST /api/addToCart` (🔒 Requires Authentication)  
🔹 **Remove from Cart:** `DELETE /api/delete-cart-product/{product_id}` (🔒 Requires Authentication)  

### 📦 Orders
🔹 **Create Order:** `POST /api/create-order` (🔒 Requires Authentication)  
🔹 **Remove Order:** `DELETE /api/remove-order/{order_id}` (🔒 Requires Authentication)  

### 🔑 Password Management
🔹 **Forgot Password:** `POST /api/forgot-password`  
🔹 **Verify OTP Code:** `POST /api/verify-reset-code`  
🔹 **Reset Password:** `POST /api/reset-password`  
🔹 **Change Password:** `POST /api/change-password` (🔒 Requires Authentication)  

---

## 🏗 Technologies Used
🟢 Laravel  
🟢 Laravel Sanctum (Authentication)  
🟢 MySQL (Database)  
🟢 PHP 8+  

---

## ✨ Author
**👨‍💻 Momen Ahmed**  
🚀 Happy Coding! 🔥

