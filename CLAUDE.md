# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Multi-Project Architecture

This workspace contains two interconnected projects:

**CV-Master** (C:\CV-Master): Laravel 11 CV/Portfolio REST API with admin panel
**API Form Integrator** (C:\api-form-integrator): JavaScript library for Laravel API integration

## Development Commands

### CV-Master (Laravel)

#### Unified Development
```bash
composer run dev    # Starts server, queue, logs, and Vite concurrently
```

#### Individual Services
```bash
php artisan serve           # Development server
php artisan test           # Run PHPUnit tests  
php artisan migrate --seed # Database setup
php artisan storage:link   # Create storage symlink
npm run build             # Build Vite assets
```

#### Admin Management
```bash
php artisan make:admin                    # Create admin user
php artisan app:create-fake-message      # Generate test data
```

### API Form Integrator (JavaScript Library)

```bash
npm run build         # Build ESM, CJS, CDN, and TypeScript definitions
npm run dev          # Development with file watching
npm test             # Run Jest tests
npx create-integrator # Generate config for new projects
```

## Architecture Overview

### CV-Master Structure

**API Layer**: Sanctum-authenticated REST API in `app/Http/Controllers/Api/`
- Resources transform Eloquent models for consistent JSON responses
- Request validation classes handle input sanitization
- Rate limiting on contact endpoints

**Core Models**: CV components with file upload capabilities
- CVInformation, Portfolio, Experience, Service, Skill, Testimonial
- PortfolioImage and Contact models for related data
- Admin model extends User with Sanctum tokens

**File Management**: Laravel Storage with public disk
- CV PDFs in `storage/app/public/cv/files/`
- Images organized by type: `avatars/`, `portfolio_images/`, `testimonial/images/`

**Admin Panel**: Blade templates using Bootstrap 5 with custom KaiAdmin theme
- CRUD interfaces for all CV components
- File upload handling with image optimization
- Turkish localization support

### API Form Integrator Architecture

**Core Classes**:
- `ApiFormIntegrator`: Main orchestrator with configuration management
- `FormFactory`: Creates form instances with merged configurations  
- `BaseForm`: Abstract class handling validation and submission lifecycle
- `ApiService`: Axios wrapper with CSRF, authentication, and error handling

**Build System**: Multi-format output via Rollup
- ESM for modern environments
- CommonJS for Node.js compatibility
- CDN/UMD bundle for direct browser use
- CLI binary for project scaffolding

**Laravel Integration**: Designed specifically for Laravel backends
- Automatic CSRF token detection and refresh
- Laravel validation error parsing
- Sanctum token lifecycle management
- Error response handling matching Laravel patterns

## Key Integration Points

### Authentication Flow
1. Laravel Sanctum provides API tokens via `/api/login`
2. API Form Integrator manages token storage and automatic header injection
3. Token refresh handled transparently on 401 responses

### Form Processing
1. Client-side validation using API Form Integrator rules
2. Laravel Request classes provide server-side validation
3. Validation errors returned in Laravel format, automatically displayed by integrator

### File Uploads
1. Forms submit as FormData when files are present
2. Laravel handles storage using configured disk
3. Public URLs generated for file access

## Development Workflow

### Adding New CV Components
1. Create migration with appropriate fields and foreign keys
2. Generate Eloquent model with fillable fields and relationships
3. Create API Resource for JSON transformation
4. Add Form Request validation class
5. Implement API controller with CRUD operations
6. Add routes to `routes/api.php`
7. Create admin Blade views for management interface
8. Configure API Form Integrator for client-side forms

### Testing Strategy
- **Feature Tests**: Test complete API workflows including authentication
- **Unit Tests**: Test individual model methods and validation logic
- **JavaScript Tests**: Test form integrator validation and API communication
- Use factories and seeders for consistent test data

## Important Configuration

### Laravel Configuration
- Database: SQLite for development (`database/database.sqlite`)
- Storage: Public disk with symlink for file access
- Queue: Sync driver for development, database for production
- Cache: File driver with array for testing

### Vite Asset Pipeline
- Entry points: `resources/js/app.js`, `resources/js/admin.js`
- CSS processing with Tailwind CSS
- Library aliases configured for Bootstrap, FontAwesome, jQuery
- Hot reload enabled for development

### API Form Integrator
- Default configuration in `src/config/default.config.js`
- CLI generates project-specific config files
- Supports custom validation messages and error handling
- SweetAlert2 integration for user notifications