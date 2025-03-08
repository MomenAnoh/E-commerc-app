# 🛒 E-Commerce App

## 📌 Introduction
E-Commerce App is a fully functional online store built with **Laravel**.  
It includes **product and category management, order handling, OTP authentication, and password management**.  
The authentication system is powered by **Laravel Sanctum** for secure API authentication.

---

## 🚀 Features
✅ **Authentication using Laravel Sanctum**  
✅ **Product & Category Management (Create, Update, Delete, View)**  
✅ **Order Management (Create, Update, Delete Orders)**  
✅ **User Verification via OTP**  
✅ **Password Reset, Forgot Password, and Change Password**  
✅ **Seeder & Factory for Test Data**  

---

## 🛠️ Technologies Used
- **Laravel** (PHP Framework)  
- **MySQL** (Database)  
- **Laravel Sanctum** (API Authentication)  
- **JWT** (Token-based Authentication)  
- **Seeder & Factory** (For Dummy Data)  
- **Postman** (For API Testing)  

---

## 📂 Project Structure
```
/app
   /Http
      /Controllers  # Handles requests
      /Requests     # Validates input data
      /Resources    # Transforms response data
/config            # Configuration files
/database
   /factories      # Generates test data
   /migrations     # Handles database schema
   /seeders        # Populates database with test data
/routes           # Defines API and Web routes
/storage          # Stores uploaded files and images
```

---

## 🔧 Installation & Setup
Follow these steps to set up and run the project on your local machine:

1. **Clone the repository**  
   ```sh
   git clone https://github.com/MomenAnoh/E-commerce-app.git
   cd E-commerce-app
   ```

2. **Install dependencies**  
   ```sh
   composer install
   ```

3. **Copy the environment file**  
   ```sh
   cp .env.example .env
   ```

4. **Generate application key**  
   ```sh
   php artisan key:generate
   ```

5. **Set up the database**  
   - Update `.env` file with your database credentials.  
   - Run migrations and seeders:  
     ```sh
     php artisan migrate --seed
     ```

6. **Run the development server**  
   ```sh
   php artisan serve
   ```

7. **API Testing (Optional)**  
   Use **Postman** or any API testing tool to test the endpoints.

---

## 📌 API Endpoints
| Method | Endpoint             | Description                 | Authentication |
|--------|----------------------|-----------------------------|---------------|
| POST   | `/api/register`      | User registration           | ❌ No         |
| POST   | `/api/login`         | User login                  | ❌ No         |
| POST   | `/api/logout`        | Logout user                 | ✅ Yes        |
| GET    | `/api/products`      | Fetch all products          | ❌ No         |
| GET    | `/api/categories`    | Fetch all categories        | ❌ No         |
| POST   | `/api/orders`        | Create a new order          | ✅ Yes        |
| GET    | `/api/orders`        | Get user orders             | ✅ Yes        |
| POST   | `/api/password/reset`| Reset password via email    | ❌ No         |

---

## 📌 Author
Developed by **Momen Ahmed**  
GitHub: [MomenAnoh](https://github.com/MomenAnoh)

---

