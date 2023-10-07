<?php
    require_once './models/Event.php';
    require_once './config.php'; 
    require_once './mail.php';

    class EventController {
        
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function getEvent($event_id) {
            $stmt = $this->conn->prepare("SELECT * FROM eventi WHERE id = ?"); 
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $eventData = $result->fetch_assoc();
            $stmt->close();
            
            if ($eventData) {
                return new Event($eventData['id'], $eventData['nome_evento'], $eventData['attendees'], $eventData['data_evento'], $eventData['description']);
            } else {
                return null;
            }
        }

        public function addEvent($nome_evento, $attendees, $data_evento, $description) {
            $stmt = $this->conn->prepare("INSERT INTO eventi (nome_evento, attendees, data_evento, description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome_evento, $attendees, $data_evento, $description);
            if($stmt->execute()) {
                $stmt->close();
                $attendeesArray = explode(',', $attendees);
                foreach($attendeesArray as $attendee) {
                    $subject = "Nuovo Evento $nome_evento";
                    $body = "Ciao, sei stato aggiunto a un nuovo evento: $nome_evento il $data_evento.";
                    sendMail(trim($attendee), $subject, $body);
                }
                return true;
            } else {
                $stmt->close();
                return false;
            }
        }        

        public function viewEvents() {
            $stmt = $this->conn->prepare("SELECT * FROM eventi");
            $stmt->execute();
            $result = $stmt->get_result();
            $events = [];
            while($row = $result->fetch_assoc()) {
                $event = new Event($row['id'], $row['nome_evento'], $row['attendees'], $row['data_evento'], $row['description']);
                array_push($events, $event);
            }
            return $events;
        }

        public function editEvent($id, $nome_evento, $attendees, $data_evento, $description) {
            $stmt = $this->conn->prepare("UPDATE eventi SET nome_evento = ?, attendees = ?, data_evento = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nome_evento, $attendees, $data_evento, $description, $id);
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function deleteEvent($id) {
            $stmt = $this->conn->prepare("SELECT * FROM eventi WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        
            if ($event) {
                $attendeesArray = explode(',', $event['attendees']);
                foreach($attendeesArray as $attendee) {
                    $subject = "Cancellazione dell'Evento: " . $event['nome_evento'];
                    $body = "L'evento " . $event['nome_evento'] . " è stato cancellato.";
                    sendMail($attendee, $subject, $body);
                }
        
                $stmt = $this->conn->prepare("DELETE FROM eventi WHERE id = ?");
                $stmt->bind_param("i", $id);
                if($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
                $stmt->close();
            } else {
                return false;
            }
        }
        
    }
?>