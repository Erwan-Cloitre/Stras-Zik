<?php

namespace App\Model;

class CartManager extends AbstractManager
{
    protected const TABLE = 'cart';
    protected const TABLE2 = 'cart_items';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectCart()
    {
        return $this->pdo->query(
            'SELECT users.firstname, users.lastname, cart.nb_items, cart.total, cart.date, 
            cart.subtotal, cart.shipping_fee, cart.quantity_items, cart.id
            FROM cart
            JOIN users ON cart.id_user=users.id'
        )->fetchAll();
    }

    public function selectCartItems($id)
    {
        return $this->pdo->query(
            'SELECT shop.title, cart_items.quantity, cart_items.price, cart_items.total_row
            FROM cart_items
            JOIN shop ON cart_items.product_id=shop.id
             WHERE cart_items.cart_id =' . $id
        )->fetchAll();
    }

    public function insertCart($cart)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            "(`nb_items`, `total` ,`id_user`, `subtotal`, `shipping_fee`, `quantity_items`) 
            VALUES(:nb_items, :total ,:id_user, :subtotal, :shipping_fee, :quantity_items) ");
        $statement->bindValue(':nb_items', $cart['nb_items'], \PDO::PARAM_INT);
        $statement->bindValue(':total', $cart['total'], \PDO::PARAM_INT);
        $statement->bindValue(':id_user', $cart['id_user'], \PDO::PARAM_INT);
        $statement->bindValue(':subtotal', $cart['subtotal'], \PDO::PARAM_INT);
        $statement->bindValue(':shipping_fee', $cart['shipping_fee'], \PDO::PARAM_INT);
        $statement->bindValue(':quantity_items', $cart['quantity_items'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function insertItemsCart($product)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE2 .
            " (`product_id` ,`quantity`, `price`, `total_row`, `cart_id`) 
            VALUES (:product_id, :quantity, :price, :total_row, :cart_id)"
        );
        $statement->bindValue('product_id', $product['product_id'], \PDO::PARAM_INT);
        $statement->bindValue('quantity', $product['quantity'], \PDO::PARAM_INT);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('total_row', $product['total_row'], \PDO::PARAM_INT);
        $statement->bindValue('cart_id', $product['cart_id'], \PDO::PARAM_INT);
        $statement->execute();
    }
}
