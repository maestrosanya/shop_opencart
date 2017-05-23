<?php

/**
 *
 */
class ModelExtensionModuleMaestro extends Model
{
    public function getPosts()
    {
        $get_posts = $this->db->query("SELECT * FROM " . DB_PREFIX . "mstr_maestro");

        $posts = [];
        //var_dump($get_posts);

        foreach ($get_posts as $item){
            $posts[] = $item;
        }

        return $posts;
    }
}