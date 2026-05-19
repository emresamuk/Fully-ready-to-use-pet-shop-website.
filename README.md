<div align="center">

  # 🐾 Drool Pet Shop E-Commerce Platform

  A modern, fast, and reliable pet products management and e-commerce system.

  [![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](#)
  [![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](#)
  [![Pure CSS](https://img.shields.io/badge/Pure_CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white)](#)
  [![Railway](https://img.shields.io/badge/Railway-131415?style=for-the-badge&logo=railway&logoColor=white)](#)

</div>

---

## 📖 About the Project

**Drool Pet Shop** is a comprehensive web application where pet owners can safely browse and purchase the products they need. The project was developed by completely revamping the user interface (UI) with standard CSS, avoiding the constraints of CSS frameworks (like Tailwind).

The application features dynamic announcement systems, customer testimonial sliders, and an advanced authentication infrastructure.

### 🚀 Key Features and Architectural Solutions

- **Custom API-Based Mail Driver (Custom Mail Transport):** A custom HTTP/REST-based Mailtrap API driver integrated into the Laravel core was developed to overcome network and SMTP restrictions in the live server (PaaS) environment.
- **Dynamic Customer Testimonials:** A slider structure fed from the database and updated in real-time.
- **Announcement and Campaign Management:** An interactive announcement panel that informs users instantly.
- **Customized UI/UX:** A modern and responsive design written entirely specific to the project, without depending on external CSS libraries.
- **Secure Authentication:** Password reset, session management, and secure route protections.

---

## 🛠️ Technologies Used

- **Backend:** PHP 8.x, Laravel
- **Frontend:** HTML5, Pure CSS, JavaScript (jQuery/Bootstrap JS interactions)
- **Database:** MySQL
- **Server & Deployment (CI/CD):** Railway, FrankenPHP
- **Services:** Mailtrap API (Custom Driver)

---

## ⚙️ Installation and Development Environment

You can follow the steps below to run the project in your local environment:

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm (For optional asset compilation)
- MySQL

### Steps

1. **Clone the Repository**
   ```bash
   git clone [https://github.com/KULLANICI_ADIN/drool-pet-shop.git](https://github.com/KULLANICI_ADIN/drool-pet-shop.git)
   cd drool-pet-shop
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Set Up Environment Variables**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *(Open the .env file and configure your database connection settings.)*

4. **Prepare the Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Define Custom Mailtrap API Settings (.env)**
   *The project uses a custom-developed API driver instead of standard SMTP:*
   ```env
   MAIL_MAILER=mailtrap
   MAILTRAP_API_KEY=your_api_key_here
   MAILTRAP_INBOX_ID=your_inbox_id_here
   MAIL_FROM_ADDRESS="info@droolpetshop.com"
   ```

6. **Start the Server**
   ```bash
   php artisan serve
   ```
   *(The application will start running at `http://localhost:8000`.)*

---

## 👨‍💻 Developer

**Emre Samuk** *Information Systems Engineering* [My GitHub Profile](https://github.com/emresamuk)
