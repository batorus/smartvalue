<?php
namespace Smartvalue\Models;
use Smartvalue\Database\IConnection;

class Countries {
    
    private $conn;
    private $table = "locations_countries";
    
    public function __construct(IConnection $db) {     
        $this->conn = $db->getConnection();
    }
    
    // Get all countries
    public function getAllRecords(): array {
 
        $query = 'SELECT *
                FROM ' . $this->table . '
                ORDER BY id ASC';
      

        try{
            
            $stmt = $this->conn->prepare($query);
            
        }catch(\PDOException $e){
             //re-throw the exception
             throw new \PDOException($e->getMessage());
        }

        // Execute query
        if($stmt->execute() === false)
            throw new \PDOException("Unable to execute query!"); 
        
        return $stmt->fetchAll();
    }
    
    public function findRecordById(int $id): ?array{
        
        $query = 'SELECT *
                FROM '. $this->table . ' lc
                WHERE
                  lc.id = :id
                LIMIT 0,1';

        try{           
            $stmt = $this->conn->prepare($query);
            
        }catch(\PDOException $e){
             throw new \PDOException($e->getMessage());
        }
        
        if($stmt->bindParam(":id", $id) === false)
            throw new \PDOException("Unable to bind the parameter!");
        
        
       if($stmt->execute() === false)
            throw new \PDOException("Unable to execute query!");
       

       //fetch returns FALSE in the case that a record is not found
       if(!$stmt->fetch())
           return null;
       
       return $stmt->fetch();
    }
    
}
