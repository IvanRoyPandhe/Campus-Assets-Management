# Asset Management System Tests

This directory contains tests for the Asset Management System. These tests ensure that the application works correctly and help prevent regressions when making changes.

## Test Structure

- **Unit Tests**: Test individual components in isolation
- **Feature Tests**: Test complete features and their interactions
- **Browser Tests**: Test the application through a browser using Laravel Dusk

## Running Tests

### Using PHPUnit

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run specific test file
php artisan test tests/Feature/AssetManagementTest.php

# Run with coverage report
XDEBUG_MODE=coverage php artisan test --coverage
```

### Using Docker

```bash
# Build and run tests in Docker
docker-compose -f docker-compose.test.yml up --build

# Run tests in an existing Docker container
docker-compose -f docker-compose.test.yml exec app php artisan test
```

### Using GitHub Actions

Tests are automatically run on GitHub when pushing to the main branch or creating a pull request. You can view the test results in the GitHub Actions tab of the repository.

## Test Coverage

The tests cover the following aspects of the application:

### Authentication
- User registration
- User login
- Role-based access control (admin vs student)
- Logout functionality

### Asset Management
- Viewing assets (both admin and student)
- Creating assets (admin only)
- Editing assets (admin only)
- Deleting assets (admin only)
- Asset search functionality

### Location Management
- Viewing locations (both admin and student)
- Creating locations (admin only)
- Editing locations (admin only)
- Deleting locations (admin only)
- Location-asset relationship

### UI/UX
- Theme toggle functionality (light/dark mode)
- Responsive design
- Navigation between pages

## Adding New Tests

When adding new features to the application, please also add corresponding tests to ensure the feature works correctly and continues to work in the future.

## Test Environment

Tests use an in-memory SQLite database by default to ensure they run quickly and don't affect your development database. You can change this in the `phpunit.xml` file if needed.