# Laravel Skill Test – Posts API

This repository contains a backend-focused implementation of a RESTful **Posts API** using **Laravel 12**, built according to the provided skill test requirements and Laravel official best practices.

The implementation intentionally focuses on **architecture, correctness, validation, authorization, and API responses**. No UI/view layer is required.

---

## Overview

The application exposes RESTful endpoints for managing posts with support for:

* Draft posts
* Scheduled publishing
* Published (active) posts
* Session & cookie–based authentication
* Authorization via Policies
* Validation via Form Requests
* Consistent JSON output via API Resources

### Post Status Rules

A post’s status is derived from the database schema:

* **Draft**: `is_draft = true`
* **Scheduled**: `is_draft = false` and `published_at > now()`
* **Published (Active)**: `is_draft = false` and `published_at <= now()`

Scheduled posts automatically become active when their publish date is reached (no cron job required).

---

## Tech Stack

* PHP 8.4
* Laravel 12
* SQLite
* Laravel built-in authentication (session & cookies)
* Vite (default setup; UI not required)

---

## Setup Instructions

### 1. Clone the repository

```bash
git clone <your-repository-url>
cd laravel-skill-test
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database setup

```bash
php artisan migrate
php artisan db:seed
```

### 5. Build assets (optional)

UI is not required for this test, but to avoid Vite manifest errors:

```bash
npm run build
```

### 6. Run the server

```bash
php artisan serve
```

---

## Authentication

This project uses **Laravel’s built-in session & cookie authentication**.

* Token-based authentication (Sanctum, Passport, etc.) is intentionally not used
* For API testing, login via browser at `/login` to establish a session
* Sample users are provided via database seeding

---

## API Endpoints

### Public Routes

| Method | Endpoint      | Description                         |
| ------ | ------------- | ----------------------------------- |
| GET    | /posts        | Paginated (20) list of active posts |
| GET    | /posts/{post} | Show a single active post           |

Draft and scheduled posts return **404** on the show endpoint.

---

### Authenticated Routes

| Method    | Endpoint           | Description                        |
| --------- | ------------------ | ---------------------------------- |
| GET       | /posts/create      | Returns `posts.create`             |
| POST      | /posts             | Create a new post                  |
| GET       | /posts/{post}/edit | Returns `posts.edit` (author only) |
| PUT/PATCH | /posts/{post}      | Update a post (author only)        |
| DELETE    | /posts/{post}      | Delete a post (author only)        |

---

## Authorization

Authorization is handled using a **PostPolicy**:

* Only the post author may update or delete a post
* Authenticated users may create posts
* Public users may only access published posts

---

## Validation

Validation is handled via **Form Request classes**:

* `StorePostRequest`
* `UpdatePostRequest`

Validation rules correctly handle:

* Draft vs published posts
* Boolean input handling (`is_draft`)
* Required publish dates when publishing

---

## API Responses

All endpoints returning post data use a **PostResource** to ensure:

* Consistent JSON structure
* Author data is always included
* Datetime values are formatted in ISO-8601

Example response:

```json
{
  "data": {
    "id": 1,
    "title": "Example Post",
    "content": "Post content",
    "published_at": "2026-01-12T10:00:00Z",
    "author": {
      "id": 1,
      "name": "Test User"
    }
  }
}
```

---

## Routing Structure

Routes are split between public and authenticated access for clarity and security:

* **Public**: `index`, `show`
* **Authenticated**: `create`, `store`, `edit`, `update`, `destroy`

---

## Notes

* View files are intentionally omitted per the test specification
* No background jobs or schedulers are required
* Code follows Laravel 12 conventions and official documentation

---

## Commit History

Commits are kept small, descriptive, and focused to reflect real-world development practices.

---

## Final Notes

This submission prioritizes:

* Clean architecture
* Explicit business rules
* Security and correctness
* Reviewer readability

Thank you for reviewing this submission.
