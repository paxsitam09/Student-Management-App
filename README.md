# Laravel + Vue/Vite Project

## **Project Overview**
This is a Laravel 10 application integrated with Vue 3 and Vite, designed to showcase my technical skills and meet the requirements outlined in the coding test.

---

## **Features Implemented**

### **1. Laravel 10 Application**
- The project is built using the latest version of Laravel (10).

### **2. Role and Permission System**
- Implemented a role-based access control system with the following roles:
  - **Admin**:
    - Can add, edit, delete student records.
    - Can view the list of students.
  - **Supervisor**:
    - Can add and edit student records.
    - Can view the list of students.
    - Cannot delete student records.

### **3. CRUD Functionality**
- **Students Table**:
  - Fields: `id`, `name`, `grade`, `phno`, `address`, `date of birth`.
- Implemented full CRUD operations:
  - Create, Read, Update, and Delete functionality for managing student records.

### **4. Export & Import Functionality**
- **Excel Import and Export**:
  - Import student data using `.csv` files.
  - Export student data into `.csv` or `.xlsx` files.

---

## **Tech Stack**

### **Backend**
- Laravel 10
- PHP 8.1
- MySQL
- Role and Permission Library (Spatie Permission)

### **Frontend**
- Vue 3
- Vite
- Tailwind CSS (optional: to style forms and tables)
- Pinia
---

## **Setup Instructions**

### **Prerequisites**
1. PHP 8.1+
2. Composer
3. Node.js (for Vite setup)
4. MySQL database

### **Backend Setup**
1. Clone the repository:
   ```bash
   git clone https://github.com/paxsitam09/Student-Management-App.git
   cd student-manage-backend
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Configure `.env` file:
   - Set up the database connection and other environment variables.
4. Run migrations and seed roles:
   ```bash
   php artisan migrate --seed
   ```
5. Start the Laravel server:
   ```bash
   php artisan serve
   ```

### **Frontend Setup**
1. Navigate to the frontend directory:
   ```bash
   cd student-manage-frontend
   ```
2. Install dependencies:
   ```bash
   npm install
   ```
3. Start the development server:
   ```bash
   npm run dev
   ```

---
