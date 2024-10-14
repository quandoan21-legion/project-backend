<?php
class ProductController extends ValidateController
{

    private $__instance_model, $__conn, $__product_id, $__product_name, $__price, $__quantity_in_stock, $__main_category, $__sub_category, $__date_listed = null, $__product_images;
    public function __construct($conn)
    {
        $this->__conn = $conn;
    }


    public function set_product_id($id)
    {
        $this->__product_id = $id;
        return $this->get_product_id();
    }

    public function get_product_id()
    {
        if ($this->__product_id != null) {
            return $this->__product_id;
        }
        return null;
    }

    public function set_product_name($name)
    {
        $this->__product_name = $name;
        return $this->get_product_name();
    }

    public function get_product_name()
    {
        if ($this->__product_name != null) {
            return $this->__product_name;
        }
        return null;
    }
    public function set_price($price)
    {
        if ($this->validate('price', $price) != null) {
            $this->__price = $price;
            return $this->get_price();
        }
    }

    public function get_price()
    {
        if ($this->__price != null) {
            return $this->__price;
        }
        return null;
    }

    public function set_quantity_in_stock($qty)
    {
        if ($this->validate('qty', $qty) != null) {
            $this->__quantity_in_stock = $qty;
            return $this->get_quantity_in_stock();
        }
        return null;
    }

    public function get_quantity_in_stock()
    {
        if ($this->__quantity_in_stock != null) {
            return $this->__quantity_in_stock;
        }
        return null;
    }

    public function set_main_category($category)
    {
        if ($this->validate('name', $category) != null) {
            $this->__main_category = $category;
            return $this->get_main_category();
        }
        return null;
    }


    public function get_main_category()
    {
        if ($this->__main_category != null) {
            return $this->__main_category;
        }
        return null;
    }


    public function set_sub_category($category)
    {
        if ($this->validate('name', $category) != null) {
            $this->__sub_category = $category;
            return $this->get_sub_category();
        }
        return null;
    }


    public function get_sub_category()
    {
        if ($this->__sub_category != null) {
            return $this->__sub_category;
        }
        return null;
    }

    public function set_date_listed($date)
    {
        if ($this->validate('timestamp', $date) != null) {
            $this->__date_listed = $date;
            return $this->get_date_listed();
        }
        return null;
    }

    public function get_date_listed()
    {
        if ($this->__date_listed != null) {
            return $this->__date_listed;
        }
        return null;
    }
    public function set_product_images($images)
    {
        $this->__product_images = $images;
        return $this->get_product_images();
    }
    public function get_product_images()
    {
        return $this->__product_images;
    }
}
