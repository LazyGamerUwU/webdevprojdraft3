<?php
require_once 'database.class.php';

class Events {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEvents() {
        $sql = "SELECT * FROM events ORDER BY event_date ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventById($id) {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addEvent($title, $description, $organizers, $starttime, $endtime, $venue, $event_date) {
        $sql = "INSERT INTO events (title, description, organizers, starttime, endtime, venue, event_date) 
                VALUES (:title, :description, :organizers, :starttime, :endtime, :venue, :event_date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':organizers', $organizers);
        $stmt->bindParam(':starttime', $starttime);
        $stmt->bindParam(':endtime', $endtime);
        $stmt->bindParam(':venue', $venue);
        $stmt->bindParam(':event_date', $event_date);
        return $stmt->execute();
    }

    public function updateEvent($id, $title, $description, $organizers, $starttime, $endtime, $venue, $event_date) {
        $sql = "UPDATE events SET title = :title, description = :description, organizers = :organizers, 
                starttime = :starttime, endtime = :endtime, venue = :venue, event_date = :event_date WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':organizers', $organizers);
        $stmt->bindParam(':starttime', $starttime);
        $stmt->bindParam(':endtime', $endtime);
        $stmt->bindParam(':venue', $venue);
        $stmt->bindParam(':event_date', $event_date);
        return $stmt->execute();
    }

    public function deleteEvent($id) {
        $sql = "DELETE FROM events WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
