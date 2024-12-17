# E-Commerce Project Setup

This guide will walk you through the steps to set up the E-Commerce project on your local development environment.

## Prerequisites

- **PHP Version:** PHP 8.1.25 (cli) (built: Oct 25 2023 08:06:57) (ZTS Visual C++ 2019 x64)  
  > **Note:** Ensure you have the correct version of PHP installed on your system. You can check your PHP version using the following command:
  ```bash
  php -v
  ```

- **Composer:** Latest version installed.  
  > **Note:** If Composer is not installed, [download it from here](https://getcomposer.org/).

- **Node.js & npm:** Latest version installed.  
  > **Note:** If npm is not installed, [download it from here](https://nodejs.org/).

- **MySQL/MariaDB:** Ensure MySQL or MariaDB is running to create a database.

---

## Step 1: Clone the Project Repository

1. Clone the repository from GitHub (replace `your-repo-url` with the actual URL):
   ```bash
   git clone your-repo-url
   ```
2. Navigate into the project directory:
   ```bash
   cd your-project-directory
   ```

---

## Step 2: Set Up the Environment File

1. Copy the `.env.example` file to a new `.env` file:
   ```bash
   cp .env.example .env
   ```
2. Open the `.env` file and configure the following settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecommerce
   DB_USERNAME=root
   DB_PASSWORD=your_database_password
   ```
   > **Note:** Replace `your_database_password` with your actual MySQL root password or the password for the specific database user you are using.

---

## Step 3: Create the Database

1. Open your MySQL client or use a GUI tool like **phpMyAdmin** or **MySQL Workbench**.
2. Create a new database with the name **ecommerce**:
   ```sql
   CREATE DATABASE ecommerce;
   ```

---

## Step 4: Install Dependencies

1. Run the following command to install PHP dependencies via Composer:
   ```bash
   composer update
   ```
2. Next, install the Node.js dependencies using npm:
   ```bash
   npm install
   ```

---

## Step 5: Run Database Migrations

1. Run the following Artisan command to create the database tables:
   ```bash
   php artisan migrate
   ```
   > **Note:** Ensure your MySQL service is running before running this command.

---

## Step 6: Start the Development Server

1. Run the following command to start the development server:
   ```bash
   php artisan serve
   ```
2. You should see output similar to:
   ```
   Starting Laravel development server: http://127.0.0.1:8000
   
   [Wed Dec 13 14:32:40 2024] PHP 8.1.25 Development Server (http://127.0.0.1:8000) started
   ```
3. Open your browser and navigate to: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Additional Commands

Here are some other useful Artisan commands you may need:

- **Run database seeders** (populate the database with initial data):
  ```bash
  php artisan db:seed
  ```

- **Clear application cache**:
  ```bash
  php artisan cache:clear
  ```

- **Clear route cache**:
  ```bash
  php artisan route:clear
  ```

- **Clear config cache**:
  ```bash
  php artisan config:clear
  ```

- **Clear view cache**:
  ```bash
  php artisan view:clear
  ```

---

## API Endpoints

**1. Create Product**

- **Endpoint:** `POST http://127.0.0.1:8000/api/products`
- **Request Body (JSON):**
  ```json
  {
    "name": "add new product",
    "description": "new description",
    "price": "22",
    "quantity": "30"
  }
  ```

**2. Get All Products**

- **Endpoint:** `GET http://127.0.0.1:8000/api/products`

**3. Get Single Product**

- **Endpoint:** `GET http://127.0.0.1:8000/api/products/{id}`

**4. Update Product**

- **Endpoint:** `PUT http://127.0.0.1:8000/api/products/{id}`
- **Request Body (JSON):**
  ```json
  {
    "name": "updated product name",
    "description": "updated description",
    "price": "25",
    "quantity": "40"
  }
  ```

**5. Delete Product**

- **Endpoint:** `DELETE http://127.0.0.1:8000/api/products/{id}`

---

## Troubleshooting

### Common Issues

**1. Missing PHP extensions:**  
If you encounter errors related to missing PHP extensions (like `openssl`, `curl`, or `fileinfo`), ensure these extensions are enabled in your `php.ini` file. Look for the following lines in `php.ini` and ensure they are uncommented (remove `;` at the start):
```ini
extension=openssl
extension=curl
extension=fileinfo
```
After making changes, restart your web server (e.g., XAMPP, WAMP, etc.).

**2. Permissions issues:**  
Ensure that the `storage` and `bootstrap/cache` directories have the correct permissions. Run the following command to set proper permissions:
```bash
chmod -R 775 storage bootstrap/cache
```

**3. Database connection issues:**  
If you face issues connecting to the database, check that your MySQL service is running, and verify the database credentials in the `.env` file.

---

## Conclusion

You have successfully set up the E-Commerce project on your local development environment. If you face any issues, please review the **Troubleshooting** section. Enjoy building and customizing your E-Commerce application!

