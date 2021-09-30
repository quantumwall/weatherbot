<?php
   
    class DBQuery {
        public function __construct($db_name, $db_user, $db_pass) {
            $db = new PDO ($db_name, $db_user, $db_pass);
            $this->db = $db;
        }
        
        public function add_user($username, $chat_id) {
            return NULL;
        }
        
        public function unsubscribe() {
            return NULL;
        }
    }
    
    class TelegramQuery {
        public function __construct($bot_url, $bot_token) {
            $this->bot_url = $bot_url;
            $this->bot_token = $bot_token;
        }
        public function sendMessage($chat_id, $msg) {
            $params = http_build_query(["chat_id" => $chat_id, "text" => $msg]); 
            $url = $this->bot_url . $this->bot_token . "/sendMessage?$params";
            file_get_contents($url);
        }
    }
    

