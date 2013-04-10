<?php
namespace System\Model;

/**
 * User.php
 * @author Administrator
 * @DateTime 12-12-29 上午11:43
 * @version $Id$
 */
class User
{

    public $id;
    public $artist;
    public $title;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->artist = (isset($data['artist'])) ? $data['artist'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
