#!/usr/bin/env bash

set -e  # Exit immediately if a command exits with a non-zero status

echo "🚀 Starting full project setup..."

# 1. Install PHP dependencies for Bedrock
echo "📦 Installing Composer dependencies for Bedrock..."
composer install

# 2. Go to Sage theme directory
THEME_PATH="web/app/themes/theme"

if [ ! -d "$THEME_PATH" ]; then
  echo "❌ Theme directory not found at $THEME_PATH"
  echo "👉 Update THEME_PATH in setup.sh to match your theme folder."
  exit 1
fi

cd "$THEME_PATH"

# 3. Install PHP dependencies for Sage theme
echo "📦 Installing Composer dependencies for Sage theme..."
composer install

# 4. Install Node dependencies for Sage theme
if command -v npm >/dev/null 2>&1; then
  echo "📦 Installing NPM dependencies for Sage theme..."
  npm install
else
  echo "❌ npm not found. Please install Node.js first."
  exit 1
fi

# 5. Optional: build assets
if [ "$1" == "--build" ]; then
  echo "⚡ Building frontend assets..."
  npm run build
else
  echo "ℹ️ Skipping build. Run './setup.sh --build' to build assets."
fi

echo "✅ Setup complete!"
echo ""
echo "👉 Next steps:"
echo "   - Set up your .env file"
echo "   - Point your web server to the /web directory"
echo "   - Run 'npm run dev' inside the theme for development"