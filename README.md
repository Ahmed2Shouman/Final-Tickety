# Tickty - Cinema Ticket Booking System 🎬

## Overview
**Tickty** is a modern web-based cinema booking system that allows users to explore movies, select their favorite showtimes, choose their seats interactively, and complete payments securely using Stripe. The platform is designed with a dynamic UI, role-based access controls, and interactive seat booking functionality.

## Core Features
### 🎥 For Users:
- Browse "Now Showing" movies with posters, genres, ratings, and trailers.
- View detailed movie information and available showtimes.
- Select specific seats from a visual seat map (supports VIP/Standard).
- Live seat pricing summary with service fees.
- Stripe-based secure checkout.
- Receive downloadable ticket PDF with a QR code.
- View personal booking history and saved card details.

### 🔧 For Admins:
- Create and manage movies, showtimes, and halls.
- Visual seat assignment for each hall.
- View bookings and payments.
- Admin dashboard overview.

### 🛠️ For Super Admins:
- Full access to manage admins, users, movies, payments, and bookings.
- Create and manage cinema companies.
- Assign roles to users.
- Dedicated dashboards for overview and management.

## Tech Stack
- **Backend:** Laravel 10
- **Frontend:** Blade Templates, Bootstrap 5
- **Database:** MySQL
- **Authentication:** Laravel Auth
- **Payment Integration:** Stripe
- **UI Enhancements:** Custom CSS variables, JS interactivity, QR code generation (Simple QR Code)

## Project Structure Highlights
```
app/
  Http/
    Controllers/
      UserController.php
      AdminController.php
      SuperAdminController.php
  Models/
    Movie.php
    Booking.php
    Showtime.php
    Payment.php
resources/
  views/
    user/
    admin/
    superadmin/
    components/
public/
  css/
    app.css (Dark Theme + Custom Styling)
```

## Database Overview
- **Users:** name, email, role
- **Movies:** title, description, genre, rating, duration, trailer_url, poster_url
- **Showtimes:** linked to movies and halls
- **Halls:** name, seat layout
- **Seats:** linked to halls with type and availability
- **Bookings:** user, showtime, seats (JSON), status
- **Payments:** linked to bookings, Stripe metadata stored

## UX Highlights
- Mobile responsive design
- Dark mode UI using `:root` CSS variables
- Smooth seat selection interaction with validation
- Tickets include QR codes for gate validation
- Interactive modal for viewing saved cards

---

## 🧒 Explain the Project to a Child
> "Imagine you want to go see a movie with your friends. You open Tickty on your phone or computer. You see pictures of cool movies. You pick one you like. Then, you choose what time you want to go and click on your favorite seat (maybe a VIP seat if you're feeling fancy!). You pay with your card, and ta-da! You get a magical ticket with a special code. When you get to the cinema, they scan your code, and you’re in! Easy, fun, and no waiting in line."

---

## How to Run Locally 🖥️
1. Clone the project:
   ```bash
   git clone https://github.com/yourname/tickty.git
   cd tickty
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```
3. Setup `.env` and database:
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   ```
4. Add your Stripe API keys to `.env`:
   ```env
   STRIPE_KEY=pk_test_...
   STRIPE_SECERT=sk_test_...
   ```
5. Start the server:
   ```bash
   php artisan serve
   ```
6. Visit `http://127.0.0.1:8000`

---

## Future Improvements ✨
- Email notification system for ticket confirmation
- Real-time seat locking
- Promo codes and gift cards
- Multilingual support
- Cinema ratings and reviews

## License
MIT License

---

Made with ❤️ by Tickty Dev Team

