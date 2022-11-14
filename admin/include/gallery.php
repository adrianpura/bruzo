<?php
require_once('database.php');

class gallery
{

    protected static  $tblname = "gallery";

    function dbfields()
    {
        global $mydb;
        return $mydb->getfieldsononetable(self::$tblname);
    }


    /*---Instantiation of Object dynamically---*/
    static function instantiate($record)
    {
        $object = new self;

        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }


    /*--Cleaning the raw data before submitting to Database--*/
    private function has_attribute($attribute)
    {
        // We don't care about the value, we just want to know if the key exists
        // Will return true or false
        return array_key_exists($attribute, $this->attributes());
    }

    protected function attributes()
    {
        // return an array of attribute names and their values
        global $mydb;
        $attributes = array();
        foreach ($this->dbfields() as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes()
    {
        global $mydb;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $mydb->escape_value($value);
        }
        return $clean_attributes;
    }
    public function create()
    {
        global $mydb;
        // Don't forget your SQL syntax and good habits:
        // - INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . self::$tblname . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        echo $mydb->setQuery($sql);

        if ($mydb->executeQuery()) {
            $this->id = $mydb->insert_id();
            $this->upload($_FILES["fileToUpload"]);
            return $this->id;
        } else {
            return false;
        }
    }

    public function delete($id = '')
    {
        global $mydb;
        $sql = "DELETE FROM " . self::$tblname;
        $sql .= " WHERE id='" . $id . "'";
        // $sql .= " LIMIT 1 ";
        $mydb->setQuery($sql);

        if (!$mydb->executeQuery()) return false;
    }

    public function upload($filetoupload)
    {
        $target_dir = "./img_uploads/";
        $target_file = $target_dir . basename($filetoupload["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
            $check = getimagesize($filetoupload["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($filetoupload["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($filetoupload["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
