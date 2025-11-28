# Create necessary directories
$directories = @(
    "app\Http\Controllers\Admin",
    "app\Http\Controllers\Api\V1",
    "app\Http\Controllers\Auth",
    "app\Http\Controllers\Games",
    "app\Services",
    "app\Http\Requests",
    "app\Http\Resources",
    "app\Policies",
    "app\Events",
    "app\Listeners",
    "app\Models\Traits",
    "app\Models\Scopes",
    "resources\views\admin",
    "resources\views\auth",
    "resources\views\components",
    "resources\views\layouts",
    "resources\views\partials",
    "resources\views\patrol-reports",
    "tests\Feature\Http\Controllers",
    "tests\Unit\Models"
)

foreach ($dir in $directories) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Force -Path $dir | Out-Null
        Write-Host "Created directory: $dir"
    } else {
        Write-Host "Directory already exists: $dir"
    }
}

# Move controllers to their respective directories
$moves = @{
    "app\Http\Controllers\AdminController.php" = "app\Http\Controllers\Admin\"
    "app\Http\Controllers\PatrolReportController.php" = "app\Http\Controllers\Admin\"
    "app\Http\Controllers\PatrollerController.php" = "app\Http\Controllers\Admin\"
    "app\Http\Controllers\UserVerificationController.php" = "app\Http\Controllers\Admin\"
    "app\Http\Controllers\AuthController.php" = "app\Http\Controllers\Auth\"
    "app\Http\Controllers\GameActivityController.php" = "app\Http\Controllers\Games\"
    "app\Http\Controllers\GamesController.php" = "app\Http\Controllers\Games\"
}

foreach ($move in $moves.GetEnumerator()) {
    $source = $move.Key
    $destination = $move.Value
    
    if (Test-Path $source) {
        Move-Item -Path $source -Destination $destination -Force
        Write-Host "Moved $source to $destination"
    } else {
        Write-Host "Source file not found: $source"
    }
}

Write-Host "Reorganization complete!"
