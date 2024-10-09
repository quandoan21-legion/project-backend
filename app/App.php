<?php
class App
{
    private $__conn, $__controller, $__action, $__params, $__instanceController;
    public function __construct($conn)
    {
        $this->__conn = $conn;
        $this->__controller = "CollectionsController";
        $this->__action = "all";
        $this->__params = [];
        $this->handleURL();
    }

    private function getURI()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $uri = str_replace("/project/", "", $uri);
        if ($uri != "") {
            return $uri;
        }
        return null;
    }
    private function handleURL()
    {
        $uri =  $this->getURI();
        if ($uri != null) {

            $explodedURI = explode("/", $uri);
            if (!empty($explodedURI[0])) {
                $this->__controller = ucfirst($explodedURI[0]) . "Controller";
                unset($explodedURI[0]);
                $explodedURI = array_values(array_filter($explodedURI));
            }
            if (!empty($explodedURI[0])) {
                $this->__action = ucfirst($explodedURI[0]);
                unset($explodedURI[0]);
                $explodedURI = array_values(array_filter($explodedURI));
            }
            if (!empty($explodedURI[0])) {
                // var_dump($explodedURI);
                // die();
                $this->__params[0] = ucfirst($explodedURI[0]);
                unset($explodedURI[0]);
            }
            $filePath = "./app/controllers/" . $this->__controller . ".php";
            if (file_exists($filePath)) {
                include_once $filePath;
                if (class_exists($this->__controller)) {

                    $this->__instanceController = new $this->__controller($this->__conn);
                    if (method_exists($this->__instanceController, $this->__action)) {
                        // var_dump($this->__params);
                        // die();
                        call_user_func_array([$this->__instanceController, $this->__action],  $this->__params);
                    } else {
                        echo "method not exist";
                    }
                }
            } else {
                echo "File Doesn't exist";
            }
        } else {
            $file = "./app/controllers/" . $this->__controller . ".php";
            include_once $file;
            $this->__instanceController = new $this->__controller($this->__conn);
            call_user_func_array([$this->__instanceController, $this->__action],  $this->__params);
        }
    }
}
