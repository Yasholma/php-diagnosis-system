<?php 
	class Profile {
		private $connection;
		public $id, $user_id, $firstName, $middleName, $lastName, $phone, $gender, $dob, $address, $state_id, $lga_id;
        public $field, $picture, $about;

		public function __construct() {
			$this->connection = new Connection();
			$this->connection = $this->connection->connect();
		}

		// Creating profile after collecting user id from user table
		public function createProfile() {
            $statement = $this->connection->prepare("INSERT INTO profile (user_id, firstName, middleName, lastName, phone, gender, dob, address, state_id, lga_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->bindValue(1, $this->user_id);
            $statement->bindValue(2, $this->firstName);
            $statement->bindValue(3, $this->middleName);
            $statement->bindValue(4, $this->lastName);
            $statement->bindValue(5, $this->phone);
            $statement->bindValue(6, $this->gender);
            $statement->bindValue(7, $this->dob);
            $statement->bindValue(8, $this->address);
            $statement->bindValue(9, $this->state_id);
            $statement->bindValue(10, $this->lga_id);
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function getUserProfile($id) {
            $statement = $this->connection->prepare("SELECT * FROM profile WHERE user_id = ?");
            $statement->bindValue(1, $id);
            $statement->execute();

            $result = $statement->fetch();

            return $result ? $result : false;
        }

        public function delete($user_id) {
            $statement = $this->connection->prepare("DELETE FROM profile WHERE user_id = ?");
            $statement->bindValue(1, $user_id);
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function createUserInfo($user_id) {
            $statement = $this->connection->prepare("INSERT INTO user_profile (user_id) VALUES ($user_id)");
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function fillProfile($user_id) {
            $statement = $this->connection->prepare("UPDATE user_profile SET field = ?, picture = ?, about = ? WHERE user_id = $user_id");
            $statement->bindValue(1, $this->field);
            $statement->bindValue(2, $this->picture);
            $statement->bindValue(3, $this->about);
            $result = $statement->execute();

		    return $result ? true : false;
        }

        public function getInfo($user_id) {
		    $statement = $this->connection->prepare("SELECT * FROM user_profile WHERE user_id = $user_id");
		    $statement->execute();
		    $result = $statement->fetch();

		    return $result ? $result : false;
        }

	}