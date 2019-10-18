<?php
	class PChat {
		private $connection;
		public $id, $sId, $rId, $message, $is_read;

		public function __construct()
        {
            $this->connection = new Connection();
            $this->connection = $this->connection->connect();
        }

        public function getMessages($sId, $rId) {
		    $statement = $this->connection->prepare("SELECT * FROM p_chat p WHERE sId = $sId AND rId = $rId OR rId = $sId AND sId = $rId ORDER BY timestamp");
		    $statement->execute();
		    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

		    return $result ? $result : false;
        }

        public function addMessage() {
		    $statement = $this->connection->prepare("INSERT INTO p_chat (sId, rId, message) VALUES (?, ?, ?)");
		    $statement->bindValue(1, $this->sId);
		    $statement->bindValue(2, $this->rId);
		    $statement->bindValue(3, $this->message);
		    $result = $statement->execute();


		    return $result ? true : false;
        }

        public function getNotify($sId) {
		    $statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM p_chat WHERE rId = $sId AND is_read = 0");
		    $statement->execute();
		    $result = $statement->fetch();

		    return $result ? $result['count'] : false;
        }

        public function showUnreadMsg($sId) {
		    $statement = $this->connection->prepare("SELECT * FROM p_chat WHERE is_read = 0 AND rId = $sId OR sId = $sId ORDER BY timestamp");
		    $statement->execute();
		    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

		    return $result ? $result : false;
        }

        public function seen($sId, $rId) {
		    $statement = $this->connection->prepare("UPDATE p_chat SET is_read = 1 WHERE sId = $sId AND rId = $rId");
		    $result = $statement->execute();

		    return $result ? true : false;
        }

        public function delete() {
        	$statement = $this->connection->prepare("DELETE FROM p_chat WHERE sId = $this->sId OR rId = $this->rId");
        	$result = $statement->execute();

        	return $result ? true : false;
        }

    }