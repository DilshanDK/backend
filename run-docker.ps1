$env:APP_ENV = "production"
$env:APP_DEBUG = "false"
$env:APP_KEY = "base64:qNtkrXMnXl/RqZclW6v5r0zdSf2jb1XQN92U9mxWUhU="
$env:DB_CONNECTION = "mongodb"
$env:DB_DSN = "mongodb+srv://dilshan:kpk7MEaEB6S2m5ii@cluster0.vvulqgm.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"
$env:DB_DATABASE = "laravel"
$env:APP_URL = "http://localhost:8000"

Write-Host "🐳 Building Docker image..." -ForegroundColor Green
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Green

docker run -p 8000:8000 `
  -e APP_ENV=$env:APP_ENV `
  -e APP_DEBUG=$env:APP_DEBUG `
  -e APP_KEY=$env:APP_KEY `
  -e DB_CONNECTION=$env:DB_CONNECTION `
  -e DB_DSN=$env:DB_DSN `
  -e DB_DATABASE=$env:DB_DATABASE `
  -e APP_URL=$env:APP_URL `
  todo-app-backend

Write-Host ""
Write-Host "✅ Container Started Successfully!" -ForegroundColor Green
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Green
Write-Host "🌐 API URL: http://localhost:8000/api/todos" -ForegroundColor Cyan
Write-Host "📊 Database: MongoDB Atlas (Connected)" -ForegroundColor Cyan
Write-Host "🚀 Status: Running and Ready!" -ForegroundColor Green
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Green
Write-Host ""
Write-Host "Press Ctrl+C to stop" -ForegroundColor Yellow
