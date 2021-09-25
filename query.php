<?php
   
    require_once "init_config.php";

    class DBQuery() {
        public function __construct(DB_NAME, DB_USER, DB_PASS) {
            $db = new PDO (DB_NAME, DB_USER, DB_PASS);
        }
        
        public function add_user() {
        
        }
        
        public function unsubscribe() {
        
        }
    }
    
    class TelegramQuery() {
        public __construct(BOT_URL, BOT_TOKEN) {
            $this->url = BOT_URL;
            $this->bot_token = BOT_TOKEN;
        }
        public sendMessage($chat_id, $msg) {
            $params = http_build_query(["chat_id" => $chat_id, "text" => $msg]); 
            $url = $this->url . $this->bot_token . "/sendMessage?$params";
            file_get_contents($url)
        }
    }
    

