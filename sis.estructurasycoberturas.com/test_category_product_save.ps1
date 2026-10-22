$WebSession = New-Object Microsoft.PowerShell.Commands.WebRequestSession

# Step 1: Login via acceso-local as tenant or superadmin
$loginResponse = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/acceso-local?as=tenant' -WebSession $WebSession -MaximumRedirection 5
Write-Host "Login status: "$loginResponse.StatusCode

# Step 2: Fetch products page to get CSRF token and available category ID
$prodResponse = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/admin/productos' -WebSession $WebSession
$matchToken = [regex]::Match($prodResponse.Content, 'name="csrf-token" content="([^"]+)"')
$csrfToken = $matchToken.Groups[1].Value
Write-Host "CSRF Token: "$csrfToken

$matchCat = [regex]::Match($prodResponse.Content, '<option value="(\d+)"[^>]*>Hosting</option>')
$catId = $matchCat.Groups[1].Value
Write-Host "Category Hosting ID: "$catId

# Step 3: Send POST request to create product with Category Hosting
$body = @{
    "_token" = $csrfToken
    "product_category_id" = $catId
    "name" = "Servicio de Hosting Web Premium"
    "sku" = "HOST-001"
    "description" = "<p>Alojamiento web para páginas corporativas y landing pages.</p>"
    "unit" = "UND"
    "price" = "80.00"
    "active" = "1"
}

$headers = @{
    "X-Requested-With" = "XMLHttpRequest"
    "X-App-Partial" = "1"
    "Accept" = "application/json"
}

$storeResponse = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/admin/productos' -Method POST -Body $body -WebSession $WebSession -Headers $headers

Write-Host "Store HTTP Status: "$storeResponse.StatusCode
Write-Host "Response length: "$storeResponse.Content.Length
