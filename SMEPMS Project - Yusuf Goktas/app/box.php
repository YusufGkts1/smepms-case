<?php
include "db.php";
class Box{
    private ?int $id;
    private string $name;
    private float $width;
    private float $height;
    private float $length;
    private DB $db;

    function __construct(
        $id,
        $name,
        $width,
        $height,
        $length
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->db = new DB();
    }
    public function changeName($name){
        $this->name = $name;
    }
    public function changeWidth($width){
        $this->width = $width;

    }
    public function changeHeight($height){
        $this->height = $height;

    }
    public function changeLength($length){
        $this->length = $length;

    }
    public function calculateVolume()
    {
        return $this->width * $this->height * $this->length;
    }
    public function save()
    {
        return $this->db->save($this->id, $this->name, $this->width, $this->height, $this->length);

    }
    public function delete()
    {
        $this->db->delete($this->id);
    }

    public static function getBox($id)
    {
        $dto = (new DB())->getBoxById($id);

        return new Box($dto['id'],$dto['name'], $dto['width'], $dto['height'], $dto['length']);
    }
}