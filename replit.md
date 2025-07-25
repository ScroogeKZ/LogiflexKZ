# Хром-KZ Логистика - Shipment Management System

## Overview

This is a full-stack web application for managing shipment orders for Хром-KZ logistics company. The application provides forms for creating shipment orders (both local Astana orders and regional orders) and an admin panel for managing these orders.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### PHP Application Architecture
- **Language**: PHP 8.3 with composer autoload
- **Web Server**: PHP built-in server for development
- **Database**: PostgreSQL with PDO connections
- **Authentication**: PHP sessions with secure password hashing
- **UI Framework**: Tailwind CSS via CDN
- **Class Structure**: PSR-4 autoloading with namespace App\

### File Structure
- **public/**: Web-accessible PHP pages (index, forms, admin)
- **src/**: PHP classes (Auth, Models, Services)
- **config/**: Database configuration
- **vendor/**: Composer dependencies

## Key Components

### Database Schema
Located in `shared/schema.ts`:
- **users**: Admin users with username/password authentication
- **shipment_orders**: Main entity storing all shipment order data
  - Common fields: pickup address, ready time, cargo type, weight, dimensions, contact info
  - Regional-specific fields: destination city, delivery method, desired arrival date
  - Meta fields: order type (astana/regional), status, timestamps

### API Routes
Located in `server/routes.ts`:
- **POST /api/admin/login**: Admin authentication
- **POST /api/admin/logout**: Admin logout
- **GET /api/admin/status**: Check admin session status
- **POST /api/orders**: Create new shipment order
- **GET /api/orders**: Get filtered shipment orders (admin only)
- **PUT /api/orders/:id/status**: Update order status (admin only)

### Frontend Pages
- **Home** (`/`): Landing page with service overview and navigation
- **Astana Form** (`/astana`): Form for local Astana shipment orders
- **Regional Form** (`/regional`): Form for regional shipment orders with additional fields
- **Admin Panel** (`/admin`): Protected admin interface for order management
- **Admin Login** (`/admin/login`): Authentication page

### Storage Layer
`server/storage.ts` implements a repository pattern with:
- User management (create, get by username/ID)
- Shipment order CRUD operations
- Filtering capabilities for admin queries

## Data Flow

1. **Order Creation**: Users fill out forms → validation → API call → database storage
2. **Admin Management**: Admin login → session creation → access to order management
3. **Order Filtering**: Admin queries → database filtering → formatted results
4. **Status Updates**: Admin actions → API calls → database updates → UI refresh

## External Dependencies

### Database
- **Neon PostgreSQL**: Serverless PostgreSQL database
- **Connection**: WebSocket-based connection pooling
- **Environment**: Requires `DATABASE_URL` environment variable

### Authentication
- **Session Storage**: PostgreSQL-based session store
- **Security**: bcrypt password hashing, secure session cookies
- **Environment**: Requires `SESSION_SECRET` environment variable

### UI Libraries
- **Radix UI**: Accessible component primitives
- **Shadcn/UI**: Pre-built component library
- **Tailwind CSS**: Utility-first CSS framework
- **Lucide React**: Icon library

### Development Tools
- **Drizzle Kit**: Database migration and schema management
- **TypeScript**: Type safety across the stack
- **ESLint/Prettier**: Code formatting and linting
- **Vite**: Fast development server and build tool

## Deployment Strategy

### Development
- Run `npm run dev` to start both frontend and backend
- Vite handles frontend with HMR
- Express serves API routes and static files in production

### Production
- `npm run build` creates optimized frontend bundle
- `npm start` runs production Express server
- Database migrations with `npm run db:push`

### Environment Variables
- `DATABASE_URL`: PostgreSQL connection string
- `SESSION_SECRET`: Session encryption key
- `NODE_ENV`: Environment mode (development/production)

The application is designed to be simple, reliable, and easy to maintain while providing all necessary functionality for shipment order management.

## Recent Changes: Latest modifications with dates

### July 16, 2025 - Workflow Configuration Fixed
- ✓ Fixed startup issue caused by Node.js workflow trying to run PHP application
- ✓ Created Node.js wrapper script (start.js) to launch PHP server via npm run dev
- ✓ PHP development server now running successfully on port 5000
- ✓ All application pages responding correctly:
  - Homepage (/) - HTTP 200
  - Astana form (/astana.php) - HTTP 200
  - Regional form (/regional.php) - HTTP 200
  - Admin login (/admin/login.php) - HTTP 200
- ✓ Added company logo to proper assets directory
- ✓ Application fully operational and ready for use

### July 16, 2025 - Final PHP Migration & Cleanup
- ✓ Removed all Node.js/React files (client/, server/, package.json, etc.)
- ✓ Added Telegram Bot integration for order notifications
- ✓ Cleaned up project structure to pure PHP only
- ✓ Created setup documentation for Telegram integration
- ✓ Application now runs exclusively on PHP 8.3
- ✓ Simple structure: public/ for web files, src/ for PHP classes

### July 16, 2025 - Migration from Node.js to Pure PHP  
- ✓ Completely migrated application from Node.js/React to Pure PHP
- ✓ Maintained all existing functionality in native PHP:
  - Order creation forms (Astana and Regional)
  - Admin authentication and authorization
  - Order management and status updates
  - Database integration with PostgreSQL
- ✓ Created PHP class structure:
  - Database connection handling with PDO
  - User authentication and session management
  - ShipmentOrder model for CRUD operations
  - Security features (password hashing, input validation)
- ✓ Implemented responsive UI with Tailwind CSS via CDN
- ✓ Preserved all business logic and database schema
- ✓ Added security headers and .htaccess configuration
- ✓ Created admin user (username: admin, password: admin123)

### July 14, 2025 - Migration to Replit Complete (Node.js Version)
- ✓ Created PostgreSQL database and migrated schema
- ✓ Installed all required packages and dependencies  
- ✓ Fixed session security by generating secure SESSION_SECRET
- ✓ Verified all API endpoints work correctly:
  - Order creation (Astana and Regional forms)
  - Admin authentication and authorization
  - Order management and status updates
- ✓ Tested frontend components and navigation
- ✓ Confirmed database operations and data persistence
- ✓ Application successfully running on Replit environment

### July 14, 2025 - ES Modules Fix & Telegram Integration (Node.js Version)
- ✓ Fixed ES modules compatibility issue with crypto imports
- ✓ Added Telegram Bot integration for order notifications
- ✓ Implemented automatic notifications for new orders
- ✓ Added status update notifications for admin actions
- ✓ Enhanced admin panel with Telegram configuration status
- ✓ All orders successfully saving to database
- ✓ Session management improved with better cookie settings
- ✓ Added comprehensive city selection for regional shipments
- ✓ Replaced manual city input with dropdown of all Kazakhstan cities

### July 14, 2025 - Regional Form Restructuring & Logo Integration (Node.js Version)
- ✓ Restructured regional form field order: Origin City → Pickup Address → Destination City → Delivery Address
- ✓ Added pickup city selection with dropdown for all Kazakhstan cities
- ✓ Enhanced database schema with pickup_city field for regional orders
- ✓ Updated Telegram notifications to include pickup city information
- ✓ Integrated company logo (Хром-KZ) across all pages:
  - Navigation header with logo and company name
  - Hero section of homepage with prominent logo display
  - Admin login page with logo for branding consistency
- ✓ All UI elements updated to reflect new form structure