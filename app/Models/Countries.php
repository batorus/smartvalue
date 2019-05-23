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
    
    public function findRecordById(int $id): array{
        
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

       $fetch = $stmt->fetch(\PDO::FETCH_ASSOC);
       
       //fetch returns FALSE in the case that a record is not found
       if(!$fetch)
         return array();

      return $fetch;
    }
    
    public function findRecordByCountryCode(string $code): array{
        
        $query = 'SELECT *
                FROM '. $this->table . ' lc
                WHERE
                  lc.code LIKE :code
                LIMIT 0,1';
        
//        $stmt = $db->prepare("SELECT * FROM tbl_name WHERE title LIKE :needle");
//        $needle = '%somestring%';
//        $stmt->bindValue(':needle', $needle, PDO::PARAM_STR);
//        $stmt->execute();
//        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        try{           
            $stmt = $this->conn->prepare($query);
            
        }catch(\PDOException $e){
             throw new \PDOException($e->getMessage());
        }
        
        $code = "%$code%";
        if($stmt->bindParam(":code", $code, \PDO::PARAM_STR) === false)
            throw new \PDOException("Unable to bind the parameter!");
        
        
       if($stmt->execute() === false)
            throw new \PDOException("Unable to execute query!");

       $fetch = $stmt->fetch(\PDO::FETCH_ASSOC);
       
       //fetch returns FALSE in the case that a record is not found
       if(!$fetch)
         return array();

      return $fetch;
    }
    
}
