<?php
class UserModel extends BaseController
{
    private $__conn;
    public function __construct($conn)
    {
        $this->__conn = $conn;
    }

    public function createNewUser($oUser)
    {
        // $this->viewData($oUser);
        $username   = $oUser->getUsername();
        $password   = $oUser->getPassword();
        $firstName  = $oUser->getFirstName();
        $lastName   = $oUser->getLastName();
        $dob        = $oUser->getDob();
        $phone      = $oUser->getPhone();
        $address    = $oUser->getAddress();
        $buyerImage = $oUser->getBuyerImage();
        try {
            $sql = "INSERT INTO Buyers (
                userName,
                password,
                firstName,
                lastName,
                dob,
                phone,
                address,
                BuyerImage
            ) VALUE (
                :username,
                :password,
                :firstName,
                :lastName,
                :dob,
                :phone,
                :address,
                :BuyerImage
            )";

            $stmt = $this->__conn->prepare($sql);
            $stmt->bindParam('username', $username, PDO::PARAM_STR);
            $stmt->bindParam('password', $password, PDO::PARAM_STR);
            $stmt->bindParam('firstName', $firstName, PDO::PARAM_STR);
            $stmt->bindParam('lastName', $lastName, PDO::PARAM_STR);
            $stmt->bindParam('dob', $dob, PDO::PARAM_STR);
            $stmt->bindParam('phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam('address', $address, PDO::PARAM_STR);
            $stmt->bindParam('BuyerImage', $buyerImage, PDO::PARAM_LOB);
            $stmt->execute();
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function checkUserExist($oUser)
    {
        $username = $oUser->getUserName();
        try {
            $sql  = "SELECT password FROM Buyers WHERE userName = :username";
            $stmt = $this->__conn->prepare($sql);
            $stmt->bindParam('username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                $password = $oUser->getPassword();
                if ($password !== null) {

                    $receivedPassword = $data['password'];
                    $this->viewData($data);
                    return password_verify($password, $receivedPassword) ? 1 : null;
                }
                return 1;
            }
            return null;
        } catch (Exception $e) {
            echo "Error checking user: " . $e->getMessage();
        }
    }

    public function getUseData($oUser) {}
}
