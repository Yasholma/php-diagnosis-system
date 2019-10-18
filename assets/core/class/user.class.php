<?php
	class User {
		private $connection;
		public $id, $name, $username, $password, $phone, $email, $gender, $usergroup;

		public function __construct() {
			$this->connection = new Connection();
			$this->connection = $this->connection->connect();
		}

		public function checkUsername($username) {
		    $statement = $this->connection->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
		    $statement->execute(['username' => $username]);
		    $result = $statement->fetch();

		    return $result ? true : false;
        }

        public function checkPassword($userId, $oldPass) {
            $statement = $this->connection->prepare("SELECT * FROM users WHERE id = :userId AND password = :password");
		    $statement->execute(['userId' => $userId, 'password' => $oldPass]);
		    $result = $statement->fetch();

		    return $result ? true : false;
        }

		// Create record in database table
		public function createUser() {
            $statement = $this->connection->prepare("INSERT INTO users (username, password, usergroup) VALUES (?, ?, ?)");
            // Bind all values to the placeholders
            $statement->bindParam(1, $this->username);
            $statement->bindParam(2, $this->password);
            $statement->bindParam(3, $this->usergroup);
            // Execute the query
            $result = $statement->execute();

            $this->id = $this->connection->lastInsertId();

            return $result ? true : false;
        }

		public function createProfile($userId) {
            $statement = $this->connection->prepare("INSERT INTO patient (userId, name, email, phone, gender) VALUES (?, ?, ?, ?, ?)");
            // Bind all values to the placeholders
            $statement->bindParam(1, $userId);
            $statement->bindParam(2, $this->name);
            $statement->bindParam(3, $this->email);
            $statement->bindParam(4, $this->phone);
            $statement->bindParam(5, $this->gender);
            // Execute the query
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function addDoctor($userId, $name, $email, $phone, $specialty)
        {
            $statement = $this->connection->prepare("INSERT INTO experts (userId, name, email, phone, specialty) VALUES (?, ?, ?, ?, ?)");
            // Bind all values to the placeholders
            $statement->bindParam(1, $userId);
            $statement->bindParam(2, $name);
            $statement->bindParam(3, $email);
            $statement->bindParam(4, $phone);
            $statement->bindParam(5, $specialty);
            // Execute the query
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function contactAdmin($message, $userId)
        {
            $statement = $this->connection->prepare("INSERT INTO contact (message, userId) VALUES (?, ?)");
            // Bind all values to the placeholders
            $statement->bindParam(1, $message);
            $statement->bindParam(2, $userId);

            // Execute the query
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function getMessages()
        {
            $statement = $this->connection->prepare("SELECT * FROM contact ORDER BY created_at ASC");
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

        public function block($id) {
            $statement = $this->connection->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
            $statement->bindValue(1, $id);
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function unblock($id) {
            $statement = $this->connection->prepare("UPDATE users SET is_active = 1 WHERE id = ?");
            $statement->bindValue(1, $id);
            $result = $statement->execute();

            return $result ? true : false;
        }

		public function logout() {
			if (isset($_SESSION['us3rid'])){
				unset($_SESSION['us3rid']);
				session_destroy();

				return true;
			}
			return false;
		}

		public function checkActive($id) {
			$statement = $this->connection->prepare("SELECT is_active FROM users WHERE id = ?");
			$statement->bindValue(1, $id);
			$statement->execute();

			$result = $statement->fetch();

			return $result ? $result['is_active'] : false;
		}

		public function getUsers() {
			$statement = $this->connection->prepare("SELECT * FROM users");
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : false;
		}

        public function getPatients() {
            $statement = $this->connection->prepare("SELECT * FROM patient");
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result ? $result : false;
        }

        public function getUser($patientId)
        {
            $statement = $this->connection->prepare("SELECT * FROM patient WHERE userId = :userId");
            $statement->execute(['userId' => $patientId]);

            $result = $statement->fetch(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

        public function getUsername($id)
        {
            $statement = $this->connection->prepare("SELECT * FROM diagnosis.users WHERE id = :userId");
            $statement->execute(['userId' => $id]);

            $result = $statement->fetch(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

		public function getExperts() {
			$statement = $this->connection->prepare("SELECT * FROM users WHERE usergroup = 'expert'");
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : false;
		}

		public function getExpertInfo($expert_id) {
            $statement = $this->connection->prepare("SELECT * FROM experts WHERE userId = :userId");
            $statement->execute(['userId' => $expert_id]);

            $result = $statement->fetch(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

        public function getAllVisibleQueries($limit, $offset) {
            $statement = $this->connection->prepare("SELECT * FROM queries WHERE visibility = 1 ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}");
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result ? $result : false;
        }

        public function getQuery($patientId) {
            $statement = $this->connection->prepare("SELECT * FROM queries WHERE patientId = :userId ORDER BY created_at DESC");
            $statement->execute(['userId' => $patientId]);

            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

        public function getQuery4Expert($expertId)
        {
            $statement = $this->connection->prepare("SELECT * FROM queries WHERE expertId = :userId");
            $statement->execute(['userId' => $expertId]);

            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

        public function getSingleQuery($uQuery) {
            $statement = $this->connection->prepare("SELECT * FROM queries WHERE id = :qId");
            $statement->execute(['qId' => $uQuery]);

            $result = $statement->fetch(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

        public function getPost($postId)
        {
        }

        public function createQuery($patientId, $expertId, $desc, $visibility) {
            $statement = $this->connection->prepare("INSERT INTO queries (patientId, expertId, description, visibility) VALUES (?, ?, ?, ?)");
            // Bind all values to the placeholders
            $statement->bindParam(1, $patientId);
            $statement->bindParam(2, $expertId);
            $statement->bindParam(3, $desc);
            $statement->bindParam(4, $visibility);
            // Execute the query
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function reply($doctorId, $uQueryId, $reply)
        {
            $statement = $this->connection->prepare("INSERT INTO replies (expertId, queryId, reply) VALUES (?, ?, ?)");
            // Bind all values to the placeholders
            $statement->bindParam(1, $doctorId);
            $statement->bindParam(2, $uQueryId);
            $statement->bindParam(3, $reply);
            // Execute the query
            $result = $statement->execute();

            return $result ? true : false;
        }

		public function getActiveUsers() {
			$statement = $this->connection->prepare("SELECT * FROM user WHERE is_active = 1");
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : false;
		}

		public function getBlockedUsers() {
			$statement = $this->connection->prepare("SELECT * FROM user WHERE is_active = 0");
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : false;
		}

		// Logging user in
		public function login($username, $password) {
			$statement = $this->connection->prepare("SELECT * FROM users WHERE username = :username AND password = :password AND is_active = 1");
			$statement->execute(array("username"=>$username, "password"=>$password));

			$result = $statement->fetch();

			// Create SESSION variables for logged in user
			if ($result) {
				$_SESSION['us3rid'] = $result['id'];
				$_SESSION['us3rgr0up'] = $result['usergroup'];
				$_SESSION['1s@dmin'] = ($result['usergroup'] == 'admin') ? true : false;
			}

			return $result ? true : false;
		}

		public function countAll() {
			$statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM queries");
			$statement->execute();
			$result = $statement->fetch();

			return $result ? $result['count'] : false;
		}


		public function countActive() {
			$statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM users WHERE is_active = 1");
			$statement->execute();
			$result = $statement->fetch();

			return $result ? $result['count'] : false;
		}

		public function online($id) {
            $statement = $this->connection->prepare("UPDATE users SET status = 1 WHERE id = ?");
            $statement->bindValue(1, $id);
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function offline($id) {
            $statement = $this->connection->prepare("UPDATE users SET status = 0 WHERE id = ?");
            $statement->bindValue(1, $id);
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function countBlockedUsers() {
		    $statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM user WHERE is_active = 0");
		    $statement->execute();
            $result = $statement->fetch();
		    return $result ? $result['count'] : false;
        }

        public function updatePassword($user_id) {
        	$statement = $this->connection->prepare("UPDATE users SET password = ? WHERE id = ?");
        	$statement->bindValue(1, $this->password);
        	$statement->bindValue(2, $user_id);
        	$result = $statement->execute();

        	return $result ? true : false;
        }

		// Delete record from table
		public function delete($id) {
			$query = "DELETE FROM users WHERE id = :id";
			$statement = $this->connection->prepare($query);
			$result = $statement->execute(array("id"=>$id));

			return $result ? true : false;
		}

        public function deleteProfile($expId)
        {
            $query = "DELETE FROM experts WHERE userId = :id";
            $statement = $this->connection->prepare($query);
            $result = $statement->execute(array("id"=>$expId));

            return $result ? true : false;
        }

        public function getReply($expertId, $uQueryId)
        {
            $statement = $this->connection->prepare("SELECT * FROM replies WHERE expertId = :eId AND queryId = :qId");
            $statement->execute(['eId' => $expertId, 'qId' => $uQueryId]);

            $result = $statement->fetchAll(PDO::FETCH_OBJ);

            return $result ? $result : false;
        }

        public function deleteQuery($queryId)
        {
            $query = "DELETE FROM queries WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $result = $statement->execute(array("id"=>$queryId));

            return $result ? true : false;
        }

        public function deleteReply($queryId)
        {
            $query = "DELETE FROM replies WHERE queryId = :id";
            $statement = $this->connection->prepare($query);
            $result = $statement->execute(array("id"=>$queryId));

            return $result ? true : false;
        }


        // News Handling
        public function addNews($userId, $news) {
            $statement = $this->connection->prepare("INSERT INTO latest_news (news, expertId) VALUES(?, ?)");
            $statement->bindValue(1, $news);
            $statement->bindValue(2, $userId);
            $res = $statement->execute();

            return $res ? true : false;
        }

        public function getAllNews() {
           $statement = $this->connection->prepare("SELECT * FROM latest_news ORDER BY created_at DESC");
            $statement->execute();
            $res = $statement->fetchAll(PDO::FETCH_OBJ);

            return $res ? $res : false;
        }

        public function getPublishedNews() {
            $statement = $this->connection->prepare("SELECT * FROM latest_news WHERE published = 1 ORDER BY created_at DESC LIMIT 5");
            $statement->execute();
            $res = $statement->fetchAll(PDO::FETCH_OBJ);

            return $res ? $res : false;
        }


        public function publish($newsId) {
            $statement = $this->connection->prepare("UPDATE latest_news SET published = 1 WHERE id = :newsId");
            $res = $statement->execute(['newsId' => $newsId]);

            return $res ? $res : false;
        }




    }
