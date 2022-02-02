<?php
    class Response implements \JsonSerializable{
        private $error;
        private $message;
        private $status_code;
        private $content_type;

        function __construct($error, $message, $status_code, $content_type) {
            $this -> error = $error;
            $this -> error = $message;
            $this -> error = $status_code;
            $this -> error = $content_type;
        }

        // SET
        public function set_error($error){
            $this -> error = $error;
        }
        public function set_message($message){
            $this -> message = $message;
        }
        public function set_statusCode($status_code){
            $this -> status_code = $status_code;
        }
        public function set_contentType($content_type){
            $this -> content_type = $content_type;
        }

        // GET
        public function get_error(){
            return $this->error;
        }
        public function get_message(){
            return $this->message;
        }
        public function get_statusCode(){
            return $this->status_code;
        }
        public function get_contentType(){
            return $this->content_type;
        }

        // FUNCTION
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>