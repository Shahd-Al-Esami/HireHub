# HireHub

A Laravel-based freelancer marketplace platform connecting clients with skilled professionals.



### Installation
1. **Clone the repository:**
   ```bash
   git clone [https://github.com/Shahd-Al-Esami/HireHub.git]
   cd HireHub


## About

HireHub is a modern web application built with **Laravel 12** that enables clients to post projects and receive offers from verified freelancers. The platform facilitates the entire hiring workflow—from project posting to offer management.

## Problems This Project Solves

| Problem | Solution |
|---------|----------|
| **Fragmented hiring process** | Centralized platform connecting clients and freelancers in one place |
| **Difficulty finding verified talent** | Freelancer verification system ensures quality professionals |
| **Inefficient project matching** | Smart filtering by budget, skills, availability, and project status |
| **Lack of transparency in pricing** | Open project listings with budget type (fixed/hourly) visibility |
| **No structured offer management** | Formal offer system with status tracking (pending/accepted/rejected) |
| **Limited freelancer visibility** | Public profiles with ratings, skills, portfolio links, and availability |
| **Manual communication overhead** | API-first design enables automated workflows and integrations |

## Key Features

### For Clients (Employers)
- Post projects with title, description, budget, and delivery date
- Browse and filter open projects
- Receive and review offers from verified freelancers
- Leave reviews and ratings for completed work
- Manage multiple projects simultaneously

### For Freelancers
- Create and manage public profiles
- Showcase skills, hourly rate, and portfolio
- Search and bid on open projects
- Track offer status (pending/accepted/rejected)
- Availability status toggle (available/busy/on-hold)

### Platform Capabilities
- **Multi-role system** — Separate workflows for clients and freelancers
- **Verification workflow** — Ensures trusted freelancers on the platform
- **Skill-based matching** — Connect projects with relevant skills
- **Geographic data** — Countries and cities for location-based search
- **Attachment support** — File uploads for projects and profiles
- **Review system** — Rating and feedback mechanism
- **Request logging** — API call monitoring for debugging

## Features

- **User Authentication** — Register, login, and secure API access via Laravel Sanctum
- **Project Management** — Create, browse, and filter projects by budget and date
- **Freelancer Profiles** — Public profiles with skills, ratings, and availability status
- **Offer System** — Freelancers can submit proposals on open projects
- **Role-based Access** — Clients and freelancers with verification workflows
- **API-first Design** — RESTful API with token-based authentication

## Tech Stack

| Component | Technology |
|-----------|------------|
| Framework | Laravel 12 |
| API Auth | Laravel Sanctum |
| Database | MySQL (configurable) |
| PHP Version | 8.2+ |

## API Endpoints

### Authentication
- `POST /api/v1/register` — User registration
- `POST /api/v1/login` — User login
- `POST /api/v1/logout` — User logout (protected)
- `GET /api/v1/me` — Get authenticated user

### Projects
- `GET /api/v1/projects` — List all projects
- `GET /api/v1/projects/{project}` — Get project details
- `POST /api/v1/store-project` — Create project (protected)
- `GET /api/v1/open-projects` — Filter open projects
- `GET /api/v1/projects/min-budget/{amount}` — Filter by minimum budget
- `GET /api/v1/projects/this-month` — Projects created this month

### Freelancers
- `GET /api/v1/freelancers` — List active verified freelancers
- `GET /api/v1/top-rated` — Top rated freelancers
- `GET /api/v1/available-freelancers` — Available freelancers
- `GET /api/v1/show/{profile}` — Public profile details

### Offers
- `GET /api/v1/show-offer/{offer}` — Get offer details
- `POST /api/v1/store-offer-project/{project_id}` — Submit offer (protected, verified freelancers)

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 

### Installation

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Start development server
php artisan serve
```

### API Testing

```bash
# Clear route cache
php artisan route:clear

# List all routes
php artisan route:list
```

## Project Structure

```
app/
├── Actions/          # Laravel Actions (CQRS pattern)
├── Enums/            # Application enumerations
├── Http/Api/         # API Controllers
├── Models/           # Eloquent models
├── Providers/        # Service providers
├── Rules/            # Custom validation rules
└── Services/        # Business logic services
```

## Database Schema

### Entity Relationship Diagram

```
┌─────────────────┐       ┌─────────────────┐
│     users       │       │    countries   │
├─────────────────┤       ├─────────────────┤
│ id              │       │ id              │
│ first_name      │       │ name            │
│ last_name       │       │ code            │
│ email           │       │ phone_code      │
│ password        │       └────────┬────────┘
│ role            │                │
│ city_id ────────┼───────┐        │
│ is_verified     │        │        │
│ is_active       │        │        │
└────────┬────────┘        │        │
         │                 │        │
         │          ┌──────┴────────┐
         │          │     cities    │
         │          ├─────────────────┤
         │          │ id              │
         │          │ name            │
         │          │ country_id ────┘
         │          └─────────────────┘
         │
         │ 1:1
         ▼
┌─────────────────┐       ┌─────────────────┐
│    profiles     │       │     skills      │
├─────────────────┤       ├─────────────────┤
│ id              │       │ id              │
│ user_id ────────┤       │ name            │
│ bio             │       └─────────────────┘
│ hourly_rate     │                ▲
│ image           │                │ n:m
│ phone_number    │       ┌────────┴────────┐
│ portfolio_links │       │ profile_skills  │
│ skills_summary  │       ├─────────────────┤
│ availability_   │       │ id              │
│   status        │       │ profile_id      │
└─────────────────┘       │ skill_id       │
                          │ experience_years│
                          └─────────────────┘
```

### Core Tables

| Table | Description | Key Columns |
|-------|-------------|-------------|
| `users` | Client and freelancer accounts | `id`, `first_name`, `last_name`, `email`, `role`, `city_id`, `is_verified`, `is_active` |
| `profiles` | Freelancer extended profiles | `id`, `user_id`, `bio`, `hourly_rate`, `availability_status` |
| `projects` | Client-posted job listings | `id`, `client_id`, `title`, `description`, `budget_amount`, `budget_type`, `status`, `delivery_date` |
| `offers` | Freelancer proposals on projects | `id`, `project_id`, `freelancer_id`, `status`, `cover_letter`, `price`, `delivery_time` |
| `skills` | Master skills list | `id`, `name` |
| `profile_skills` | Freelancer skill mapping | `id`, `profile_id`, `skill_id`, `experience_years` |
| `tags` | Project categorization tags | `id`, `name` |
| `project_tags` | Project-Tag mapping | `id`, `project_id`, `tag_id` |
| `reviews` | Client feedback on freelancers | `id`, `client_id`, `reviewable_id`, `reviewable_type`, `comment`, `rate` |
| `attachments` | File uploads (polymorphic) | `id`, `user_id`, `file_path`, `attachable_id`, `attachable_type` |
| `countries` | Geographic reference | `id`, `name`, `code`, `phone_code` |
| `cities` | Geographic reference | `id`, `name`, `country_id` |

### Relationships

| Relationship | Type | Description |
|--------------|------|-------------|
| User → Profile | 1:1 | Each user has one profile |
| User → City | n:1 | Users belong to a city |
| User → Projects | 1:n | Clients can post multiple projects |
| User → Offers | 1:n | Freelancers can submit multiple offers |
| Project → Offers | 1:n | Each project receives multiple offers |
| Project → Tags | n:m | Projects can have multiple tags |
| Profile → Skills | n:m | Freelancers have multiple skills |
| Review → User | n:1 | Reviews belong to a client |
| Review → Polymorphic | n:1 | Reviews can target profiles or projects |

## Technical Architecture

### Architecture Pattern

```
┌─────────────────────────────────────────────────────────────┐
│                      API Layer                               │
│  (Controllers: Auth, Project, Profile, Offer, User)        │
└─────────────────────────┬───────────────────────────────────┘
                          │
┌─────────────────────────▼───────────────────────────────────┐
│                   Service Layer                              │
│  (ProfileService, ProjectService, UserService)             │
└─────────────────────────┬───────────────────────────────────┘
                          │
┌─────────────────────────▼───────────────────────────────────┐
│                   Action Layer                               │
│  (Laravel Actions - Business Logic)                        │
└─────────────────────────┬───────────────────────────────────┘
                          │
┌─────────────────────────▼───────────────────────────────────┐
│                   Model Layer                                │
│  (Eloquent ORM with Relationships)                         │
└─────────────────────────┬───────────────────────────────────┘
                          │
┌─────────────────────────▼───────────────────────────────────┐
│                  Database Layer                              │
│  (MySQL/PostgreSQL via migrations)                         │
└─────────────────────────────────────────────────────────────┘
```

### Design Patterns Used

| Pattern | Implementation | Purpose |
|---------|----------------|---------|
| **Service Layer** | `app/Services/` | Business logic encapsulation |
| **Actions** | `app/Actions/` | CQRS - Single responsibility |
| **Enums** | `app/Enums/` | Type safety for statuses |
| **API Resources** | `app/Http/Api/Resources/` | Response transformation |
| **Form Requests** | `app/Http/Api/Requests/` | Input validation |

### Security Features

- **Token Authentication** — Laravel Sanctum for SPA/API auth
- **Role-based Access** — Client vs Freelancer roles
- **Verification System** — Freelancer verification workflow
- **Input Validation** — Custom validation rules (e.g., `NotOffensive`)
- **Soft Deletes** — Data preservation with cascade deletes

### Request Flow

```
Client Request
     │
     ▼
Middleware (auth:sanctum, logApi, FreelancerIsVerified)
     │
     ▼
API Controller
     │
     ▼
Service / Action
     │
     ▼
Model (Eloquent)
     │
     ▼
Database
```

## License

MIT

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
