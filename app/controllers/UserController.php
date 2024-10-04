<?php
include_once "BuyerController.php";
class UserController extends BaseController
{
    private $__instanceUser, $__instanceModel;
    public function __construct($conn)
    {
        session_start();
        $this->__instanceModel = $this->initModel('UserModel', $conn);
        $this->__instanceUser = new BuyerController();
    }


    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $this->view('register');
        } else {
            $this->__instanceUser->setUserName($_REQUEST["username"]);
            // $this->viewData(!empty($this->__instanceModel->checkUserExist($this->__instanceUser)));
            // die();
            if (!empty($this->__instanceModel->checkUserExist($this->__instanceUser))) {
                $this->FactoryMessage("error", "User name already exist");
                $this->view('register');
            } else {
                $this->__instanceUser->setPassword($_REQUEST["password"]);
                $this->__instanceUser->setFirstName($_REQUEST['firstname']);
                $this->__instanceUser->setLastName($_REQUEST['lastname']);
                $this->__instanceUser->setDob($_REQUEST['dob']);
                $this->__instanceUser->setPhone($_REQUEST['phone']);
                $this->__instanceUser->setAddress($_REQUEST['address']);
                $this->__instanceUser->setBuyerImage($_REQUEST['image']);
                $this->__instanceModel->createNewUser($this->__instanceUser);
                // $this->view('register');
                $this->FactoryMessage("success", "Account Created");
                $this->view('login');
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->view("login");
        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $this->__instanceUser->setUserName($_REQUEST["username"]);
            $this->__instanceUser->setPassword($_REQUEST["password"]);
            $data = $this->__instanceModel->checkUserExist($this->__instanceUser);

            if ($data != null && $data["buyerId"] != null) {
                $_SESSION["username"] = $this->__instanceUser->getUserName();
                $this->FactoryMessage("success", "Login successfully", $data);
                $this->view('login');
                echo "exist";
            } else {
                $this->FactoryMessage("Error", "Login Failed", $data);
                $this->view("login");
            }
        }
    }
    public function logout()
    {
        if (isset($_SESSION['username'])) {
            $_SESSION['username'] = null;
            session_destroy();
            echo "logout success fully";
            $this->view('login');
        } else {
            $this->view('login');
            echo "not login yet to logout";
        }
    }

    public function profile($data)
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $data = str_replace("?", "", $data);
            $data = array_filter(array_values(explode("&", $data)));
            $result = [];
            foreach ($data as $item) {
                list($key, $value) = explode('=', $item, 2);
                $key = trim($key);
                $value = trim($value);
                $result[$key] = $value;
            }
            $this->__instanceUser->setID($result['user_id']);
            $aUserData = $this->__instanceModel->getUserData($this->__instanceUser);
            if ($aUserData != false) {
                $_SESSION["data"] = $aUserData;
                $this->viewData($_SESSION);
                echo "User data above";
            } else {
                echo "User data not exist";
            }
        } else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
        }
    }
}
