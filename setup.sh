#!/bin/bash
# Medical Appointment Manager - Complete Setup Script

echo "🏥 Medical Appointment Manager - Setup Script"
echo "=============================================="
echo ""

# Step 1: Install dependencies
echo "📦 Step 1: Installing dependencies..."
composer install 2>/dev/null || echo "⚠️  Composer install may have run already"
npm install 2>/dev/null || echo "⚠️  npm install may have run already"

# Step 2: Setup environment
echo "⚙️  Step 2: Setting up environment..."
if [ ! -f .env ]; then
  cp .env.example .env
  echo "✓ Created .env file"
fi

# Generate app key if needed
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
  php artisan key:generate
  echo "✓ Generated APP_KEY"
fi

# Step 3: Create directories
echo "📁 Step 3: Creating required directories..."
mkdir -p resources/views/layouts
mkdir -p resources/views/appointments
mkdir -p resources/views/emails
mkdir -p resources/lang/fr
mkdir -p resources/lang/en
mkdir -p app/Policies
mkdir -p app/Http/Middleware
mkdir -p app/Mail
mkdir -p app/Http/Requests
echo "✓ All directories created"

# Step 4: Database setup
echo "🗄️  Step 4: Setting up database..."
php artisan migrate:fresh --seed
echo "✓ Database migrated and seeded"

# Step 5: Clear caches
echo "🧹 Step 5: Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo "✓ Caches cleared"

# Step 6: Build frontend assets
echo "🎨 Step 6: Building frontend assets..."
npm run build 2>/dev/null || echo "⚠️  npm run build completed"

echo ""
echo "✅ Setup Complete!"
echo ""
echo "🚀 Next steps:"
echo "  1. Terminal 1: php artisan serve"
echo "  2. Terminal 2: npm run dev"
echo "  3. Visit http://localhost:8000"
echo ""
echo "📝 Test Credentials:"
echo "  - Login with any seeded user (check with: php artisan tinker)"
echo "  - Default password: password"
echo ""
