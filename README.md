# 🚗 Estacionamento Web Servidor

Projeto de sistema web realizado em aula na Universidade Tecnologica Federal do Parana em Ponta Grossa, desenvolvido em PHP com banco de dados MySQL. 
O projeto consiste em um sistema simples de estacionamento, contendo o cadastro de usuários, veículos e o estacionamento.

---

## 🧑‍💻 Autor

Desenvolvido por João Victor Vieira - RA 2200880 (UTFPR-PG)

---

## 📋 Descrição

Este sistema permite:
- Cadastro de usuários
- Cadastro e gerenciamento de veículos
- Registro e controle de estacionamentos
- Exportação de dados para Excel

---

## ✅ Requisitos para Instalação

### 1. Requisitos de Software
- **Servidor Web**: Apache, utilizando [XAMPP](acessável em https://www.apachefriends.org/).
- **Banco de Dados**: MySQL (incluso no XAMPP/WAMP).

--- 

### 2. Requisitos de Hardware
- **Processador**: Dual-core ou superior
- **Memória RAM**: 2 GB ou mais
- **Armazenamento**: Aproximadamente 100 MB
- **PHP:** Versão 7.4 ou superior

### 3. Extensões PHP obrigatórias
- `ext-gd`
- `ext-zip`

> **Atenção:** Se aparecer erro sobre extensões como `ext-gd` ou `ext-zip`, ative-as no `php.ini`:
1. Abra o arquivo `php.ini` (no XAMPP, geralmente em `C:\xampp\php\php.ini`)
2. Procure pelas linhas:
```ini
;extension=gd
;extension=zip
```
E remova o `;` do início da linha para descomentá-las.


---

## ⚙️ Instalação do Ambiente

### 1. Instalar o XAMPP
1. Baixe o XAMPP em: [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Instale e inicie os serviços **Apache** e **MySQL** pelo Painel de Controle do XAMPP.

### 2. Configurar o Banco de Dados
1. Acesse o phpMyAdmin: `http://localhost/phpmyadmin`
2. Crie um banco de dados chamado: `estacionamento`
3. Importe o arquivo `iniciarBanco.txt` para criar as tabelas `usuarios`, `veiculos` e `estacionamentos` e inserir dados iniciais:
   - Clique no banco `estacionamento` > Aba **Importar** > Selecione `iniciarBanco.txt`
   - O arquivo iniciarBanco.txt já está programado para popular as tabelas para o usuario "1 - SUP", de forma a testar o funcionamento já de inicio sem a necessidade do cadastro de novos registros

---

## 📦 Dependências via Composer

Este projeto utiliza dependências PHP gerenciadas pelo [Composer](https://getcomposer.org/).

### Instalação das dependências

1. Instale o Composer, se ainda não tiver:  
   [https://getcomposer.org/download/](https://getcomposer.org/download/)

2. No terminal, dentro da pasta do projeto, execute:

```composer
composer install
```

3. Isso criará a pasta `vendor` e instalará todas as dependências necessárias.

---

## 🔧 Configuração do Sistema

### 1. Arquivo de Conexão (`Conexao.php`)
Confirme ou edite as credenciais de acesso:

---

## ▶️ Executando o Sistema

### 1. Copiar para o Servidor
Copie a pasta `EstacionamentoWebServidor` para o diretório `htdocs` do XAMPP:
```bash
C:\xampp\htdocs\
```

### 2. Iniciar Serviços
Abra o painel do XAMPP e inicie:
- Apache
- MySQL

### 3. Acessar no Navegador
Digite no navegador:
```
http://localhost/EstacionamentoWebServidor/login
```

---

## 🛠️ Melhorias e ajustes necessários

### 🔴 Alteração por banco de dados
> As alterações / atualizações de registro do sistema como Usuarios, Veiculos e Estacionamentos funcionam nas chamadas das funções, porém ainda **não estão funcionando corretamente** pela chamada do aplicativo, via modal. O problema está sendo investigado.

