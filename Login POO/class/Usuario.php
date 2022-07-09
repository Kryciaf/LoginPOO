<?php
require_once ('Crud.php');

class Usuario extends Crud{
    protected string $tabela = "usuarios";

    public string $nome;
    public string $email;
    public string $senha;
    public string $repete_senha="";
    public string $recupera_senha="";
    public string $token="";
    public string $codigo_confirmacao="";
    public string $status="";
    public array $erro=[];

    function __construct($nome, $email, $senha, $repete_senha="", $recupera_senha="", $token="", $codigo_confirmacao="", $status="", $erro=[]){
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->repete_senha = $repete_senha;
        $this->recupera_senha = $recupera_senha;
        $this->token = $token;
        $this->codigo_confirmacao = $codigo_confirmacao;
        $this->status = $status;
        $this->erro = $erro;
    }

    public function set_repeticao($repete_senha){
        $this->repete_senha = $repete_senha;
    }

    public function validarCadastro(){
        if (!preg_match("/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]+$/",$this->nome)) {
            $this->erro["erro_nome"] = "Somente permitido letras e espaços em branco!";
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->erro['erro_email'] = "Formato de email inválido";
        }

        if (strlen($this->senha) < 6) {
            $this->erro["erro_senha"] = "Senha deve ter 6 ou mais caracteres";
        }

        if ($this->senha !== $this->repete_senha){
            $this->erro["erro_repete"] = "As senhas precisam ser iguais";
        }
    }

    public function insert() {
        // VEREFICAR SE O EMAIL JÁ ESTÁ CADASTRADO
        $sql = "SELECT * FROM usuarios WHERE email=? LIMIT 1";
        $sql = DB::prepare($sql);
        $sql->execute(array($this->email));
        $usuario = $sql->fetch();

        // SE NÃO HOUVER O USUÁRIO, ADICIONÁ-LO AO BANCO
        if (!$usuario) {
            $data_cadastro = date('d/m/Y');
            $senha_cripto = sha1($this->senha);
            $sql = "INSERT INTO $this->tabela VALUES (null,?,?,?,?,?,?,?,?) ";
            $sql = DB::prepare($sql);
            return $sql->execute(array($this->nome,$this->email,$senha_cripto,$this->recupera_senha,$this->token,$this->codigo_confirmacao,$this->status,$data_cadastro,));
        } else {
            $this->erro["erro_geral"] = "Usuário já cadastrado";
        }
    }

    public function update($id)
    {

    }
}
