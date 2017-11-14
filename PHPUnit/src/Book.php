<?php
namespace Src;
class Book
{
    private $book=array();
    public function pushBook($bookId,$bookName)
    {
        if ($bookId && $bookName) {
            $this->book[$bookId] = $bookName;
        }
    }
    public function getBook($bookId)
    {
        return $this->book[$bookId];
    }
}