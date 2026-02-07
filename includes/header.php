<?php if (!isset($siteName)) { $siteName = "Supplement Store"; } ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($siteName); ?></title>
</head>
<body>
  <h1><?php echo htmlspecialchars($siteName); ?></h1>
  <nav>
    <a href="index.php">Home</a> |
    <a href="catalog.php">Catalog</a> |
    <a href="cart.php">Cart</a>
  </nav>
  <hr />
