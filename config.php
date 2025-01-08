class ConnexionBD {
        private static $pdo = null;

        public static function getPDO() {
            if (self::$pdo === null) {
                self::connexion();
            }
            return self::$pdo;
        }

        public static function deconnexion() {
            self::$pdo = null;
        }
        
        private static function connexion() {
            $host='sql103.infinityfree.com'; 
            $db= 'if0_37862084_roommanager';
            $user='if0_37862084';
            $pass='YNbP7VPvMMxNLG';
            $charset='utf8mb4';

            $dsn="mysql:host=$host;dbname=$db;charset=$charset";

            $options=[
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES=>false];

            try {
                self::$pdo = new PDO($dsn,$user,$pass,$options);
            } catch(PDOException $connexionErreur){
                throw new PDOException($connexionErreur->getMessage(), (int)$connexionErreur->getCode());
            }
        }
    }
