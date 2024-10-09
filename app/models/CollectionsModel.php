<?php
class CollectionsModel extends BaseController
{
    private $__conn;
    public function __construct($conn)
    {
        $this->__conn = $conn;
    }

    public function getAllProducts($limit = 10, $offset = 0)
    {
        $startFrom = $offset * $limit;
        $sql  = "SELECT * FROM Products LIMIT :limit OFFSET :offset";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $startFrom, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCollectionProducts($category, $max_price = null, $min_price = null, $order_by = null, $offset = null, $desc = true)
    {
        $sql = "SELECT * FROM Products WHERE main_category = :main_category";
        $params = [];
        if ($max_price !== null && $min_price !== null) {
            $sql = $sql . " AND price BETWEEN :min_price AND :max_price";
            $params["min_price"] = $min_price;
            $params["max_price"] = $max_price;
        }

        if ($order_by !== null) {
            $allowed_order_columns = ['price', 'product_name', 'date_listed']; // Add allowed columns here
            if (in_array($order_by, $allowed_order_columns)) {
                $sql .= " ORDER BY $order_by"; // Directly concatenate after validation
            }
        }

        if ($offset !== null) {
            $sql .= " OFFSET :offset";
            $params["offset"] = $offset;
        }

        if ($desc == true) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        $stmt  = $this->__conn->prepare($sql);
        $stmt->bindValue(":main_category", $category, PDO::PARAM_STR);

        foreach ($params as $param => $value) {
            $stmt->bindValue(":$param", $value, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
