<?php
    class Document {
        private $connection;
        public $id, $name, $description;
        public $filename;

        public static $upload_dir;
        private $temp_path;

        public $errors = array();
        protected $upload_errors = array(
            UPLOAD_ERR_OK 			=> "No errors.",
            UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE 	=> "File is larger than 10MB.",
            UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
            UPLOAD_ERR_NO_FILE 		=> "No file selected for upload.",
            UPLOAD_ERR_NO_TMP_DIR 	=> "No temporary directory.",
            UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
            UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
        );

        public function __construct()
        {
            $this->connection = new Connection();
            $this->connection = $this->connection->connect();
        }

        public function save_to_db() {
            $statement = $this->connection->prepare("INSERT INTO document (name, description) VALUES (?, ?)");
            $statement->bindValue(1, $this->name);
            $statement->bindValue(2, $this->description);
            $result = $statement->execute();

            return $result ? true : false;
        }

        public function attach_file($file){
            // Perform error checking on the form parameters
            if(!$file || empty($file) || !is_array($file)) {
                // error: nothing uploaded or wrong argument usage
                $this->errors[] = "No file was uploaded.";
                return false;
            } elseif($file['error'] != 0) {
                // error: report what PHP says went wrong
                $this->errors[] = $this->upload_errors[$file['error']];
                return false;
            } else {
                if(($file['type'] == 'application/pdf') || ($file['type'] == 'application/vnd.ms-powerpoint') || ($file['type'] == 'application/msword')) {
                    //File is a document (e.g msword doc, powerpoint doc, pdf)
                    // Set object attributes to the form parameters.
                    $this->temp_path  = $file['tmp_name'];
                    $this->filename   = basename($file['name']);
                    return true;
                }
                else {
                    $this->errors[] = "File is not a valid document";
                    return false;
                }
            }
        }

        public function save() {
            // Make sure there are no errors

            // Can't save if there are pre-existing errors
            if(!empty($this->errors)) { return false; }

            // Can't save without filename and temp location
            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "The file location was not available.";
                return false;
            }

            // Determine the target_path
            $target_path = self::$upload_dir.$this->filename;

            // Make sure a file doesn't already exist in the target location
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists.";
                return false;
            }

            // Attempt to move the file
            if(move_uploaded_file($this->temp_path, $target_path)) {
                // Success
                // We are done with temp_path, the file isn't there anymore
                unset($this->temp_path);
                return true;
            } else {
                // File was not moved.
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
                return false;
            }
        }

        public function getDocuments() {
            $statement = $this->connection->prepare("SELECT * FROM document");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result ? $result : false;
        }

        public function countAll() {
            $statement = $this->connection->prepare("SELECT COUNT(*) AS count FROM document");
            $statement->execute();

            $result = $statement->fetch();

            return $result ? $result['count'] : false;
        }

        public function count($limit, $offset) {
            $statement = $this->connection->prepare("SELECT * FROM document ORDER BY id DESC LIMIT {$limit} OFFSET {$offset}");
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result ? $result : false;
        }

        public function getDocument($id) {
            $statement = $this->connection->prepare("SELECT * FROM document WHERE id = $id");
            $statement->execute();
            $result = $statement->fetch();

            return $result ? $result : false;
        }

        public function delete($id) {
            $statement = $this->connection->prepare("DELETE FROM document WHERE id = $id");
            $result = $statement->execute();
            return $result ? true : false;
        }
    }