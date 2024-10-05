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
            $input = json_decode(file_get_contents('php://input'), true);
            $this->__instanceUser->setUserName($input["username"]);
            // $this->viewData(!empty($this->__instanceModel->checkUserExist($this->__instanceUser)));
            // die();
            if (!empty($this->__instanceModel->checkUserExist($this->__instanceUser))) {
                $this->FactoryMessage("error", "User name already exist");
                $this->view('register');
            } else {
                $this->__instanceUser->setPassword($input["password"]);
                $this->__instanceUser->setFirstName($input['firstname']);
                $this->__instanceUser->setLastName($input['lastname']);
                $this->__instanceUser->setDob($input['dob']);
                $this->__instanceUser->setPhone($input['phone']);
                $this->__instanceUser->setAddress($input['address']);
                $this->__instanceUser->setBuyerImage($input['image']);
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
            $input = json_decode(file_get_contents('php://input'), true);
            $this->__instanceUser->setUserName($input["username"]);
            $this->__instanceUser->setPassword($input["password"]);
            $data = $this->__instanceModel->checkUserExist($this->__instanceUser);

            if ($data != null && $data["buyerId"] != null) {
                $_SESSION["username"] = $this->__instanceUser->getUserName();
                $this->FactoryMessage("success", "Login successfully", $data);
                // $this->view('login');
                echo "exist";
            } else {
                $this->FactoryMessage("Error", "Login Failed", $data);
                // $this->view("login");
            }
        }
    }
    public function logout()
    {
        if (isset($_SESSION['username'])) {
            $_SESSION['username'] = null;
            session_destroy();
            $this->FactoryMessage("Info", "logout success fully");
            // $this->view('login');
        } else {
            // $this->view('login');
            $this->FactoryMessage("Info", "not login yet to logout");
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
                // $_SESSION["data"] = $aUserData;
                $this->FactoryMessage("info", "Get User Info Successfully", $aUserData);
                // $this->viewData($_SESSION);
            } else {
                $this->FactoryMessage("info", "User data not exist");
            }
        } else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
        }
    }
}
