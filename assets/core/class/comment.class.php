<?php 
	class Comment {
		private $connection;
		public $id, $comment, $userId, $postId;

		public function __construct() {
			$this->connection = new Connection();
			$this->connection = $this->connection->connect();
		}

		public function createComment() {
			$statement = $this->connection->prepare("INSERT INTO comments (comment, postId, userId) VALUES(?, ?, ?)");
			$statement->bindValue(1, $this->comment);
			$statement->bindValue(2, $this->postId);
			$statement->bindValue(3, $this->userId);

			$result = $statement->execute();
			return $result ? true : false;
		}

		public function getComments($post_id) {
			$statement = $this->connection->prepare("SELECT * FROM comments WHERE postId = ?");
			$statement->bindValue(1, $post_id);
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_OBJ);
			return $result ? $result : false;
		}

		public function delete($user_id) {
			$statement = $this->connection->prepare("DELETE FROM comments WHERE userId = $user_id");
			$result = $statement->execute();

			return $result ? true : false;
		}

		public function deleteComment($post_id) {
            $statement = $this->connection->prepare("DELETE FROM comments WHERE postId = $post_id");
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function countAll($postId)
        {
            $statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM comments WHERE postId = :postId");
            $statement->execute(['postId' => $postId]);
            $result = $statement->fetch();

            return $result ? $result['count'] : false;
        }

        public function count($limit, $offset, $postId) {
            $statement = $this->connection->prepare("SELECT * FROM comments WHERE postId = :postId ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}");
            $statement->execute(['postId' => $postId]);

            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }
    }