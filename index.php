<?php

    require_once("./api/category.php");

    $url = explode("/",$_SERVER['QUERY_STRING']);

    header('Access-Control-Allow-Origin: application json');
    header('Content-Type: application/json');

    // version number one :

    if($url[1] == "v1"){

        // category :
        if($url[2] == 'category'){
            $category = new category();
            // method:
            if($url[3] == 'all'){
                
                $data = $category->all();

                $result = [
                    'status' => 200,
                    'data' => $data
                ];

                echo json_encode($result);

            } elseif ($url[3] == 'add') {

                header('Access-Control-Allow-Method: POST');

                $data = file_get_contents("php://input");
                $data_en = json_decode($data, true); // true for array - false for object 
            
                $res = $category->add($data_en);
            
                if ($res) {
                    $result = [
                        'status' => 201,
                        'msg' => 'Category created successfully',
                        'data' => $res  // Assuming $res is the data you want to include in the response
                    ];
                } else {
                    $result = [
                        'status' => 400,
                        'msg' => 'Error'
                    ];
                }
            
                echo json_encode($result);

            } elseif($url[3] == 'update'){

                $data = file_get_contents("php://input");
                $data_dn = json_decode($data, true); // true for array - false for object 
                $id = $data_dn['id'];
                $data = $data_dn['category'];

                $res = $category->update($data,$id);

                if ($res) {
                    $result = [
                        'status' => 201,
                        'msg' => 'Category Updated successfully',
                        'data' => $res  // Assuming $res is the data you want to include in the response
                    ];
                } else {
                    $result = [
                        'status' => 400,
                        'msg' => 'Error'
                    ];
                }

                echo json_encode($result);

            } elseif($url[3] == 'delete'){

                $data = $category->delete();

                $result = [
                    'status' => 200,
                    'data' => $data
                ];

                echo json_encode($result);

            }

        } 
    }
?>