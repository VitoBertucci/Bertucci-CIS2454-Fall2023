<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <style>
        .receipt {
            border: 1px solid #000;
            padding: 10px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h1>Order Summary</h1>
    <?php
    // Define pizza size and topping prices
    $pizza_prices = [
        "small" => 5.00,
        "medium" => 7.00,
        "large" => 9.00
    ];
    $topping_price = [
        "small" => 0.50,
        "medium" => 1.00,
        "large" => 1.50
    ];

    // Retrieve user inputs
    if (isset($_POST['pizza-size']) && isset($_POST['toppings'])) {
        $size = $_POST['pizza-size'];
        $selected_toppings = $_POST['toppings'];

        // Calculate the total cost
        $total_cost = $pizza_prices[$size];

        // Display the pizza size
            echo "<div class='item'>";
            echo "Pizza ($size) - $" . number_format($pizza_prices[$size], 2);
            echo "</div>";

            // Display selected toppings
            foreach ($selected_toppings as $topping) {
                $total_cost += $topping_price[$size];
                echo "<div class='item'>";
                echo "$topping - $" . number_format($topping_price[$size], 2);
                echo "</div>";
            }

            // Display the total cost
            echo "<div class='item'>";
            echo "_____________________ <br>";
            echo "Total - $" . number_format($total_cost, 2);
            echo "</div>";
    } else {
        echo "<p>Please select a pizza size and at least one topping.</p>";
    }
    ?>
</body>
</html>
