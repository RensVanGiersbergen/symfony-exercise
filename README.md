# Symfony Exercise

This is a small PoC Symfony project demonstrating:

- A home page
- Generating lucky numbers
- Lucky number api endpoint
- A contact form with Symfony Forms, validation, and email sending
- Emails rendered with Twig templates and captured locally via MailPit

For more detail take a look at the [Features](#features).

---

## Requirements

- PHP 8.2+ (with `pdo_pgsql` if using PostgreSQL)
- Composer
- Symfony CLI
- Docker (for MailPit and database if needed)

---

## Getting started

### 1. Clone the repository

Clone the GitHub repository

```bash
git clone https://github.com/RensVanGiersbergen/symfony-exercise.git
cd symfony-exercise

```

### 2. Install PHP dependencies

Install the vendor packages required to run the project

```bash
composer install
```

### 3. Copy .env example

Copy the .env.local.example to .env.local *Its empty but you get the point*.

```bash
cp .env.local.example .env.local
```

### 4. Start local services for dev environment (optional)

To make the mailing work Mailpit is required. Simply spin up docker-compose.

```bash
docker-compose up -d
```

### 5. Start Symfony server

Lastly start up the Symfony server.

```bash
symfony server:start
```

## Features

Here is a list of the features explained.

### Home page

Just a homepage to tie everything together, nothing special.

### Lucky number page

The lucky number page generates a random number between 0 and 100.

It can be customized with url paramters like so *localhost:8000/number/5/10* to generate a number between 5 and 10.

Don't even try to make the min value higher than the max, I thought of everything :D

There is also an API endpoint available, in case any big application out there want to make use of the random number generator. Simply add api *localhost:8000/api/number* and the same parameters can be applied.

### Contact form page

A contact page to get into contact with the owner of the site.

Fill in your name, a topic and a message that will be send to the owner. Don't try to add numbers to your name, that's impossible.

To check the mail visit the local [Mailpit service](http://localhost:8025). Assuming you didn't change the port in the compose.yaml.

# Contact

For any further questions feel free to reach out at [rensgiersbergen@gmail.com](mailto:rensgiersbergen@gmail.com).