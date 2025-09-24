<?php

require_once "database.php"; 

class Book extends Database {
    
    public $id = "";
    public $title = "";
    public $genre = "";
    public $publication_year = "";
    public $publisher = "";
    public $copies = "";

    
    public function addBook() {
        $sql = "INSERT INTO book (title, genre, publication_year, publisher, copies) VALUES (:title, :genre, :publication_year, :publisher, :copies)";
        
        $query = $this->connect()->prepare($sql);

        
        $query->bindParam(":title", $this->title);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);

        return $query->execute();
    }

    public function viewBooks($search = "", $genre = "") {
        $sql = "SELECT * FROM book 
                WHERE title LIKE CONCAT('%', :search, '%') 
                AND genre LIKE CONCAT('%', :genre, '%') 
                ORDER BY title ASC";

        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        $query->bindParam(":genre", $genre);

        if ($query->execute()) {
            return $query->fetchAll(); 
        } else {
            return null;
        }
    }
    // Check if a book already exists (by title)
    public function isBookExist($title) {
        $sql = "SELECT COUNT(*) as total FROM book WHERE title = :title";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $title);
        $record = null;

        if ($query->execute()) {
            $record = $query->fetch();
        }

        return ($record && $record["total"] > 0);
    }
}

// Example usage:

// $obj = new Book();
// $obj->title = "Atomic Habits";
// $obj->genre = "Science";
// $obj->publication_year = 2018;
// $obj->publisher = "Penguin";
// $obj->copies = 5;

// Insert book
// var_dump($obj->addBook());

// View books
// var_dump($obj->viewBooks());
