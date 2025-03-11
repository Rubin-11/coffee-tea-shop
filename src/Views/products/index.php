<!DOCTYPE html>
<html>

<head>
    <title>Кофе и чай</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <!-- <?php include __DIR__ . '/../partials/header.php'; ?> -->

    <div class="products-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p class="price"><?= number_format($product['price'], 2) ?> ₽</p>
                <button class="add-to-cart" data-id="<?= $product['id'] ?>">В корзину</button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- <?php include __DIR__ . '/../partials/footer.php'; ?> -->

    <script src="/assets/js/cart.js"></script>
</body>

</html>