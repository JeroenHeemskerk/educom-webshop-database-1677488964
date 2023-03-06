<?php

function showContent($data)
{
    var_dump($_SESSION);
    echo '<div class="products">';
    if (($data['shoppingcartproducts'])) {
        foreach ($data['shoppingcartproducts'] as $product) {
            echo '<div class="product"><a href="index.php?page=detail&id=' . $product['productId'] . '">';
            echo '<h2>' . $product['name'] . '</h2>';
            echo '<img src="Images/' . $product['filename_img'] . '" alt="' . $product['name'] . '" width="60" height="80"></a>' . PHP_EOL;
            echo '<div class="text">';
            echo '<div class="amount">';
            echo '<p> Quantity:&nbsp;</p>';
            addAction('shoppingcart', 'addToShoppingcart', "+", $product['productId'], $product['name'], 1);
            echo $product['quantity'];
            addAction('shoppingcart', 'addToShoppingcart', "-", $product['productId'], $product['name'], -1);
            echo '</div>' . PHP_EOL;
            echo '<div class="subtotal"><p> Subtotal: &euro;' . $product['subtotal'] . '</p></div><br>';
            echo '<div class="removebutton">';
            addAction('shoppingcart', 'removeFromShoppingcart', "Remove from shoppingcart", $product['productId'], $product['name'], 0);
            echo '</div></div></div>';
        }
        echo '<div class="total">';
        echo '<p>Totaal: &euro;' . $data['total'] .  '</p>';
        addAction('home', 'order', "Order");
        echo '</div>';
    } else {
        echo '<p>Your shopping cart is empty</p>';
    }
    echo '</div>';
}
