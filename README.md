## Requirements

| Tool | Version |
|---|---|
| XAMPP | v8.x (PHP 8.x + Apache + MySQL) |
| PHP | 8.0 or higher |
| MySQL | 5.7 / 8.0 |
| Composer | Latest |

---

## Local Setup

### 1. Clone the repository

```bash
git clone <your-repo-url>
cd scansworld
```


### 2. Install PHP dependencies (Composer)

```bash
composer install
```

> This installs `composer require vlucas/phpdotenv` used for loading the `.env` file.

### 3. Set up your environment file

```bash
cp .env.example .env
```

Then open `.env` and fill in your actual values. See [Environment Configuration](#environment-configuration) below.

### 4. Start XAMPP

- Start **Apache** and **MySQL** from the XAMPP Control Panel.
- Visit: [http://localhost/scansworld](http://localhost/scansworld)

---

## Environment Configuration

All sensitive configuration is stored in the `.env` file at the project root.  
**Never commit `.env` to version control** — use `.env.example` as the template.


## Third-Party Services

### Cloudflare Turnstile (CAPTCHA)

All public forms are protected by Cloudflare Turnstile.

1. Go to [https://dash.cloudflare.com/](https://dash.cloudflare.com/) → **Turnstile**
2. Add your site and get the **Site Key** and **Secret Key**
3. Add them to your `.env` file

> For **local development**, Turnstile provides test keys that always pass:
> - Site Key: `1x00000000000000000000AA`
> - Secret Key: `1x0000000000000000000000000000000AA`

### SMTP Email

The project uses PHPMailer over SMTP (SSL, port 465).  
Any SMTP provider works (Gmail, Zoho, custom hosting, etc.).

---

## Project Structure

```
scansworld/
├── admin/                  # Admin panel (reports, manage content)
├── assets/                 # CSS, JS, images
├── db changes/             # SQL migration files (run these in order)
├── includes/
│   └── config.php          # DB connection, helper functions (getUserIP, etc.)
├── mail/
│   └── mail.php            # PHPMailer mailer() wrapper
├── uploads/                # Uploaded images (blogs, doctors, banners)
├── vendor/                 # Composer packages (gitignored)
├── .env                    # 🔒 Local secrets — NOT committed
├── .env.example            # ✅ Safe template — commit this
├── .gitignore
├── composer.json
├── save_contact.php        # Appointment form handler → book_appointment table
├── contact-us.php          # Contact form handler → enquiry table
├── book-appointment.php    # Appointment booking page
└── index.php               # Homepage
```

---
