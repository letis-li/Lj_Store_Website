<?php
$servername="localhost"; //endereço servidor
$username="root";
$password="";
$dbname="loginloja";//banco de dados
$conexao= new mysqli($servername,$username,$password,$dbname);
if($conexao->connect_error){
    die("Conexão perdida".$conexao->connect_error);//se a conexao falhar o processo automaticamente para (morre)
}
else{
   // echo "Conectado";
}
?>