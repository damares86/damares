<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Common
{

    public $conn;
    public $stmt;
    public $table;
    public $where;
    public $fields;
    public $id;
    public $prx;
    public $operation;
    public $origin;


    // constructor

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // error->TENERE?
    public function showError($stmt)
    {
        echo "<pre>";
        print_r($stmt->errorInfo());
        echo "</pre>";
    }


    // insert

    // $fields must be an array
    function insert($fields)
    {

        $i = 1;

        $this->fields = "";
        foreach ($fields as $item) {
            $this->fields .= "$item = :$item";
            if ($i < count($fields)) {
                $this->fields .= ", ";
            }
            $i++;
        }

        $query = "INSERT INTO " . $this->prx . $this->table . "
    SET " . $this->fields . "";


        $stmt = $this->conn->prepare($query);
        echo $query.'<br>';

        foreach ($fields as $item) {
            $stmt->bindParam(":$item", $this->$item);
            echo $item.' -> '.$this->$item.'<br>';
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function insertIntoTable($fields, $table)
    {

        $i = 1;

        $this->fields = "";
        foreach ($fields as $item) {
            $this->fields .= "$item = :$item";
            if ($i < count($fields)) {
                $this->fields .= ", ";
            }
            $i++;
        }

        $query = "INSERT INTO " . $this->prx . $table . "
    SET " . $this->fields . "";
        $stmt = $this->conn->prepare($query);
        foreach ($fields as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    // update

    // $fields must be an array
    function update($fields, $where)
    {

        $this->where = "";

        $this->fields = "";

        $i = 1;
        foreach ($fields as $item) {
            $this->fields .= "$item = :$item";
            if ($i < count($fields)) {
                $this->fields .= ", ";
            }
            $i++;
        }

        $query = "UPDATE " . $this->prx . $this->table . "
        SET " . $this->fields . " WHERE $where = :$where";

        $stmt = $this->conn->prepare($query);

        foreach ($fields as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        $stmt->bindParam(":$where", $this->$where);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // $fields must be an array
    function updateTable($fields, $where, $table)
    {

        $this->where = "";

        $this->fields = "";

        $i = 1;
        foreach ($fields as $item) {
            $this->fields .= "$item = :$item";
            if ($i < count($fields)) {
                $this->fields .= ", ";
            }
            $i++;
        }

        $query = "UPDATE " . $this->prx . $table . "
        SET " . $this->fields . " WHERE $where = :$where";


        $stmt = $this->conn->prepare($query);

        foreach ($fields as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }
        $stmt->bindParam(":$where", $this->$where);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // $fields and $where must be an array
    function updateTableMultiple($fields, $where, $table)
    {

        $this->where = "";

        $this->fields = "";

        $i = 1;
        foreach ($fields as $item) {
            $this->fields .= "$item = :$item";
            if ($i < count($fields)) {
                $this->fields .= ", ";
            }
            $i++;
        }

        $i = 1;
        foreach ($where as $item) {
            $this->where .= "$item = :$item";
            if ($i < count($where)) {
                $this->where .= " AND ";
            }
            $i++;
        }

        $query = "UPDATE " . $this->prx . $table . "
    SET " . $this->fields . " WHERE " . $this->where . "";

        $stmt = $this->conn->prepare($query);

        foreach ($fields as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        foreach ($where as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // show_all

    function showAll($orderBy)
    {
        $query = "SELECT *
    FROM " . $this->prx . $this->table . "
    ORDER BY " . $orderBy . " ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function showAllLimitDesc($orderBy, $limit)
    {
        $query = "SELECT *
    FROM " . $this->prx . $this->table . "
    ORDER BY " . $orderBy . " DESC LIMIT " . $limit . "";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }


    function showAllTable($orderBy, $table)
    {

        $query = "SELECT *
        FROM " . $this->prx . $table . "
        ORDER BY " . $orderBy . " ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // $where must be an array
    function showAllWhere($orderBy, $where)
    {

        $this->where = "";

        $i = 1;
        foreach ($where as $item) {
            $this->where .= "$item = :$item";
            if ($i < count($where)) {
                $this->where .= " AND ";
            }
            $i++;
        }

        $query = "SELECT *
        FROM " . $this->prx . $this->table . "
        WHERE " . $this->where . "
        ORDER BY " . $orderBy . " ASC";

        $stmt = $this->conn->prepare($query);
        // print_r($stmt);
        foreach ($where as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        $stmt->execute();
        return $stmt;
    }

    function showAllWhereGtLt($orderBy, $op, $where)
    {

        $this->where = "";

        $i = 1;
        foreach ($where as $item) {
            $this->where .= "$item $op :$item";
            if ($i < count($where)) {
                $this->where .= " AND ";
            }
            $i++;
        }

        $query = "SELECT *
        FROM " . $this->prx . $this->table . "
        WHERE " . $this->where . "
        ORDER BY " . $orderBy . " ASC";
        $stmt = $this->conn->prepare($query);

        foreach ($where as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        $stmt->execute();
        return $stmt;
    }

    function showAllWhereBetween($orderBy, $op1, $op2, $where)
    {

        $this->where = "";

        $i = 1;
        foreach ($where as $item) {
            $op = 'op' . $i;
            $this->where .= '' . $item . ' ' . $$op . ' :' . $item . '';
            if ($i < count($where)) {
                $this->where .= " AND ";
            }
            $i++;
        }

        $query = "SELECT *
        FROM " . $this->prx . $this->table . "
        WHERE " . $this->where . "
        ORDER BY " . $orderBy . " ASC";
        $stmt = $this->conn->prepare($query);

        foreach ($where as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        $stmt->execute();
        return $stmt;
    }

    function showAllWhereTable($orderBy, $table, $where)
    {

        $this->where = "";

        $i = 1;
        foreach ($where as $item) {
            $this->where .= "$item = :$item";
            if ($i < count($where)) {
                $this->where .= " AND ";
            }
            $i++;
        }
        $query = "SELECT *
        FROM " . $this->prx . $table . "
        WHERE " . $this->where . "
        ORDER BY " . $orderBy . " ASC";

        $stmt = $this->conn->prepare($query);

        foreach ($where as $item) {
            $stmt->bindParam(":$item", $this->$item);
        }

        $stmt->execute();

        return $stmt;
    }


    public function itemExists($item)
    {

        // query to check if email exists
        $query = "SELECT *
    FROM " . $this->prx . $this->table . "
    WHERE " . $item . " = :" . $item . "
    LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":" . $item . "", $this->$item);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        if ($num > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function countItem($item)
    {

        // query to check if email exists
        $query = "SELECT *
    FROM " . $this->prx . $this->table . "
    WHERE " . $item . " = :" . $item . "";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":" . $item . "", $this->$item);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        return $num;
    }


    // delete

    function delete($field)
    {

        $query = "DELETE FROM " . $this->prx . $this->table . " WHERE " . $field . " = :" . $field . "";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":$field", $this->$field);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function deleteFromTable($field, $table)
    {

        $query = "DELETE FROM " . $this->prx . $table . " WHERE " . $field . " = :" . $field . "";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":$field", $this->$field);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function dropTable($tableToDel)
    {

        $query = "DROP TABLE " . $tableToDel . "";

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function cloneTable($origTable, $newTable, $primaryKey)
    {

        $query = "CREATE TABLE " . $newTable . " AS SELECT * FROM " . $origTable . "; ALTER TABLE " . $newTable . " ADD PRIMARY KEY (" . $primaryKey . ");";

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function chmod_R($path, $filemode)
    {
        if (!is_dir($path)) {
            return chmod($path, $filemode);
        }
        $dh = opendir($path);
        while ($file = readdir($dh)) {
            if ($file != '.' && $file != '..') {
                $fullpath = $path . '/' . $file;
                if (!is_dir($fullpath)) {
                    if (!chmod($fullpath, $filemode)) {
                        return false;
                    }
                } else {
                    if (!$this->chmod_R($fullpath, $filemode)) {
                        return false;
                    }
                }
            }
        }

        closedir($dh);

        if (chmod($path, $filemode)) {
            return true;
        } else {
            return false;
        }
    }

    public function copyDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $sourceFile = $source . '/' . $file;
                $destinationFile = $destination . '/' . $file;
                if (is_dir($sourceFile)) {
                    $this->copyDirectory($sourceFile, $destinationFile);
                } else {
                    copy($sourceFile, $destinationFile);
                }
            }
        }
    }

    public function commaToPoint($number)
    {
        return str_replace(',', '.', $number);
    }

    public function pointToComma($number)
    {
        return str_replace('.', ',', $number);
    }


    public function rmdir_recursive($dir)
    {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir($dir . '/' . $file)) $this->rmdir_recursive($dir . '/' . $file);
            else unlink($dir . '/' . $file);
        }
        rmdir($dir);
    }

    
}