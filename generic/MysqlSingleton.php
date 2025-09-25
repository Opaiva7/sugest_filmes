<?php

namespace generic;

class MysqlSingleton
{
    private static ?MysqlSingleton $instance = null;

    private string $dsn      = 'mysql:host=localhost;dbname=sugest_filmes;charset=utf8mb4';
    private string $usuario  = 'root';
    private string $senha    = '';
    private ?array $options  = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ];

    /** @var \PDO|null */
    private $conn = null;

    private function __construct()
    {
        if ($this->conn === null) {
            $this->conn = new \PDO($this->dsn, $this->usuario, $this->senha, $this->options);
        }
    }

    public static function getInstance(): MysqlSingleton
    {
        if (self::$instance === null) {
            self::$instance = new MysqlSingleton();
        }
        return self::$instance;
    }

    /**
     * Executa query preparada. Retorna array (SELECT) ou bool (INSERT/UPDATE/DELETE).
     */
    public function executar(string $query, array $param = [])
    {
        if (!$this->conn) return false;

        $sth = $this->conn->prepare($query);

        // bindValue explícito (mantém compatibilidade com seu padrão)
        foreach ($param as $k => $v) {
            $sth->bindValue($k, $v);
        }

        $ok = $sth->execute();

        // Tenta detectar se é SELECT
        if (stripos(ltrim($query), 'select') === 0) {
            return $sth->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $ok;
    }
}
