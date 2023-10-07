<?php
    class Event {
        private $id;
        private $nome_evento;
        private $attendees;
        private $data_evento;
        private $description;

        public function __construct($id, $nome_evento, $attendees, $data_evento, $description) {
            $this->id = $id;
            $this->nome_evento = $nome_evento;
            $this->attendees = $attendees;
            $this->data_evento = $data_evento;
            $this->description = $description;
        }

        public function getId() {
            return $this->id;
        }

        public function getNome() {
            return $this->nome_evento;
        }

        public function getAttendees() {
            return $this->attendees;
        }

        public function getDataEvento() {
            return $this->data_evento;
        }

        public function getDescription() {
            return $this->description;
        }

        // Metodi setter
        public function setNome($nome_evento) {
            $this->nome_evento = $nome_evento;
        }

        public function setAttendees($attendees) {
            $this->attendees = $attendees;
        }

        public function setDataEvento($data_evento) {
            $this->data_evento = $data_evento;
        }

        public function setDescription($description) {
            $this->description = $description;
        }
    }
?>