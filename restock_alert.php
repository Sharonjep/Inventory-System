<?php



// function to check inventory levels and trigger restock alerts
function checkInventoryLevels($conn) {
    $lowInventoryThreshold = 10;

    // Query database for products with low inventory
    $lowInventoryProducts = getLowInventoryProducts($conn, $lowInventoryThreshold);

    foreach ($lowInventoryProducts as $product) {
        $quantityNeeded = calculateQuantityNeeded($product);
        generateRestockAlert($conn, $product['id'], $quantityNeeded);
    }
}

// function to get products with low inventory
function getLowInventoryProducts($conn, $threshold) {
    $lowInventoryProducts = array();

    // Perform database query to get products with low inventory
    $query = "SELECT id, name, quantity FROM products WHERE quantity < ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $threshold);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $lowInventoryProducts[] = $row;
    }

    $stmt->close();

    return $lowInventoryProducts;
}

// function to calculate quantity needed for restock
function calculateQuantityNeeded($product) {
    $fixedQuantity = 20;
    return $fixedQuantity;
}

// function to generate restock alert
function generateRestockAlert($conn, $productId, $quantityNeeded) {
    // Insert a record into the restock_alerts table
    insertRestockAlert($conn, $productId, $quantityNeeded);
    // Optionally, send notifications to relevant personnel
    sendRestockAlertNotification($productId, $quantityNeeded);
}

// function to insert a restock alert into the database
function insertRestockAlert($conn, $productId, $quantityNeeded) {
    $query = "INSERT INTO restock_alerts (product_id, quantity_needed) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $productId, $quantityNeeded);
    $stmt->execute();
    $stmt->close();
}

// function to send restock alert notifications
function sendRestockAlertNotification($productId, $quantityNeeded) {
    $productDetails = getProductDetails($productId);
    $phoneNumber = '+14157022788'; 
    $message = "Restock needed for {$productDetails['name']}. Quantity needed: {$quantityNeeded}";

    sendSmsNotification($phoneNumber, $message);
}


// Call the checkInventoryLevels function to initiate the process
checkInventoryLevels($conn);

?>
