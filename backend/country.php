<?php
if (isset($_GET)) {
    include('class/connection.class.php');
    $mysqli = connect();
    if ($_GET['mode'] == "getAll") {
        $query = "SELECT * FROM sp_country";
        $result = $mysqli->query($query);
        while ($data = $result->fetch_assoc()) {
            $countries[] = $data;;
        }
        echo json_encode($countries);
    } else if ($_GET['mode'] == "getSpec") {
        $query = "SELECT * FROM country WHERE id='" . $_GET['id'] . "'";
        $result = $mysqli->prepare("SELECT * FROM sp_country WHERE id='" . $_GET['id'] . "'");
        while ($data = $result->fetch_array()) {
            $country["id"] = $data["id"];
            $country["name"] = $data["name"];
            $country["sortname"] = $data["sortname"];
        }
        echo json_encode($country);
    } else if ($_GET['mode'] == 'add') {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $query = "INSERT INTO country (name, sortname, flag) VALUES ('" . $request->name . "', '" . $request->sortname . "', 1)";
        $result = $mysqli->query($query);
        if (!$mysqli->error) {
            $response = array("error" => 0,
                "id" => $mysqli->insert_id,
                "name" => $_POST['name'],
                "sortname" => $_POST['sortname']
            );
        } else {
            $response = array("error" => 1);
        }
        echo json_encode($response);
    } else if ($_GET['mode'] == 'edit') {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $query = "UPDATE country SET name='" . $request->name . "', sortname='" . $request->sortname . "' WHERE id='" . $request->id . "'";
        $result = $mysqli->query($query);
        if (!$mysqli->error) {
            $response = array("error" => 0,
                "id" => $request->id,
                "name" => $request->id,
                "sortname" => $request->sortname
            );
        } else {
            $response = array("error" => 1);
        }
        echo json_encode($response);
    }
    $mysqli->close();
}
?>