#!/bin/bash

# Laravel Scheduler Setup Script for FitLive Daily Sessions
# Run this script on your production server

echo "🚀 Setting up Laravel Scheduler for Daily FitLive Sessions"
echo "=================================================="

# Get current directory
PROJECT_PATH=$(pwd)
echo "📁 Project path: $PROJECT_PATH"

# Get PHP path
PHP_PATH=$(which php)
echo "🐘 PHP path: $PHP_PATH"

# Create crontab entry
CRON_ENTRY="* * * * * cd $PROJECT_PATH && $PHP_PATH artisan schedule:run >> /dev/null 2>&1"

echo ""
echo "📝 Crontab entry to add:"
echo "$CRON_ENTRY"
echo ""

# Check if cron is running
if systemctl is-active --quiet cron; then
    echo "✅ Cron service is running"
else
    echo "❌ Cron service is not running"
    echo "   Start it with: sudo systemctl start cron"
fi

echo ""
echo "🔧 To set up the crontab:"
echo "1. Run: crontab -e"
echo "2. Add this line: $CRON_ENTRY"
echo "3. Save and exit"
echo ""
echo "🧪 To test:"
echo "1. Run: php artisan schedule:list"
echo "2. Run: php artisan schedule:run"
echo "3. Check: php artisan fitlive:create-daily-sessions --dry-run"
echo ""
echo "📊 To verify it's working:"
echo "1. Check logs: tail -f storage/logs/laravel.log"
echo "2. Check sessions: php artisan tinker"
echo "   >>> App\Models\FitLiveSession::where('session_type', 'daily')->whereDate('created_at', today())->count()"
