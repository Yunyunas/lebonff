<?php 

abstract class AbstractRepository
{
    
    private const SERVER = "db.3wa.io";
    private const USER = "yunacharlon";
    private const PASSWORD = "32814c71d637f2425eae9ef156b2965b";
    private const BASE = "yunacharlon_lebonff";
    
    protected $table;
    protected $connexion;
    protected $query;

    public function __construct(string $table)
    {
        $this->constructConnexion();
        $this->table = $table;
    }
    
    /**
     * return array
     */
    public function fetchAll(): array
    {
        $data = null;
        try {
            $resultat = $this->connexion->query('SELECT * FROM '.$this->table);
            if ($resultat) {
                $data = $resultat->fetchAll(PDO::FETCH_ASSOC);
            }
            
        } catch (Exception $e) {
            
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
    private function constructConnexion(){
        
        try {
            $this->connexion = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::BASE, self::USER, self::PASSWORD);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $this->connexion->exec("SET CHARACTER SET utf8");
    }
}