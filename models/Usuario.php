<?php
require_once __DIR__ . '/../config/Conexao.php';

class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senhaHash;
    private $administrador;

    public function __construct($nome, $email, $senha, $administrador = 0, $id = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senhaHash = $senha;
        $this->administrador = $administrador;
    }

    // Getters e Setters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getAdministrador() { return $this->administrador; }
    public function setNome($nome) { $this->nome = $nome; }
    public function setEmail($email) { $this->email = $email; }
    public function setAdministrador($adm) { $this->administrador = $adm; }
    public function setSenha($senha) { $this->senhaHash = password_hash($senha, PASSWORD_DEFAULT); }

    // Salva o usuário no banco (cadastrar)
    public function salvar() {
        try {
            $conexao = Conexao::getConexao();

            // Verifica se já existe usuário com este email
            $sqlVerificar = 'SELECT id FROM usuarios WHERE email = :email';
            $stmtVerificar = $conexao->prepare($sqlVerificar);
            $stmtVerificar->bindParam(':email', $this->email);
            $stmtVerificar->execute();

            if ($stmtVerificar->rowCount() > 0) {
                return false;
            }

            $sqlInserir = 'INSERT INTO usuarios (nome, email, senha, administrador) VALUES (:nome, :email, :senha, :administrador)';
            $stmtInserir = $conexao->prepare($sqlInserir);
            $stmtInserir->bindParam(':nome', $this->nome);
            $stmtInserir->bindParam(':email', $this->email);
            $stmtInserir->bindParam(':senha', $this->senhaHash);
            $stmtInserir->bindParam(':administrador', $this->administrador);

            if ($stmtInserir->execute()) {
                $this->id = $conexao->lastInsertId();
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Autentica e retorna um objeto Usuario ou mensagem de erro
    public static function autenticar($email, $senha) {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return 'Usuário não encontrado.';
            }

            if (!password_verify($senha, $usuario['senha'])) {
                return 'Senha incorreta.';
            }

            $userObj = new Usuario(
                $usuario['nome'],
                $usuario['email'],
                $usuario['senha'],
                $usuario['administrador'],
                $usuario['id']
            );

            $_SESSION['usuario_id'] = $userObj->getId();
            $_SESSION['usuario_nome'] = $userObj->getNome();
            $_SESSION['usuario_administrador'] = $userObj->getAdministrador();

            return $userObj;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 'Erro ao autenticar o usuário.';
        }
    }
}
?>