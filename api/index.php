<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$app->post('/user', function (Request $request, Response $response) {
        $body = $request->getBody();
        $obj=json_decode($body, true);

      require '../conn.php';
      $stmt = $conn->prepare("CALL user_add(?,?,?,?,?)");

//      $stmt->bind_param("a", "b", "c", "d", "1");
      $stmt->bind_param('sssii', $obj[username], $obj[email], password_hash($obj[password], PASSWORD_DEFAULT), $obj[studentid], $obj[stat]);
//      $stmt->bind_param('ssssi', $obj[username], $obj.email, $obj.password, $obj.studentid, $obj.stat);
      if (!$stmt->execute()){
	$response = "0";
      }else{
	$response = "1";
      }
    return  $response;// = $obj[username];
});


$app->post('/subj', function (Request $request, Response $response) {
        $body = $request->getBody();
        $obj=json_decode($body, true);

      require '../conn.php';
      $stmt = $conn->prepare("CALL subj_add(?,?,?)");

      $stmt->bind_param('sii', strtolower($obj[subjname]), $obj[subjuser], $obj[stat]);
      if (!$stmt->execute()){
	$response = "0";
      }else{
	$response = "1";
      }
    return  $response;// = $obj[username];
});


$app->post('/clas', function (Request $request, Response $response) {
        $body = $request->getBody();
        $obj=json_decode($body, true);

      require '../conn.php';
      $stmt = $conn->prepare("CALL clas_add(?,?,?,?)");

      $stmt->bind_param('siii', strtolower($obj[clasname]),$obj[classubj], $obj[clasuser], $obj[stat]);
      if (!$stmt->execute()){
	$response = "0";
      }else{
	$response = "1";
      }
    return  $response;// = $obj[username];
});


$app->post('/chap', function (Request $request, Response $response) {
        $body = $request->getBody();
        $obj=json_decode($body, true);

      require '../conn.php';
      $stmt = $conn->prepare("CALL chap_add(?,?,?,?)");

      $stmt->bind_param('siii', strtolower($obj[chapname]), $obj[chapclas], $obj[chapuser], $obj[stat]);
      if (!$stmt->execute()){
	$response = "0";
      }else{
	$response = "1";
      }
    return  $response;// = $obj[username];
});


$app->post('/ques', function (Request $request, Response $response) {
        $body = $request->getBody();
        $obj=json_decode($body, true);

      require '../conn.php';
      $stmt = $conn->prepare("CALL ques_add(?,?,?,?)");

      $stmt->bind_param('siii', strtolower($obj[questxt]), $obj[queschap], $obj[quesuser], $obj[stat]);
      if (!$stmt->execute()){
	$response = "0";
      }else{
	$response = "1";
      }
    return  $response;// = $obj[username];
});


$app->post('/answ', function (Request $request, Response $response) {
        $body = $request->getBody();
        $obj=json_decode($body, true);

      require '../conn.php';
      $stmt = $conn->prepare("CALL answ_add(?,?,?,?,?)");

      $stmt->bind_param('siiii', strtolower($obj[answtxt]),$obj[answques],$obj[answcorr], $obj[answuser], $obj[stat]);
      if (!$stmt->execute()){
	$response = "0";
      }else{
	$response = "1";
      }
    return  $response;// = $obj[username];
});


$app->get('/subj', function (Request $request, Response $response) {
//        $body = $request->getBody();
//        $obj=json_decode($body, true);

      require '../conn.php';
//      $stmt = $conn->prepare("CALL subj_get()");
      $stmt = "CALL subj_get(1)";

//      $stmt->bind_param('sii', $obj[subjname], $obj[subjuser], $obj[stat]);
      if (!$rst = $conn->query($stmt)){
	$response = "Error";
      }else{
	$rstarray = array();
//	while($row=$rst->fetch_row()){ //<--- Get a result row as an enumerated array
	while($row=$rst->fetch_assoc()){ //<---- Fetch a result row as an associative array
//		$arr=array($row[0],$row[1]);
//		$arr=array("subj_id:" . $row[subj_id], "subj_name:" . ucwords(strtolower($row[subj_name])));
		$arr=array(array("subj_id:" , $row[subj_id]),array("subj_name:" , ucwords(strtolower($row[subj_name]))));
		array_push($rstarray, $arr);
	}
	$response = json_encode($rstarray);
      }
    return $response;
});


$app->get('/clas', function (Request $request, Response $response) {
//        $body = $request->getBody();
//        $obj=json_decode($body, true);

      require '../conn.php';
//      $stmt = $conn->prepare("CALL subj_get()");
      $stmt = "CALL clas_get(1,1)";

//      $stmt->bind_param('sii', $obj[subjname], $obj[subjuser], $obj[stat]);
      if (!$rst = $conn->query($stmt)){
	$response = "Error";
      }else{
	$rstarray = array();
//	while($row=$rst->fetch_row()){ //<--- Get a result row as an enumerated array
	while($row=$rst->fetch_assoc()){ //<---- Fetch a result row as an associative array
//		$arr=array($row[0],$row[1]);
		$arr=array(array("clas_id", $row[clas_id]), array("clas_name", ucwords(strtolower($row[clas_name]))));
		array_push($rstarray, $arr);
	}
	$response = json_encode($rstarray);
      }
    return $response;
});



$app->run();
