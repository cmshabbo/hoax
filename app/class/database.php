<?php
require_once('conn.php');

class Database{

    static $dbh;
    static $queryCount = 0;

    public function __construct() {
        self::$dbh = Conn::getConnection();
       //  var_dump(self::$dbh);
    }

    public static function executeQuery($query, $parameters = array()) {
        try {
            $statement = self::$dbh->prepare($query);
            $statement->execute($parameters);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetchAll();
            self::$queryCount += 1;
            return $result;
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
	
    public static function executeInsert($query, $parameters = array()) {
        try {
            $statement = self::$dbh->prepare($query);
            $statement->execute($parameters);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->closeCursor();
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
	
	public static function executeQueryBind($query, $id, $premiereEntree, $messagesParPage) {
		try {
			$statement = self::$dbh->prepare($query);
			$statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
			$statement->bindValue(':premiereEntree', (int)$premiereEntree, PDO::PARAM_INT);
			$statement->bindValue(':page_value', (int)$messagesParPage, PDO::PARAM_INT);
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$result = $statement->fetchAll();
			self::$queryCount += 1;
			return $result;
		} catch(Exception $e) {
			die($e->getMessage());
		}
	}
	
}