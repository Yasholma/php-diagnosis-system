<?php 
	class Post {
		private $connection;
		public $id, $title, $body, $user_id;

		public function __construct() {
			$this->connection = new Connection();
			$this->connection = $this->connection->connect();
		}

		public function createPost() {
			$statement = $this->connection->prepare("INSERT INTO post (title, body, user_id) VALUES(?,?,?)");
			$statement->bindValue(1, $this->title);
			$statement->bindValue(2, $this->body);
			$statement->bindValue(3, $this->user_id);

			$result = $statement->execute();

			return $result ? true : false;
		}

		public function getPosts() {
			$statement = $this->connection->prepare("SELECT * FROM post ORDER BY id DESC ");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $result ? $result : false;
		}

		public function getPostByUser($user_id) {
			$statement = $this->connection->prepare("SELECT * FROM post WHERE user_id = ? ORDER BY created_at DESC");
			$statement->bindValue(1, $user_id);
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $result ? $result : false;
		}

		public function getPostLimit5() {
			$statement = $this->connection->prepare("SELECT * FROM post ORDER BY created_at DESC LIMIT 5");
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $result ? $result : false;
		}

		public function getPost($id) {
			$statement = $this->connection->prepare("SELECT * FROM post WHERE id = ?");
			$statement->bindValue(1, $id);
			$statement->execute();

			$result = $statement->fetch();
			return $result ? $result : false;
		}

		public function countPostByUser($id) {
		    $statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM post WHERE user_id = ?");
		    $statement->bindValue(1, $id);
		    $statement->execute();
		    $result = $statement->fetch();

		    return $result ? $result['count'] : false;
        }

		// Count of all blog post
	    public function countAll() {
	        $statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM post");
	        $statement->execute();

	        $result = $statement->fetch();

	        return $result ? $result['count'] : false;
	    }

        public function count($limit, $offset) {
	        $statement = $this->connection->prepare("SELECT * FROM post ORDER BY id DESC LIMIT {$limit} OFFSET {$offset}");
	        $statement->execute();

	        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

	        return $result ? $result : false;
	    }

	    public function getTopPosts() {
//		    $sql = "SELECT p.id, c.postCount FROM post AS p INNER JOIN (SELECT post_id, COUNT(*) AS postCount FROM comment GROUP BY post_id) AS c ON p.id = c.post_id";
            $sql = "SELECT id, title, comment_count FROM (SELECT p.id, p.title, COUNT(c.id) AS comment_count FROM post p, comment c WHERE c.post_id = p.id GROUP BY p.id, p.title ORDER BY 3 DESC) x LIMIT 3";
		    $statement = $this->connection->prepare($sql);
		    $statement->execute();
		    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

		    return $result ? $result : false;
        }

        public function search($name) {
            $statement = $this->connection->prepare("SELECT id, title FROM post WHERE title LIKE '%$name%' LIMIT 5");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result ? $result : false;
        }

	    public function delete($id) {
			$statement = $this->connection->prepare("DELETE FROM post WHERE id = $id");
			$result = $statement->execute();

			return $result ? true : false;
		}
	}