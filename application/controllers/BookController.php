<?php

/**
 * Class BookController
 */









class BookController extends Zend_Controller_Action
{

    /**
     * init method
     */
    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * call index view and fetch all  database value
     */
    public function indexAction()
    {

        session_start();

       //var_dump($_SESSION);
         $obj=$_SESSION['Zend_Auth']['storage'];
         var_dump( $obj);
         echo $obj->role;

        if($obj->role==0)
        {
            session_destroy();
            $this->_redirect('index/index');
        }

        $booksTl = new Application_Model_DbTable_Books();
        $this->view->books = $booksTl->fetchAll();
        $this->view->boo = $obj->username;
        $this->view->bo = $obj->role;
    }

    /**
     * call add view and add value in database
     * @throws Zend_Form_Exception
     */
    public function addAction()
    {


        session_start();
        $it=json_decode(json_encode($_SESSION), True);
        var_dump($_SESSION);
        foreach($it as $key=>$value)
            foreach ($value as $k=>$hh)
            {
                $username=$hh["username"];
                $role=$hh["role"];

            }
        echo $username;
        echo $role;
        if($role==0)
        {
            session_destroy();
            $this->_redirect('index/index');
        }

        if ($this->_request->isPost()) {
            $name = $_POST['name'];
            $category = htmlspecialchars($_POST['category']);
            $author = htmlspecialchars($_POST['author']);
            $price = htmlspecialchars($_POST['price']);
            $description =htmlspecialchars($_POST['description']);
            $books = new Application_Model_DbTable_Books();
            $books->addBook( $name, $category, $author,$description, $price);

            $this->view->book1=true;

        }

    }

    /**
     * call edit view and edit data in database
     * @throws Zend_Form_Exception
     */
    public function editAction()
    {
        // action body
        session_start();
        $it=json_decode(json_encode($_SESSION), True);
        foreach($it as $key=>$value)
            foreach ($value as $k=>$hh)
            {
                $username=$hh["username"];
                $role=$hh["role"];

            }
        echo $username;
        echo $role;
        if($role==0)
        {
            session_destroy();
            $this->_redirect('index/index');
        }

        if ($this->_request->isPost()) {
            $id = $this->_getParam('id', 0);
            $name = $_POST['name'];
            $category = $_POST['category'];
            $author = $_POST['author'];
            $price = $_POST['price'];

            echo $id." " .$name."  " .$category." ". $price;
              $books = new Application_Model_DbTable_Books();
              $books->updateBook($id, $name, $category, $author, $price);

            $books = new Application_Model_DbTable_Books();
            $id = $this->_getParam('id', 0);
            $this->view->book =$books->getBook($id);
              $this->view->book1=true;
        }
        else {
         $id = $this->_getParam('id', 0);
          if ($id > 0) {
        $books = new Application_Model_DbTable_Books();
        $id = $this->_getParam('id', 0);
        $this->view->book =$books->getBook($id);

    }



}


    }

    /**
     * call delete view and delete data
     * @throws Exception
     */
    public function deleteAction()
    {
        session_start();
        $it=json_decode(json_encode($_SESSION), True);
        foreach($it as $key=>$value)
            foreach ($value as $k=>$hh)
            {
                $username=$hh["username"];
                $role=$hh["role"];

            }
        echo $username;
        echo $role;
        if($role==0)
        {
            session_destroy();
            $this->_redirect('index/index');
        }
        // action body
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $albums = new Application_Model_DbTable_Books();
                $albums->deleteBook($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $books = new Application_Model_DbTable_Books();
            $this->view->book = $books->getBook($id);
        }
    }

    /**
     * call view view and display single row
     * @throws Exception
     */
    public function viewAction()
    {
        // action body
        session_start();
        $it=json_decode(json_encode($_SESSION), True);
        foreach($it as $key=>$value)
            foreach ($value as $k=>$hh)
            {
                $username=$hh["username"];
                $role=$hh["role"];

            }
        echo $username;
        echo $role;
        if($role==0)
        {
            session_destroy();
            $this->_redirect('index/index');
        }
        $books=new Application_Model_DbTable_Books();
        $id = $this->_getParam('id', 0);
        $this->view->book =$books->getBook($id);
    }

    public function reportAction()
    {
        $books=new Application_Model_DbTable_Books();
        $id = $this->_getParam('id', 0);
        $book=$books->getBook($id);
        $pdf = new Zend_Pdf();
        //$pdf->pages[] = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
        // Save document as a new file or rewrite existing document
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),16);
        $page->drawText('BOOK DETAIL', 232, 810);

        $page->drawRectangle(400, 800,70, 40, Zend_Pdf_Page::SHAPE_DRAW_STROKE );

        $page->drawText($book["id"], 210, 710);
        $page->drawText($book["name"], 210, 680);
        $page->drawText($book["category"], 210, 640);
        $page->drawText($book["author"], 210, 600);
        $page->drawText($book["description"], 87, 520);


        $page->drawText('Book_Id :', 100, 710);
        $page->drawText('Book_Name :', 100, 680);
        $page->drawText('Book_Category :', 100, 640);
        $page->drawText('Book_Author :', 100, 600);
        $page->drawText('Book_Description :', 100, 560);

        $page->setLineWidth(0.5);
        $page->drawLine(194, 800, 400, 800);
        $pdfData = $pdf->render();
        header("Content-Disposition: attachement; target=\"_blank\"; filename=bookdetail.pdf");
        header("Content-type: application/x-pdf");
        echo $pdfData;



    }

    public function bulkreportAction()
    {
        // action body
        $check = $_POST['bulkdelete'];
        $status=strcmp($check, "bulkdelete");
        if($status==0)
        {
            if ($this->_request->isPost()) {
                $name = $_POST['checkbox'];
                foreach($name as $value)
                {
                    $books=new Application_Model_DbTable_Books();
                    $books->deleteBook($value);

                }
            }
            $this->_redirect('book/index');
        }

        $check = $_POST['bulkreport'];
        $status1=strcmp($check, "bulkreport");
        if($status1==0)
        {
            $pdf = new Zend_Pdf();
            if ($this->_request->isPost()) {
                $name = $_POST['checkbox'];
                foreach($name as $value)
                {

                    $books=new Application_Model_DbTable_Books();
                    $book=$books->getBook($value);

                    $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
                    $pageHeight = $page->getHeight();
                    $pageWidth = $page->getWidth();
                    $topPos = $pageHeight - 36;
                    $page->drawRectangle(400, 800,70, 40, Zend_Pdf_Page::SHAPE_DRAW_STROKE );
                    $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES),16);
                    $page->drawText('BOOK DETAIL', 232, 810);
                    $page->drawText('Book_Id :', 100, 710);
                    $page->drawText($book["id"], 210, 710);
                    $page->drawText('Book_Name :', 100, 680);
                    $page->drawText($book["name"], 210, 680);
                    $page->drawText('Book_Category :', 100, 640);
                    $page->drawText($book["category"], 210, 640);
                    $page->drawText('Book_Author :', 100, 600);
                    $page->drawText($book["author"], 210, 600);
                    $page->drawText('Book_Description :', 100, 560);
                    $page->drawText($book["description"], 87, 520);


                    $page->setLineWidth(0.5);
                    $page->drawLine(194, 800, 400, 800);
                    $pdf->pages[] = $page;
               }

                $pdfData = $pdf->render();

                header("Content-Disposition: attachement; filename=bookdetail.pdf");
                header("Content-type: application/x-pdf");
                echo $pdfData;
        }
        }







    }


}



