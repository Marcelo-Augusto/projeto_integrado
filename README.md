# Cardig

Sistema web desenvolvido para o projeto integrado das matérias Desenvolvimento Web e Engenharia de Software 2 da Ufscar-Sorocaba.

### Ambiente utilizado para o desenvolvimento do sistema
* Servidor Web (AMPPS): Apache/2.4.27 (Win32) OpenSSL/1.1.0f PHP/5.6.31
* Servidor de base de dados: 5.6.37 - MySQL Community Server (GPL)
* Versão do PHP: 5.6.31

### Passos para executar o sistema
* Baixar ou clonar o arquivo dentro da pasta www do AMPPS;
* Criar um banco de dados no phpMyadmin com o nome cardapio;
* Importar o arquivo cardapio.sql no banco de dados;
* Abrir o arquivo connection.php, que está dentro da pasta connection, e editar os campos $username e $password com o usuário e senha do phpMyAdmin do computador onde se deseja executar o sistema.

### Principais endpoints do sistema
* http://{ip_servidor}/projeto_integrado-master : Abre a página de visualização dos produtos;
* http://{ip_servidor}/projeto_integrado-master/cardapio : Abre a página de visualização dos produtos;
* http://{ip_servidor}/projeto_integrado-master/cadastro : Abre a página de listagem dos produtos por categoria, para gerenciamento dos produtos (cadastro, alteração e remoção).

### Autenticação
Para poder gerenciar os produtos é necessário realizar uma autenticação. Por padrão, o arquivo cardapio.sql vem com um usuário cadastrado. Para gerenciar os produtos com esse usuário, basta preencher os campos seguintes campos com os valores:
* usuário: Super
* senha: 12345
