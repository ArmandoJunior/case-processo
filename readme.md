<p align="center">https://cloud.docker.com/repository/docker/armandojrn/laravel-optmized </br>
docker push armandojrn/laravel-optmized:tagname
</p>


<h2>Serviço de manipulação de dados e persistência em base de dados relacional.</h2>

<h3>Requisitos utilizados:</h3>

- PHP (Laravel 6)
  
- Banco de dados relacional (postgresql)
  
- Repositório GIT
  
- Docker / Docker-compose

<h3>Instruções de instalação:</h3>
- Clonar o Projeto:
 
  git clone  https://github.com/ArmandoJunior/case-processo.git
  

- Executar os comandos:

  <strong>docker-compose logs -f</strong> (executar e aguardar finalizar a construção dos containers e a instalação do sistema antes de seguir para o próximo comando)  
  
  <strong>docker-compose up -d</strong>

  (para usar os endpoints, a primeira vez que executar o comando à cima é necessário aguardar para que todos os containers sejam criados, o framework seja instalado, atualizado e as migrations do banco sejam executadas)


  <strong>docker exec -it app bash</strong>
  
  <strong>crond -f -l 8</strong>
  
      os dois comandos à cima se devem ao fato de eu não ter conseguido automotizar a crontab no container do Alpine, portanto para que o sistema funcione corretamente é necessário deixa-lo em execução

<h3>ENDPOINT(enviar arquivo):</h3>
  POST: localhost:8000/api/files 
  
  BODY: Multipart Form NAME: 'upload' VALUE: File

  HEADER: Content-Type: multipart/form-data
  
![image](https://user-images.githubusercontent.com/28222443/116198139-fd3c5300-a70b-11eb-99d0-f1d3cd08f13f.png)

<h3>ENDPOINT(consultar arquivos enviados):</h3>
  GET: localhost:8000/api/files

  BODY: no body

  HEADER: no header
  
  ![image](https://user-images.githubusercontent.com/28222443/116198350-3a084a00-a70c-11eb-9b8f-39ee84ff8f79.png)


<h3>ENDPOINT(consultar registros higienizados):</h3>
  GET: localhost:8000/api/registries

  BODY: no body

  HEADER: no header
  
  ![image](https://user-images.githubusercontent.com/28222443/116198282-2361f300-a70c-11eb-8b78-9397f96f8ff6.png)

<h3>BANCO</h3>
- a documentação da criação do banco está do diretório /data/SQL
  
- o banco é criado de forma automatizada por meio de migration ao levantar os containers

<h3>O Sistema</h3>
- é constituído de uma API simples para receber os arquivos e um CRON que roda de 1min e 1min buscando os arquivos recebidos pela API, higienizando-os e persistindo-os no banco postgres, é possível também consultar os arquivos enviados bem como os registros já higienizados e persistidos em banco.

<h3>Meus maiores desafios</h3>
- os maiores desafios que eu encontrei foram em relação à configuração de ambiente, visto que eu não trabalho com essas configurações no meu dia a dia e acabou por tomar-me a maior parte do tempo de criação do projeto.
  
- em relação ao banco, também foi uma novidade já que eu trabalho atualmente com SQL Server e MySQL, algumas questões de configurações criaram um certo desafio.
  
- escolher a forma de persistir e higienizar um arquivo de 50 mil linhas também foi um desafio já que não é algo muito comum no meu dia a dia, não sei se a utilização de CRON para realizar foi a mais acertada, mas no momento pareceu-me a mais adequada para não travar em requisições demoradas.
  
- e por fim na leitura do arquivo txt eu optei por utilizar o Generator para não precisar aumentar a memória do servidor PHP nem limitar o tamanho do arquivo a ser lido.

