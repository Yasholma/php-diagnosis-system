<?php
	class Chat {
		private $connection;
		public $user_id, $message, $send_date;

		public function __construct()
        {
            $this->connection = new Connection();
            $this->connection = $this->connection->connect();
        }

        public function getMessages() {
		    $statement = $this->connection->prepare("SELECT c.message, c.send_date, u.id, u.email FROM user u JOIN chat c ON c.user_id = u.id ORDER BY send_date");
		    $statement->execute();
		    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

		    return $result ? $result : false;
        }

        public function addMessage($user_id, $message) {
		    $statement = $this->connection->prepare("INSERT INTO chat (user_id, message) VALUES (?, ?)");
		    $statement->bindValue(1, $user_id);
		    $statement->bindValue(2, $message);
		    $result = $statement->execute();


		    return $result ? true : false;
        }

    }