#!/bin/bash

# Script to configure Nginx for bazaar.local

# Exit immediately if any command fails
set -e

# Step 1: Copy nginx.conf to bazaar (no extension)
echo "Copying bazaar.conf to bazaar..."
sudo cp ./nginx.conf /etc/nginx/sites-available/bazaar
echo "✅ Copy completed"

# Step 2: Create symbolic link in sites-enabled
echo "Creating symbolic link in sites-enabled..."
sudo ln -sf /etc/nginx/sites-available/bazaar /etc/nginx/sites-enabled/
echo "✅ Symbolic link created"

# Step 3: Test Nginx configuration
echo "Testing Nginx configuration..."
sudo nginx -t
echo "✅ Nginx configuration test passed"

# Step 4: Reload Nginx
echo "Reloading Nginx..."
sudo systemctl reload nginx
echo "✅ Nginx reloaded"

# Step 5: Reload PHP-FPM
echo "Reloading PHP 8.3 FPM..."
sudo systemctl reload php8.3-fpm
echo "✅ PHP 8.3 FPM reloaded"

# Step 6: Update /etc/hosts
echo "Updating /etc/hosts..."
if ! grep -q "bazaar.local" /etc/hosts; then
    sudo sed -i '1s/^/127.0.0.1 bazaar.local\n/' /etc/hosts
    echo "✅ Added bazaar.local to /etc/hosts"
else
    echo "ℹ️ bazaar.local already exists in /etc/hosts"
fi

echo ""
echo "🎉 All operations completed successfully!"
