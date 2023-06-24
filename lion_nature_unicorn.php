<?php

//Project Unity - PHP Code

//Beginning of file

//Declare namespace
namespace ProjectUnity;

//Declare Classes
class DatabaseTable
{
    public $connection;
 
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
 
    public function insert($inputData)
    {
        $query = 'INSERT INTO ' . $this->tableName . ' (' . implode(', ', array_keys($inputData)) . ') VALUES (';
 
        $query .= ':' . implode(', :', array_keys($inputData)) . ')';
 
        $statement = $this->connection->prepare($query);
 
        $statement->execute($inputData);
 
    }
 
    public function update($inputData, $rowId)
    {
        $query = 'UPDATE ' . $this->tableName . ' SET ';
 
        $query .= $this->getUpdateQuery($inputData);
 
        $query .= ' WHERE id = :id';
 
        $statement = $this->connection->prepare($query);
 
        $inputData['id'] = $rowId;
 
        $statement->execute($inputData);
 
    }
 
    private function getUpdateQuery($inputData)
    {
        $query = '';
 
        foreach($inputData as $columnName => $value)
        {
            $query .= $columnName .' = :' . $columnName . ', ';
        }
 
        return rtrim($query, ', ');
    }
 
    public function delete($rowId)
    {
        $query = 'DELETE FROM ' . $this->tableName . ' WHERE id = :id';
 
        $statement = $this->connection->prepare($query);
 
        $statement->bindValue('id', $rowId);
 
        $statement->execute();
    }

} 

//Create new instance of the databaseTable class 
$dbTable = new DatabaseTable($connection);

//Update the table
$dbTable->update(
    [
        'columnName' => 'value',
        'columnName2' => 'value2'
    ],
    5
);

//Delete Data from the table
$dbTable->delete(10);

//End of file