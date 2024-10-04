<?php
class CollectionsController extends BaseController
{
    private $__instanceModel;
    public function __construct($conn)
    {
        $this->__instanceModel = $this->initModel("CollectionsModel", $conn);
    }

    public function all()
    {
        $products = $this->__instanceModel->getAllProducts();
        echo json_encode($products);
        $this->view("AllProduct");
    }
}
