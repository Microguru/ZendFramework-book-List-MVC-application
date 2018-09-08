<?php

/**
 * Class Application_Model_DbTable_Books
 */
class Application_Model_DbTable_Books extends Zend_Db_Table_Abstract
{

    protected $_name = 'books';

    /**
     * @param $name
     * @param $category
     * @param $author
     * @param $price
     */

    public function addBook($name, $category,$author,$description,$price)
    {
        $data = array(

            'name' =>$name,
            'category'=>$category,
            'author'=>$author,
            'description'=>$description,
            'price'=>$price,
        );
        $this->insert($data);
    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     */
    public function getBook($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {

//            throw new Exception("Could not find row $id");

                sleep(2);

            echo "
            <script type=\"text/javascript\">
            alert (' Access Denied ');
            window.location = 'http://localhost/ZendApp/public/book';

            </script>";
        }
        return $row->toArray();
    }

    /**
     * @param $id
     * @param $name
     * @param $category
     * @param $author
     * @param $price
     */
    public function updateBook($id,$name, $category, $author,$price)
    {
        $data = array(
            'name' =>$name,
            'category'=>$category,
            'author'=>$author,
            'price'=>$price,
        );
        $this->update($data, 'id = '. (int)$id);
    }

    /**
     * @param $id
     */
    public function deleteBook($id)
    {
        $this->delete('id =' . (int)$id);
    }
}

