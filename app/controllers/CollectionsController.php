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
        $this->FactoryMessage("info", "This is products obj", $products);
    }

    public function skincare()
    {
        $inputs = json_decode(file_get_contents('php://input'), true);
        $allowed_keys = ['max_price', 'min_price', 'order_by', 'offset'];
        foreach ($allowed_keys as $key) {
            if (!empty($inputs[$key])) {
                ${$key} = $inputs[$key];
            }
        }
        $data = $this->__instanceModel->getCollectionProducts("Skincare", order_by: "price");
        $this->viewData($data);
    }
}
