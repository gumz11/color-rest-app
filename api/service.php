<?php
/*

color-rest-app
Color REST API service

*/

new ColorService();

class ColorService
{
    //ADJUST CONNECTION INFO FOR TESTING
    const DB_HOST = 'localhost';
    const DB_NAME = 'color_rest_app';
    const DB_USER = 'root';
    const DB_PASS = '';

    private $database;

    public function __construct()
    {
        $this->dbConnect();
        $this->requestHandle();
    }
    
    private function dbConnect()
    {
        try {
            $this->database = new PDO("mysql:host=" . $this::DB_HOST . ";dbname=" . $this::DB_NAME, $this::DB_USER, $this::DB_PASS);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        catch (PDOException $e) {
            $this->response(0, "Unable to open database: " . $e->getMessage());
            exit();
        }
    }
    
    private function requestHandle()
    {
        $request  = $_SERVER['REQUEST_URI'];
        $method   = $_SERVER['REQUEST_METHOD'];
        $request  = explode("/", $request);
        $resource = $request[3];
        switch ($resource) {
            case 'colors':
                switch ($method) {
                    case 'PUT':
                        $id    = $request[4];
                        $color = $request[5];
                        $this->putColor($id, $color);
                        break;
                    
                    case 'GET':
                        $this->getColors();
                        break;
                    
                    default:
                        header('HTTP/1.1 405 Method Not Allowed');
                        $this->response(0, 'Method not allowed.');
                        break;
                }
                
                break;
            
            default:
                $this->response(0, 'Resource not found.');
        }
    }
    
    private function response($result, $values = null)
    {
        $json;
        if ($result) {
            $json = $values;
        } else {
            header('HTTP/1.1 404');
            $json = array(
                'error' => '1',
                'message' => $values
            );
        }
        
        print json_encode($json);
    }
    
    // PUT /colors/{id}/{color}
    private function putColor($id, $color)
    {
        try {
            $prepare = $this->database->prepare('UPDATE colors SET color = ? where id = ?');
            $result  = $prepare->execute(array(
                $color,
                $id
            ));
            if ($result) {
                return $this->response(1, array(
                    'success' => $id
                ));
            }
        }
        
        catch (PDOException $e) {
            return $this->response(0, $e);
        }
        
        return $this->response(0);
    }
    
    // GET /colors/
    private function getColors()
    {
        $colors = null;
        try {
            if ($this->database) {
                $result = $this->database->query('select * from colors');
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $colors[] = array(
                        'id' => $row['id'],
                        'color' => $row['color']
                    );
                }
            }
            
            if ($colors) {
                return $this->response(1, $colors);
            }
        }
        
        catch (PDOException $e) {
            return $this->response(0, $e);
        }
        
        return $this->response(0, 'Something went wrong.');
    }
}

?>