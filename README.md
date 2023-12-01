# Teste prático
Teste prático para uma vaga de analista de sistemas no Grupo Integrado. O projeto foi desenvolvido utilizando o ambiente XAMPP, PHP, jQuery e Bootstrap 5.3.

## Como rodar o projeto
#### XAMPP

Primeiramente, é preciso instalar o ambiente XAMPP (cross-platform **A**pache **M**ySQL **P**HP **P**ERL) através página [apachefriends](https://www.apachefriends.org/pt_br/index.html). Então, para rodar o projeto, os servidores **MySQL Database** e **Apache Web Server** devem ser ativados na aba **Manage Servers** no painel de controle do aplicativo, como mostra a imagem a seguir. 

[<p align="center"> <img src="https://0x0.st/Hx19.png"></p>](https://www.apachefriends.org/pt_br/index.html)

Em sistemas Linux, o painel pode ser aberto através do comando 

```console
sudo /opt/lampp/manager-linux-x64.run  
```

#### jQuery e Bootstrap
Os arquivos necessários para rodar as bibliotecas jQuery e Bootstrap foram incluidas no projeto utilizando CDN. 

#### Rodando o projeto
O próximo passo é mover o repositório do projeto para o diretório /htdocs, localizado na pasta padrão do XAMPP. 
```console
git clone https://github.com/gabriel11027/dev-test
mv dev-test /opt/lampp/htdocs/
```
Então, os dois bancos de dados usados podem ser criados da seguinte forma:

```console
cd /opt/lampp;
./bin/mysql -u root -e "CREATE DATABASE ALUNOS; CREATE DATABASE CURSOS;";
./bin/mysql -u root -p ALUNOS < htdocs/dev-test/src/database/ALUNOS.sql;
./bin/mysql -u root -p CURSOS < htdocs/dev-test/src/database/CURSOS.sql
```
Finalmente, o projeto pode ser acessado [aqui](https://localhost/dev-test/src/index.html) OBS: Por padrão, a senha do LAMPP é vazia.

#### Projeto live

Alternativamente, o projeto pode ser testado live [aqui](https://dev-test-gabriel.000webhostapp.com/cursos.html)
