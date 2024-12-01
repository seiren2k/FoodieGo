<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order {
    private $db;
    
    public function __construct() {
        // Get database connection using singleton pattern
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }
    
    public function order() {
 
        require_once 'application/views/order/order.php';
    }
    
    public function details($id) {
        $id = mysqli_real_escape_string($this->db, $id);
        $sql = "SELECT f.*, c.title as category_name 
        FROM food f 
        LEFT JOIN category c ON f.category_id = c.id 
        WHERE f.id='$id' AND f.active='Yes'";        $result = mysqli_query($this->db, $sql);
        $food_item = mysqli_fetch_assoc($result);
        
        if (!$food_item) {
            header("Location: " . SITEURL . "404");
            exit;
        }
        
        $data['food_item'] = $food_item;
        $data['siteurl'] = SITEURL;
        extract($data); // This makes variables available to the view
        require_once 'application/views/order/details.php';
    }
}
