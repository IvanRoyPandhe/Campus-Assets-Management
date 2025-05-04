#!/bin/bash

# Script to run tests for the Asset Management System
# This script can be used by DevOps to test the application before deployment

# Set colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Starting Asset Management System Tests${NC}"
echo "========================================"

# Function to run tests and check result
run_test() {
    echo -e "${YELLOW}Running $1 tests...${NC}"
    $2
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ $1 tests passed!${NC}"
        return 0
    else
        echo -e "${RED}✗ $1 tests failed!${NC}"
        return 1
    fi
}

# Check if .env.testing exists, if not create it
if [ ! -f .env.testing ]; then
    echo "Creating .env.testing file..."
    cp .env.example .env.testing
    php artisan key:generate --env=testing
fi

# Install dependencies if needed
if [ ! -d "vendor" ]; then
    echo "Installing dependencies..."
    composer install --no-interaction --prefer-dist
fi

# Clear caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations with testing environment
echo "Running migrations..."
php artisan migrate:fresh --env=testing --seed

# Run unit tests
run_test "Unit" "php artisan test --testsuite=Unit"
UNIT_RESULT=$?

# Run feature tests
run_test "Feature" "php artisan test --testsuite=Feature"
FEATURE_RESULT=$?

# Run browser tests if Dusk is installed
if [ -f "vendor/bin/dusk" ]; then
    run_test "Browser" "php artisan dusk"
    BROWSER_RESULT=$?
else
    echo -e "${YELLOW}Skipping browser tests (Laravel Dusk not installed)${NC}"
    BROWSER_RESULT=0
fi

# Generate code coverage report if xdebug is installed
if php -m | grep -q xdebug; then
    echo "Generating code coverage report..."
    XDEBUG_MODE=coverage php artisan test --coverage-html coverage
    echo "Coverage report generated in coverage/ directory"
fi

# Summary
echo ""
echo -e "${YELLOW}Test Summary:${NC}"
echo "========================================"
[ $UNIT_RESULT -eq 0 ] && echo -e "${GREEN}✓ Unit tests passed${NC}" || echo -e "${RED}✗ Unit tests failed${NC}"
[ $FEATURE_RESULT -eq 0 ] && echo -e "${GREEN}✓ Feature tests passed${NC}" || echo -e "${RED}✗ Feature tests failed${NC}"
[ $BROWSER_RESULT -eq 0 ] && echo -e "${GREEN}✓ Browser tests passed${NC}" || echo -e "${RED}✗ Browser tests failed${NC}"

# Final result
if [ $UNIT_RESULT -eq 0 ] && [ $FEATURE_RESULT -eq 0 ] && [ $BROWSER_RESULT -eq 0 ]; then
    echo -e "${GREEN}All tests passed! The application is ready for deployment.${NC}"
    exit 0
else
    echo -e "${RED}Some tests failed! Please fix the issues before deploying.${NC}"
    exit 1
fi