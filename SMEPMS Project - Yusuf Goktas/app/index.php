<?php
include "box.php";

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET,PATCH,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode(file_get_contents("php://input"));
    $name = $body->data->name;
    $width = $body->data->width;
    $height = $body->data->height;
    $length = $body->data->length;

    $box = new Box(null, $name, $width, $height, $length);
    $id = $box->save();
    $db = new DB();
    $result = $db->getBoxById($id);
    header('HTTP/2 201');
    echo json_encode($result);


}elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
    $body = json_decode(file_get_contents("php://input"));
    $id = $body->data->id;
    $box = Box::getBox($id);
    $box->delete();
    header('HTTP/2 204');

}elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $db = new DB();
    $body = json_decode(file_get_contents("php://input"));
    if ($body){
        $id = $body->data->id;
        $result = $db->getBoxById($id);
        $result['volume'] = Box::getBox($id)->calculateVolume();
    }else{
        $result = $db->getAllBoxes();
        foreach ($result as &$box)
        {
            $box['volume'] = Box::getBox($box['id'])->calculateVolume();
        }
    }
    header('HTTP/2 200');
    echo  json_encode($result);
}elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH')
{
    $body = json_decode(file_get_contents("php://input"));
    $id = $body->data->id;
    $box = Box::getBox($id);

    if (isset($body->data->name))
    {
        $box->changeName($body->data->name);
    }
    if (isset($body->data->width))
    {
        $box->changeWidth($body->data->width);
    }
    if (isset($body->data->height))
    {
        $box->changeHeight($body->data->height);
    }
    if (isset($body->data->length))
    {
        $box->changeLength($body->data->length);
    }

    $box->save();
    $db = new DB();
    $result = $db->getBoxById($id);
    header('HTTP/2 200');
    echo json_encode($result);
}
