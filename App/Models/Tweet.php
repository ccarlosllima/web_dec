<?php

namespace App\Models;

use MF\Model\Model;

class Tweet extends Model 
{
    private $id;
    private $id_usuario;
    private $tweet;
    private $data;

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $value)
    {
        $this->$atributo = $value;
    }


    // salvar dados no banco

    public function salvar()
    {
        $query = "INSERT INTO tweets(id_usuario, tweet)VALUES(:id_usuario, :tweet)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
        $stmt->bindValue(':tweet',$this->__get('tweet'));
        $stmt->execute();
        return $this;
    }

    // recuperar dados do banco
    public function getAll()
    {
         
        $query = "
        SELECT 
            t.id, t.id_usuario, u.nome, t.tweet, DATE_FORMAT(t.data,'%d/%m/%y %h:%m') as data
        FROM 
            tweets as t
            left join usuarios as u on (t.id_usuario = u.id)
        WHERE
            t.id_usuario = :id_usuario
            or t.id_usuario in(select id_usuario_seguindo from usuarios_seguidores
            where id_usuario = :id_usuario)
        ORDER BY t.data desc
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function delete(){
        $query = "DELETE FROM tweets WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->execute(); 
        return $stmt->rowCount();
    }
}

?>