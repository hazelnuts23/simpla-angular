<?php
if (isset($_GET)) {
    include('class/connection.class.php');
    $mysqli = connect();
    switch ($_GET['mode']) {
        case 'getAll':
            $query = "SELECT * FROM country";
            $pres = $mysqli->prepare($query);
            $pres->execute();
            $res = $pres->get_result();
            while ($data = $res->fetch_assoc()) {
                $countries[] = $data;
            }
            echo json_encode($countries);
            break;
        case 'getSpec':
            $id = $_GET['id'];
            $query = "SELECT id, name, sortname FROM country WHERE id=?";
            $pres = $mysqli->prepare($query);
            $pres->bind_param('i', $id);
            $pres->execute();
            $pres->bind_result($id, $name, $sortname);
            while ($pres->fetch()) {
                $country["id"] = $id;
                $country["name"] = $name;
                $country["sortname"] = $sortname;
            }
            echo json_encode($country);
            break;
        case 'add':
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $name = $mysqli->real_escape_string($request->name);
            $sortname = $mysqli->real_escape_string($request->sortname);
            $id = 1;
            $query = "INSERT INTO country (name, sortname, flag) VALUES (?, ?, ?)";
            $pres = $mysqli->prepare($query);
            $pres->bind_param('ssi', $name, $sortname, $id);
            if ($pres->execute()) {
                $response = array("error" => 0,
                    "id" => $mysqli->insert_id,
                    "name" => $name,
                    "sortname" => $sortname
                );
            } else if (!$pres->execute()) {
                $response = array("error" => 1);
            }
            echo json_encode($response);
            break;
        case 'edit':
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $id = $request->id;
            $name = $mysqli->real_escape_string($request->name);
            $sortname = $mysqli->real_escape_string($request->sortname);
            $query = "UPDATE country SET name = ?, sortname = ? WHERE id = ?";
            $pres = $mysqli->prepare($query);
            $pres->bind_param('ssi', $name, $sortname, $id);
            if ($pres->execute()) {
                $response = array("error" => 0,
                    "id" => $request->id,
                    "name" => $name,
                    "sortname" => $sortname
                );
            } else if (!$pres->execute()) {
                $response = array("error" => 1);
            }
            echo json_encode($response);
            break;
        case 'delete':
            $id = $_GET['id'];
            $query = "DELETE FROM country WHERE id=?";
            $pres = $mysqli->prepare($query);
            $pres->bind_param('i', $id);
            if ($pres->execute()) {
                $response = array("error" => 0,
                    "id" => $id,
                );
            } else if (!$pres->execute()) {
                $response = array("error" => 1);
            }
            echo json_encode($response);
            break;
    }
    $mysqli->close();
}
?>