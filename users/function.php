<?php
require('../database/dbConnection.php');

function error(){
    $data = [
        'status' => 422,
        'message' => "Some Data is Missing",
    ];
    header("HTTP/1.0 422 Some Data is Missing");
    echo json_encode($data);
    exit();
}

function getUser($paramsId){
    global $conn;

    $sql = "SELECT * FROM users where id = '$paramsId'";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => "Users Found Successfully!!",
                'data' => $res
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => "No Users Found!!"
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => "Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getUserList() {
    global $conn;

    $sql = "SELECT * FROM users";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => "Users Found Successfully!!",
                'data' => $res
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => "No Users Found!!"
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => "Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function createUser($inputData) {
    global $conn;

    $name = mysqli_real_escape_string($conn, $inputData['name']);
    $email = mysqli_real_escape_string($conn, $inputData['email']);
    $phone = mysqli_real_escape_string($conn, $inputData['phone']);

    if (!$name || !$email || !$phone) {
        return json_encode([
            'status' => 400,
            'message' => 'Invalid input data'
        ]);
    } else {
        $query = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 201,
                'message' => "User created successfully!"
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => "Internal Server Error"
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
?>
