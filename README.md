## 🧑‍💻 Autor

Desenvolvido por João Victor Vieira - RA 2200880 UTFPR-PG

# Estacionamento Web Servidor

Projeto de sistema web realizado em aula na Universidade Tecnologica Federal do Parana em Ponta Grossa, desenvolvido em PHP com banco de dados MySQL. 
O projeto consiste em um sistema simples de estacionamento, contendo o cadastro de usuários, veículos e o estacionamento por si só.

**Observação**: a tela de login ainda **não está funcionando corretamente**, solução está em andamento.

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

---

## ⚙️ Instalação do Ambiente

### 1. Instalar o XAMPP
1. Baixe o XAMPP em: [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Instale e inicie os serviços **Apache** e **MySQL** pelo Painel de Controle do XAMPP.

### 2. Configurar o Banco de Dados
1. Acesse o phpMyAdmin: `http://localhost/phpmyadmin`
2. Crie um banco de dados chamado: `estacionamento`
3. Importe o arquivo `iniciarBanco.txt` para criar a tabela `usuarios` e inserir dados iniciais:
   - Clique no banco `estacionamento` > Aba **Importar** > Selecione `iniciarBanco.txt`

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
http://localhost/EstacionamentoWebServidor/views/login.php
```

---

## 🛠️ Problemas até o momento

### 🔴 Tela de Login Não Funciona
> A autenticação ainda **não está funcionando corretamente**. O problema está sendo investigado.


### 🔐 Senha Não Funciona
- Verificando a gravação da senha com hash visto que mesmo passando por um função separada para buscar as informaçoes do usuário ainda não está funcionando.

---

## 🔄 Atualizações Futuras

- [ ] Corrigir tela de login
- [ ] Implementar validações mais completas pelo lado do servidor
- [ ] Adicionar logs 

---

