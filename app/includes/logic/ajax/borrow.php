<?php

session_start();

use Dompdf\Dompdf;

require_once '../../data/user.php';
require_once '../../data/document.php';
require_once '../../data/borrow.php';
require_once '../../../config/db.php';
require_once dirname(__DIR__) . '/../../../vendor/autoload.php';

$connection = getConnection();

// The user is not loggedin

if(!isset($_SESSION['user_id']))
{
  echo json_encode(array('borrowError' => 'Vous n\'etes pas authentifié encore'));
  exit;
}

$borrow_params = $_POST['data'];
$borrow_params['userID'] = $_SESSION['user_id'];

$user = $document = array();

// The max time for the use to keep the document (in days)
define('max_doc_keep', 21);

$borrow_response = borrowDocument($borrow_params);
echo json_encode($borrow_response);
exit;

function borrowDocument($borrow_params){
  if(isDocumentAvailable($borrow_params['docID']))
  {
    if(userCanBorrow($borrow_params['userID']))
    {
      if(!isDocumentAlreadyBorrowed($borrow_params))
      {
        $borrow_data = createBorrow($borrow_params);
        return $borrow_data;
      }
      return array('borrowError' => 'Vous avez deja cette document dans vos empruntes!');
    }
    return array('borrowError' => 'Vous avez epuise votre empruntes, Vous devez ramenez une emprunte pour profiter d\'une autre!');
  }
  return array('borrowError' => 'Le document que vous shoautez emprunter n\'est existe pas ou les copies sont epuise');
}


function isDocumentAvailable($doc_id) {

  // Check if the document still exist in the database
  // And number of copies > 0
  global $document;
  $document =  getDocumentByID($doc_id);

  if(!$document)
  {
    return false;
  }

  return $document['copies_left'] > 0;
}


function userCanBorrow($user_id){
  global $user;
  
  // Check if the user has borrows left

  $user = getUserByIDOrEmail($user_id);
  $borrows_left = $user['borrows_left'];
  return $borrows_left > 0;
}

function isDocumentAlreadyBorrowed($data){
  global $connection;

  // Check if the document is not already borrowed and not returned by that user
  $user_id = $data['userID'];
  $doc_id = $data['docID'];
  
  if($stmt = $connection->prepare('SELECT * from borrows WHERe user_id=? AND doc_id=? AND status NOT IN ("retourne", "refuse") '))
  {
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $doc_id);
    $stmt->execute();
    $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return (count($borrows) > 0);
  }

}

function createBorrow($data){

  // The borrow code is the code in which the librarien will know that this
  // student has made a borrow when he goes to the library to get his book
  
  $borrow_code = uniqid();

  // The date will be stored in sql in the format (yyyy-m-d)
  $borrow_date = date('Y-m-d');
  $return_date = date('Y-m-d', strtotime($borrow_date . '+ ' . max_doc_keep . ' days'));
  $user_id = $data['userID'];
  $doc_id = $data['docID'];

  $borrowData = array(
    'borrowCode' => $borrow_code,
    'borrowDate' => $borrow_date,
    'returnDate' => $return_date
  );
  

  // Create borrow receipt
  $receiptFileUrl = generateBorrowReceipt($borrowData);

  add_borrow($user_id, $doc_id, $borrow_code, $borrow_date, $return_date, $receiptFileUrl);

  return array('receiptFileUrl' => $receiptFileUrl);
}


// Generate borrow receipt PDF file

function generateBorrowReceipt($borrowData) {
  global $user;
  global $document;

  // Create a new PDF file using dompPdf
  $receiptPdf = new Dompdf();
  $html = file_get_contents(dirname(__DIR__)  . "/../templates/receipt.html");

  // Fill the template with borrow data
  $toReplace = ['{{ code }}', '{{ borrowDate }}', '{{ returnDate }}', '{{ fullName }}', '{{ title }}'];
  $replaceWith = [$borrowData['borrowCode'], $borrowData['borrowDate'], $borrowData['returnDate'], $user['full_name'], $document['title']];
  $html = str_replace($toReplace, $replaceWith, $html);
  $receiptPdf->loadHtml($html);
  $receiptPdf->render();

  // Store file to receipts folder
  $output = $receiptPdf->output();
  $filePath = dirname(__DIR__)  . "/../../../public/assets/receipts/";
  $fileName = "recu_{$borrowData['borrowCode']}.pdf";

  file_put_contents($filePath . $fileName, $output);

  return 'http://localhost/management-of-library/public/assets/receipts/' . $fileName;
}
