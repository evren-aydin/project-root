<?php

declare(strict_types=1);

namespace Services;

use PDO;
use PDOException;

class DataLoad
{
private $db ;
public function __construct($db){
           $this->db = $db;

    }

    public function loadUsers(){
        $json = file_get_contents('https://jsonplaceholder.typicode.com/users');
        $users = json_decode($json, true);

        $sql="INSERT INTO users (id,name,username,email,street,suite,city,zipcode,geo_lat,geo_lng,phone,website,company_name,company_catchPhrase,company_bs)
        VALUES(:id, :name, :username, :email, :street, :suite, :city, :zipcode, :geo_lat, :geo_lng, :phone, :website, :company_name, :company_catchPhrase, :company_bs)
        ";

        $stmt = $this->db->prepare($sql);
        foreach($users as $user){
            $stmt->execute([
                ':id'=> $user['id'],
                ':name' => $user['name'],
                ':username' => $user['username'],
                ':email' => $user['email'],
                ':street' => $user['address']['street'],
                ':suite' => $user['address']['suite'],
                ':city' => $user['address']['city'],
                ':zipcode' => $user['address']['zipcode'],
                ':geo_lat' => $user['address']['geo']['lat'],
                ':geo_lng' => $user['address']['geo']['lng'],
                ':phone' => $user['phone'],
                ':website' => $user['website'],
                ':company_name' => $user['company']['name'],
                ':company_catchPhrase' => $user['company']['catchPhrase'],
                ':company_bs' => $user['company']['bs']
            ]);
    }
    
}
 public function loadPosts() {
        
        $json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $posts = json_decode($json, true);  

        
        $sql = "INSERT INTO posts (id, userId, title, body) 
                VALUES (:id, :userId, :title, :body)";

        $stmt = $this->db->prepare($sql);

        foreach ($posts as $post) {
            $stmt->execute([
                ':id' => $post['id'],
                ':userId' => $post['userId'],
                ':title' => $post['title'],
                ':body' => $post['body']
            ]);
        }
    }
}