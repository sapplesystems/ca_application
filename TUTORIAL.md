# CA Billing Application - Complete Tutorial

## Overview

The CA Billing Application is a comprehensive web-based system built with CodeIgniter 4 for Chartered Accountants to manage their billing, invoicing, and client relationships. This tutorial will guide you through installation, setup, and usage of the application.

## Table of Contents

1. [System Requirements](#system-requirements)
2. [Installation](#installation)
3. [Database Setup](#database-setup)
4. [Initial Configuration](#initial-configuration)
5. [User Management](#user-management)
6. [Client Management](#client-management)
7. [Company Management](#company-management)
8. [Work/Services Management](#workservices-management)
9. [Invoice Management](#invoice-management)
10. [Receipt Management](#receipt-management)
11. [Debit Notes](#debit-notes)
12. [Reports and Analytics](#reports-and-analytics)

## System Requirements

- **PHP**: Version 8.1 or higher
- **Web Server**: Apache/Nginx with mod_rewrite enabled
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **Extensions**: 
  - intl
  - mbstring
  - mysqli (for MySQL)
  - gd (for image processing)
- **Composer**: For dependency management

## Installation

### Step 1: Download and Extract
1. Download the application files
2. Extract to your web server's document root (e.g., `htdocs` or `www`)
3. Ensure the web server has write permissions to the following directories:
   - `writable/cache/`
   - `writable/logs/`
   - `writable/session/`
   - `writable/uploads/`

### Step 2: Install Dependencies
Navigate to the project root directory and run:
```bash
composer install
```

### Step 3: Environment Configuration
1. Copy `.env.example` to `.env`
2. Update the following settings in `.env`:
```env
# Database Configuration
database.default.hostname = localhost
database.default.database = ca_billing
database.default.username = your_db_user
database.default.password = your_db_password
database.default.DBDriver = MySQLi

# Base URL
app.baseURL = 'http://localhost/ca_application/'

# Encryption Key (generate a random 32-character string)
app.encryptionKey = 'your_random_32_character_key_here'
```

## Database Setup

### Step 1: Create Database
Create a new MySQL database named `ca_billing`

### Step 2: Run Migrations
Execute the following command from the project root:
```bash
php spark migrate
```

This will create all necessary tables:
- `client_master` - Client information
- `company_master` - Company details
- `invoices` - Invoice records
- `invoice_works` - Invoice line items
- `recipt_details` - Payment receipts
- `debits` - Debit notes
- `expenses` - Expense tracking
- `work_master` - Services catalog
- `user_management` - User accounts
- `roles` - User roles
- `permissions` - Role permissions
- `role_permissions` - Role-permission mappings

### Step 3: Seed Initial Data (Optional)
If seeders are available, run:
```bash
php spark db:seed
```

## Initial Configuration

### Step 1: Create Admin User
Since there's no default admin user, you'll need to manually insert one into the database:

```sql
INSERT INTO user_management (name, email, password, status, role_id, created_at) VALUES
('Admin User', 'admin@cafirm.com', '$2y$10$examplehashedpassword', 1, 1, NOW());
```

**Note**: Use a proper password hash. You can generate one using PHP's `password_hash()` function.

### Step 2: Create Default Role
Insert a default admin role:

```sql
INSERT INTO roles (name, permission_type, status, created_at) VALUES
('Administrator', 'all', 1, NOW());
```

## User Management

### Creating Roles
1. Navigate to **Roles** in the main menu
2. Click **Create Role**
3. Enter role name (e.g., "Accountant", "Junior CA")
4. Set permission type:
   - **All**: Full access to all modules
   - **Custom**: Select specific permissions
5. If custom, select permissions for each module

### Adding Users
1. Go to **User Management**
2. Click **Add User**
3. Fill in user details:
   - Name
   - Email
   - Password
   - Role assignment
4. Set status to Active

### User Permissions
The system supports granular permissions for:
- Work Master (view, add, edit, delete)
- Company Management
- Client Management
- Invoice Management
- Receipt Management
- Debit Notes
- Reports
- PDF Generation
- Role Management
- User Management

## Client Management

### Adding a New Client
1. Navigate to **Client Master**
2. Click **Add Client**
3. Fill in client information:

#### Basic Information
- **CIN No**: Corporate Identity Number
- **Legal Name**: Official company name
- **Trade Name**: Business name (if different)
- **ROC Code**: Registrar of Companies code
- **Registration No**: Company registration number
- **Date of Incorporation**: Company formation date

#### Financial Information
- **Authorized Share Capital**
- **Paid-up Share Capital**
- **PAN**: Permanent Account Number
- **GSTIN**: GST Identification Number
- **ESI No**: Employee State Insurance number
- **IEC Code**: Import Export Code

#### Contact Information
- **Registered Office Address**
- **Corporate Office Address**
- **Telephone**
- **Fax**
- **Website**
- **Billing Emails** (comma-separated)

#### Additional Details
- **Company Category/Sub-category**
- **Nature of Business/Service/Product**
- **Directors Count**
- **Subsidiary Names**
- **Payment Terms**
- **GST State**

### Managing Clients
- **Edit**: Modify client information
- **Status**: Activate/deactivate clients
- **Search**: Find clients by name, PAN, or GSTIN

## Company Management

### Adding Your Company
1. Go to **Company Master**
2. Click **Add Company**
3. Enter company details:
   - Company Name
   - Type of Company (Proprietorship, Partnership, Pvt Ltd, etc.)
   - Address
   - Contact Information
   - Tax Details (PAN, GSTIN, etc.)
   - Bank Details

### Company Types Supported
- Proprietorship
- Partnership
- Private Limited
- Public Limited
- LLP
- Trust
- Society
- Others

## Work/Services Management

### Adding Services
1. Navigate to **Work Master**
2. Click **Add Service**
3. Enter service details:
   - Service Name
   - Description
   - Default Rate/Price
   - Tax Category
   - Status

### Service Categories
Common CA services include:
- Statutory Audit
- Tax Audit
- GST Returns
- Income Tax Returns
- Company Formation
- ROC Compliance
- Accounting Services
- Internal Audit
- Certification Services

## Invoice Management

### Creating an Invoice
1. Go to **Invoice Management**
2. Click **Create Invoice**
3. Select Client and Company
4. Enter Invoice Details:
   - Invoice Number (auto-generated or manual)
   - Invoice Date
   - Due Date
   - Terms & Conditions

### Adding Invoice Items
1. In the invoice form, add work items:
   - Select Service from Work Master
   - Enter Quantity/Hours
   - Unit Price
   - Description
   - Tax Rate (if applicable)

### Invoice Features
- **Auto-calculation**: Total amounts calculated automatically
- **Tax Calculation**: GST and other taxes
- **Preview**: Preview invoice before saving
- **PDF Generation**: Generate professional PDF invoices
- **Print**: Print invoices directly
- **Email**: Send invoices to clients

### Managing Invoices
- **Edit**: Modify existing invoices
- **Delete**: Remove invoices (with confirmation)
- **Status Tracking**: Track invoice status
- **Search & Filter**: Find invoices by client, date, status

## Receipt Management

### Recording Payments
1. Navigate to **Invoice Management**
2. Select an invoice
3. Click **Add Receipt**
4. Enter payment details:
   - Receipt Number
   - Payment Date
   - Amount Received
   - Payment Method (Cash, Cheque, Online, etc.)
   - Bank Details (if applicable)
   - Remarks

### Receipt Features
- **Multiple Receipts**: Record partial payments
- **Receipt Printing**: Generate receipt vouchers
- **PDF Export**: Export receipts as PDF
- **Payment Tracking**: Track payment history per invoice

## Debit Notes

### Creating Debit Notes
1. Go to **Invoice Management**
2. Select an invoice
3. Click **Create Debit Note**
4. Enter debit note details:
   - Reason for debit
   - Amount
   - Description
   - Date

### Debit Note Management
- **Edit**: Modify debit notes
- **Delete**: Remove debit notes
- **PDF Generation**: Generate debit note PDFs
- **Tracking**: Track all debit notes per invoice

## Reports and Analytics

### Available Reports
1. **Client-wise Invoices**: All invoices per client
2. **Monthly Revenue**: Revenue tracking
3. **Outstanding Payments**: Pending payments
4. **Tax Reports**: GST and other tax summaries
5. **Service-wise Revenue**: Revenue by service type

### Generating Reports
1. Navigate to **Reports** section
2. Select report type
3. Set date range and filters
4. Generate and export reports

## Security Features

### User Authentication
- Secure login with email/password
- Session management
- Password hashing
- Account lockout protection

### Role-Based Access Control
- Granular permissions
- Module-level access control
- Action-level permissions (view, add, edit, delete)

### Data Security
- Input validation and sanitization
- CSRF protection
- XSS prevention
- SQL injection prevention

## Backup and Maintenance

### Database Backup
Regularly backup your database:
```sql
mysqldump -u username -p ca_billing > backup.sql
```

### File Backup
Backup the entire application directory and uploaded files in `writable/uploads/`

### Maintenance Tasks
- Clear cache: `writable/cache/`
- Clear logs: `writable/logs/`
- Update dependencies: `composer update`

## Troubleshooting

### Common Issues

#### Login Issues
- Verify email and password
- Check account status (active/inactive)
- Clear browser cache and cookies

#### Database Connection Errors
- Verify database credentials in `.env`
- Ensure database server is running
- Check database user permissions

#### Permission Errors
- Verify user role and permissions
- Check if role has required permissions assigned
- Clear application cache

#### File Upload Issues
- Check `writable/uploads/` permissions
- Verify file size limits in PHP configuration
- Check supported file types

### Error Logs
Check error logs in `writable/logs/` for detailed error information.

## Support

For technical support or feature requests:
- Check the application logs
- Verify system requirements
- Ensure all dependencies are installed
- Contact your system administrator

## Version Information

- **Framework**: CodeIgniter 4.x
- **PHP**: 8.1+
- **Database**: MySQL 5.7+/MariaDB 10.2+
- **PDF Generation**: DomPDF
- **Authentication**: Session-based with role permissions

---

**Note**: This tutorial assumes basic knowledge of web servers, databases, and PHP. For advanced configuration or customization, consult with a qualified developer.</content>
<parameter name="filePath">c:\wamp64\www\ca_application\TUTORIAL.md