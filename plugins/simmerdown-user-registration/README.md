# SimmerDown - User Registration Plugin

**Author:** SimmerDown Group 
**Course:** INFO3602 - Web Programming and Technologies II

## Description

This plugin provides front-end user registration and login functionality for the SimmerDown budget healthy recipes website. Users can create accounts, log in, and be automatically redirected to submit recipe reviews.

## Features

- Front-end registration form with validation
- Front-end login form
- Password confirmation check
- Automatic assignment of "recipe_reviewer" role upon registration
- Auto-login after successful registration
- Secure nonce verification for all forms
- Redirect to Write Review page after login/registration
- Custom logout functionality
- Responsive design matching SimmerDown theme (orange buttons, dark cards)

## Installation

1. Upload the `simmerdown-user-registration` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create the required pages (see below)

## Required Pages

You need to create **THREE** pages for the registration system to work properly:

| Page Title | Page Slug | Content | Template | Purpose |
|------------|-----------|---------|----------|---------|
| **Register** | register | `[register_form]` | Default | New user signup |
| **Login** | login | `[login_form]` | Default | Existing user login |
| **Write Review** | write-review | (leave blank) | **Write Review Child Page** | Redirect after login/register |

### How to Create Each Page:

#### 1. Register Page
- Go to **Pages** → **Add New**
- **Title:** `Register`
- **Content:** `[register_form]`
- **Template:** Default Template
- **Publish**

#### 2. Login Page
- Go to **Pages** → **Add New**
- **Title:** `Login`
- **Content:** `[login_form]`
- **Template:** Default Template
- **Publish**

#### 3. Write Review Page
- Go to **Pages** → **Add New**
- **Title:** `Write Review`
- **Content:** (leave blank)
- **Template:** Select **"Write Review Child Page"** (from Post & Reviews plugin)
- **Parent:** Set to **"Post & Reviews"** (so it becomes a child page)
- **Publish**
