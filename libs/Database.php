<?php
namespace App;
use Exception;
use http\Exception\InvalidArgumentException;

class Database {
    private $App;

    public function __construct($App) {
     $this->App = $App;
    }

    public function insertUser($lastname, $contact_mail, $firstname, $contact_mobile) {
        $query = "INSERT INTO tblusers (lastname, contact_mail, firstname, contact_mobile, dateofRegistration)
        VALUES (:lastname, :contact_mail, :firstname, :contact_mobile, NOW())";
        $params = [
        ':lastname' => $lastname,
        ':contact_mail' => $contact_mail,
        ':firstname' => $firstname,
        ':contact_mobile' => $contact_mobile,
        ];
        $this->App->executeNonSelect($query, $params);
        return $this->App->link->lastInsertId();
    }

    public function getCompanyPrice($company_id) {
        $query = "SELECT items.spec,item_price.item_price_id,items.item, items.packSize, items.qty, item_price.price as price_price, item_price.qty as price_qty, item_price.remarks
                    FROM item_price INNER JOIN items ON item_price.item_id = items.item_id WHERE company_id = :company_id ORDER BY item_price_id DESC";
        $params = [':company_id'=> $company_id];
        return $this->App->selectAll($query, $params);
    }

    public function tableCheck($tableName, $column, $columnValue, $columnParameter) {
        // Use placeholders for parameterized queries
        $query = "SELECT {$column} FROM {$tableName} WHERE {$column} = :{$columnParameter}";

        // Bind the parameter correctly
        $params = [
            ":{$columnParameter}" => $columnValue
        ];
        // Log or output the query for debugging purposes
        // Uncomment the following lines to debug
//         echo "Query: " . $query . PHP_EOL;
//         print_r($params);
        // Execute the query
        return $this->App->selectOne($query, $params);
    }

//    check item before inserting item
    public function checkItems($item_id,$company_id){
        $query = "SELECT count(*) FROM item_price WHERE company_id = :company_id and item_id = :item_id";
        $params = [':company_id' => $company_id, ':item_id' => $item_id];
        $count = $this->App->selectOne($query,$params);
        return $count['count(*)'];
    }

    public function getTotalPriceItems($company_id){
        $query = "SELECT IFNULL(sum(qty*price),0) as total FROM item_price WHERE company_id = :company_id";
        $params = [':company_id' => $company_id];
        if($total = $this->App->selectOne($query,$params)){
            return $total['total'];
        }
    }

    public function getSecurityRate(){
        $query = "SELECT bid_security FROM bid_security";
        if($rate = $this->App->selectOne($query,[])){
            return $rate['bid_security'];
        }else{
            return 0.30;
        }
    }

    public function  getBidedDept($commpany_id){
        $query = "SELECT DISTINCT(tbl_dept.dept) as dept, tbl_dept.dept_id FROM item_price
	                INNER JOIN items ON item_price.item_id = items.item_id INNER JOIN tbl_dept ON items.dept_id = tbl_dept.dept_id
	                INNER JOIN tbl_company ON item_price.company_id = tbl_company.company_id WHERE item_price.company_id = :company_id";
        $params = [':company_id' => $commpany_id];
        return $this->App->selectAll($query,$params);
    }

    public function printItemPrice($company_id, $dept_id = -1) {
        $query = "SELECT packSize, items.dept_id, item_price.item_id, tbl_company.company_name, items.item, items.packSize, 
              items.spec, item_price.price, item_price.qty, item_price.remarks, tbl_dept.dept, 
              items.qty AS qty_year 
              FROM item_price
              INNER JOIN items ON item_price.item_id = items.item_id
              INNER JOIN tbl_dept ON items.dept_id = tbl_dept.dept_id
              INNER JOIN tbl_company ON item_price.company_id = tbl_company.company_id
              WHERE item_price.company_id = :company_id";

        // If a specific department is chosen, modify the query and parameters
        $params = [':company_id' => $company_id];

        if($dept_id != -1) {
            $query .= " AND items.dept_id = :dept_id";
            $params[':dept_id'] = $dept_id;
        }

        return $this->App->selectAll($query, $params);
    }

    public function savePasswordResetToken($email, $resetToken, $expiry) {
        // SQL query to insert token and expiry, or update if email already exists
        $query = "INSERT INTO password_resets (email, token, expiry) 
              VALUES (:email, :token, :expiry) 
              ON DUPLICATE KEY UPDATE 
              token = VALUES(token), 
              expiry = VALUES(expiry)";

        // Bind parameters
        $params = [
            ':email' => $email,
            ':token' => $resetToken,
            ':expiry' => $expiry
        ];

        // Execute the query
        return $this->App->executeNonSelect($query, $params);
    }


    // Get the reset request by token
    public function getPasswordResetRequest($resetToken) {
        $query = "SELECT * FROM password_resets WHERE token = :token";
        $params = [':token' => $resetToken];
        return $this->App->selectOne($query, $params);
    }

    // Update the user password
    public function updateUserPassword($email, $newPassword) {
        $query = "UPDATE tblusers SET UPassword = :UPassword WHERE Username = :Username";
        $params = [':UPassword' => $newPassword, ':Username' => $email];
        return $this->App->executeNonSelect($query, $params);
    }

    // Clear the password reset token after use
    public function clearPasswordResetToken($email) {
        $query = "DELETE FROM password_resets WHERE email = :email";
        $params = [':email' => $email];
         return $this->App->executeNonSelect($query, $params);
    }

    public function checkEmailReset($email){
    $query = "SELECT EMAIL FROM employee WHERE EMAIL = :email LIMIT 1";
    $params = [':email' => $email];
    return $this->App->selectOne($query,$params);
    }
    public function calBidSec($company_id,$rate): false|float
    {
//        get total bid amount
        $totalBidAmount = $this->getTotalPriceItems($company_id);
//         validate bidAmount
        if($totalBidAmount = false){
            $totalBidAmount = 0;
        }

//        check if rate is null or not a valid number
        if(!is_numeric($rate)){
//            return "Rate can not the null or-numeric";
            throw new \InvalidArgumentException("Rate can not be null or none-numeric");
        }
        try {
//            calculate bid security amount
//            return  floatval($totalBidAmount * $rate);
            return $totalBidAmount;
        }catch (Exception $e){
//            return exception message if something goes wrong
            return $e->getMessage();
        }

    }
    public function insertItemsPrice($company_id, $item_id,$user_id){
        $result = '';
        if($this->checkItems($item_id,$company_id) == 0){

            $query = "INSERT INTO item_price (item_id, company_id, user_id) VALUES (:item_id, :company_id, :user_id)";
            $params = [':item_id'=>$item_id,
                ':company_id'=>$company_id,
                ':user_id'=>$user_id];
            $result= $this->App->executeNonSelect($query,$params);
        }
        return $result;
    }

    public function deleteItemPrice($itemPriceId){
        $query = "DELETE FROM item_price WHERE item_price_id = :item_price_id";
        $params = [':item_price_id' => $itemPriceId];
        return $this->App->executeNonSelect($query,$params);
    }
    public function updateItem($item_price_id,$column,$value,$company_id,$user_id){

            $query = "UPDATE item_price SET $column = :value,company_id = :company_id,user_id = :user_id WHERE item_price_id = :item_price_id";
            $params = [
                ':value'=>$value,
                ':item_price_id'=> $item_price_id,
                ':company_id' => $company_id,
                ':user_id' => $user_id];
            return $this->App->executeNonSelect($query,$params);
    }

    public function saveBidDocument($companyID, $filename,$documentType) {
        $path = 'uploads/bid_documents/'.$companyID.'/'.$filename;
        $sql = "INSERT INTO tbl_document (company_id, document_path,document_type) VALUES (:company_id, :document_path,:document_type)";
        $params = [':company_id'=>$companyID, ':document_path'=> $path,':document_type'=>$documentType];
        return $this->App->executeNonSelect($sql,$params);
    }

    public function deleteDocumentFile($filePath){
        if (file_exists($filePath)) {
            // Attempt to delete the file
            if (unlink($filePath)) {
                return json_encode(['status' => 'success', 'message' => 'File deleted successfully']);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Failed to delete the file']);
            }
        }else{
            return json_encode(['status' => 'error', 'message' => 'File does not exist']);
        }
    }
    public function deleteBidDocument($companyID,$documentID) {
        $filepath = $this->getBidInfo($companyID,$documentID);
        $filepath = $filepath['document_path'];
        $filepath =  __DIR__.'/../'.$filepath;
        $response = $this->deleteDocumentFile($filepath);
        $sql = "DELETE FROM tbl_document WHERE document_id = :document_id and company_id = :company_id";
        $params = [':document_id'=>$documentID, ':company_id'=> $companyID];
        return $this->App->executeNonSelect($sql,$params);

    }
        public function getBidInfo($companyID,$documentID){
            $sql = 'SELECT tbl_document.document_path,tbl_documenttype.documentType,tbl_document.document_id FROM tbl_document INNER JOIN tbl_documenttype ON tbl_document.document_type = tbl_documenttype.documentType_id 
                    WHERE company_id = :company_id AND document_id = :document_id';
            $params = [':company_id'=>$companyID,':document_id' => $documentID];
            return $this->App->selectOne($sql,$params);
        }

    public function getBidDocumentsByCompany($companyID) {
        $sql = 'SELECT tbl_document.document_path,tbl_documenttype.documentType,tbl_document.document_id FROM tbl_document INNER JOIN tbl_documenttype ON tbl_document.document_type = tbl_documenttype.documentType_id WHERE company_id = :company_id';
        $params = [':company_id'=>$companyID];
        return $this->App->selectAll($sql,$params);
    }


    public function getSelectDocutype() {
        $sql = 'SELECT documentType_id, documentType FROM tbl_documenttype';
        $params = [];
        return $this->App->selectAll($sql,$params);
    }

    public function insertUserCompany($company_id, $username_id) {
        $query = "INSERT INTO user_company (company_id, username_id)
        VALUES (:company_id, :username_id)";
        $params = [
        ':company_id' => $company_id,
        ':username_id' => $username_id
        ];
        $this->App->executeNonSelect($query, $params);
    }

    public function insertPasswordReset($email, $token, $expiry) {
        $query = "INSERT INTO password_resets (email, token, expiry)
        VALUES (:email, :token, :expiry)";
        $params = [
        ':email' => $email,
        ':token' => $token,
        ':expiry' => $expiry,
        ];
        $this->App->executeNonSelect($query, $params);
    }
    public function updatePassword($email, $password){
        $query = "UPDATE tblusers set UPassword = :UPassword where contact_mail = :contact_mail";
        $params = [
            ':UPassword' => $password,
            ':contact_mail' => $email
        ];
        $this->App->executeNonSelect($query, $params);
    }

    public function getUserByEmail($email) {
       $sql = "SELECT
            tblusers.contact_mail, 
            tblusers.UPassword, 
            tbl_company.company_name, 
            tbl_company.company_id, 
            tblusers.Id,tblusers.profile_picture, 
            tbl_company.company_tel, 
            tbl_company.company_address, 
            tbl_company.state, 
            tbl_company.lg, 
            tbl_company.email
        FROM
            user_company
            INNER JOIN
            tblusers
            ON 
                user_company.username_id = tblusers.Id
            INNER JOIN
            tbl_company
            ON 
            user_company.company_id = tbl_company.company_id WHERE user_company.status = 1 AND tbl_company.status = 1 
            AND contact_mail = :contact_mail";
       $params = [':contact_mail' => $email];
       $result = $this->App->selectOne($sql,$params);
       return $result;
    }

    public function getAvailableSubscriptions($company_id) {
        $sql = "SELECT 
            tbl_dept.dept, 
            tbl_dept.price, 
            tbl_dept.dept_id 
        FROM 
            tbl_dept
        WHERE 
            tbl_dept.dept_id NOT IN (
                SELECT DISTINCT(tbl_dept.dept_id)
                FROM
                    subscription
                INNER JOIN
                    tbl_company ON subscription.company_id = tbl_company.company_id
                INNER JOIN
                    tbl_dept ON subscription.lot_id = tbl_dept.dept_id
                INNER JOIN
                    tbl_lot ON tbl_dept.dept_id = tbl_lot.dept_id
                WHERE subscription.company_id = :company_id
            )";

        $result = $this->App->selectAll($sql,[':company_id' => $company_id]);
        return $result;
    }
    public function getUserId($email){
        $query = "SELECT id FROM tblusers WHERE contact_mail = :email";
        $params = [
            ':email' => $email
        ];
        $rows =  $this->App->selectOne($query, $params);
        return $rows['id'];
    }

    public function insertSubscription($subscriptionId, $company_id,$txRef){
        $query = "INSERT INTO subscription (lot_id, company_id, txRef, status) 
        VALUES (:lot_id, :company_id, :txRef, 1)
        ON DUPLICATE KEY UPDATE 
            lot_id = VALUES(lot_id),
            company_id = VALUES(company_id),
            status = VALUES(status)";
        $params = [':lot_id' => $subscriptionId,
        ':company_id' => $company_id,
            ':txRef'=> $txRef];
        return $this->App->ExecuteNonSelect($query, $params);
    }
    public function getSubscriptionById($dept_id){
        $query ="SELECT
                tbl_dept.price, 
                tbl_dept.dept, 
                tbl_dept.dept_id
            FROM
                tbl_dept
            WHERE dept_id = :dept_id";
        $params = [':dept_id' => $dept_id];
        return $this->App->selectOne($query, $params);
    }
    public function getCompanyNameById($company_id){
            $query ="SELECT
            tbl_company.company_name
        FROM
            tbl_company
        WHERE company_id = :company_id";
            $params = [':company_id' => $company_id];
        return $this->App->selectOne($query, $params);
    }

    public function getCompanyPhoneById($company_id){
        $query ="SELECT
            tbl_company.company_tel
        FROM
            tbl_company
        WHERE company_id = :company_id";
        $params = [':company_id' => $company_id];
        return $this->App->selectOne($query, $params);
    }

    public function getCompanyMailById($company_id){
        $query ="SELECT
            tbl_company.email
        FROM
            tbl_company
        WHERE company_id = :company_id";
        $params = [':company_id' => $company_id];
        return $this->App->selectOne($query, $params);
    }
    public function getSubscriptionDetailsByCompany($companyId){
        $query = "SELECT
                tbl_dept.dept, 
                tbl_dept.price, 
                tbl_company.company_name, 
                tbl_lot.lot_description
            FROM
                subscription
                INNER JOIN
                tbl_company
                ON 
                    subscription.company_id = tbl_company.company_id
                INNER JOIN
                tbl_dept
                ON 
                    subscription.lot_id = tbl_dept.dept_id
                INNER JOIN
                tbl_lot
                ON 
                    tbl_dept.dept_id = tbl_lot.dept_id
                WHERE subscription.company_id = :company_id";
        $params = [":company_id" => $companyId];
        return $this->App->selectAll($query, $params);
    }

    public function updateUserStatus($email){
        $query = "UPDATE user_company SET status = 1  WHERE username_id = :username_id";
        $username_id = $this->getUserId($email);
        $params = [
            ':username_id' => $username_id
        ];
        return  $this->App->executeNonSelect($query, $params);
    }


    public function updateCompanyToken($token){
        $query = "UPDATE account_token SET status = 1 WHERE token = :token";
        $params = [':token' => $token];
        $this->App->executeNonSelect($query, $params);
    }

    public function passwordReset($token){
        $query = "SELECT * FROM password_resets WHERE token = :token and expiry >= NOW()";
        $params = [
            ':token' => $token
        ];
        return $this->App->selectOne($query,$params);
    }
}
?>
