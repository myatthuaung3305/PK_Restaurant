param(
  [string]$Message = "Update Pandan Kitchen"
)

$repoRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
Set-Location $repoRoot
$ErrorActionPreference = "Stop"

Write-Host "Running Laravel tests..."
php artisan test

if (-not (git status --short)) {
  Write-Host "No changes to commit."
  exit 0
}

Write-Host "Committing and pushing to GitHub..."
git add .
git commit -m $Message
git push origin main

Write-Host "Done."
