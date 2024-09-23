<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php' ;
require_once __DIR__ . '/../config/config.php' ;;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PDO;
use PDOException;

class App
{
    public $host = HOST;
    public $dbname = DBNAME;
    public $pass = PASS;
    public $user = DB_USER;
    public $link;

    public $host_mail = HOST_MAIL;
    public $user_mail = USERNAME_MAIL;
    public $pass_mail = PASSWORD_MAIL;
    public $from_email = FROM_EMAIL;
    public $businessName;
    public $town;
    public $state;
    public $tel;

    public $logged_in;
    public $loggeduser;
    public $SESS_MEMBER_ID;
    public $email;
    public $SESS_FIRST_NAME;
    public $SESS_LAST_NAME;

    public $role;
    public $emptrack;
    public $empDataTrack;

    public function __construct()
    {
        $this->construct();
    }

    public function construct()
    {
        try {
            $this->link = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                $this->user, $this->pass,
                array(PDO::ATTR_PERSISTENT => true));
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->startingSession();

        } catch (PDOException $e) {
            echo "Failed Connection: " . $e->getMessage();
        }
    }

    public function startingSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function sendPasswordEmail($to, $username, $password) {
        $subject = "Your New Account Details";
        $message = "Hello,\n\nYour account has been created. Here are your login details:\nUsername: $username\nPassword: $password\n\nPlease change your password after your first login.";
        $headers = "From: no-reply@example.com";

        mail($to, $subject, $message, $headers);
    }

    // New method to send email with attachment
    public function sendEmailWithAttachment($toEmail, $subject, $message, $attachmentPath = null) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP(); // Send using SMTP
            $mail->Host       = $this->host_mail; // Set the SMTP server to send through
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = $this->user_mail; // SMTP username
            $mail->Password   = $this->pass_mail; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = 587; // TCP port to connect to, adjust as needed

            // Recipients
            $mail->setFrom($this->user_mail, $this->from_email); // Adjust 'Your Name' to your desired sender name
            $mail->addAddress($toEmail); // Add recipient

            // Attachments
            if ($attachmentPath) {
                $mail->addAttachment($attachmentPath); // Add attachment
            }

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message); // Plain text alternative for non-HTML mail clients

            $mail->send();
            return "Message has been sent successfully";
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function getPages()
    {
        $query = "SELECT url, `name` FROM pages";
        return $this->selectAll($query, []);
    }

    public function getOffset() {
        $query = "SELECT last_offset FROM email_offset ORDER BY id DESC LIMIT 1";
        return $this->selectOne($query, []);
    }

    public function checkAuthentication() {
        if (!isset($_SESSION['SESS_MEMBER_ID'])) {
            header('Location: index.php');
            exit;
        }
    }

    public function getBusinessName() {
        $query = "SELECT
                    tbl_business.business_name,
                    tbl_business.town,
                    tbl_business.state,
                    tbl_business.tel 
                FROM
                    tbl_business";
        return $this->selectOne($query, []);
    }

    public function updateOffset($newOffset) {
        $query = "UPDATE email_offset SET last_offset = :newOffset ORDER BY id DESC LIMIT 1";
        $params = [':newOffset' => (int) $newOffset];
        $this->executeNonSelect($query, $params);
    }

    public function initializeOffset() {
        $query = "INSERT INTO email_offset (last_offset) VALUES (0)";
        $this->executeNonSelect($query, []);
    }

    public function selectAll($query, $array = []) {
        $rows = $this->link->prepare($query);
        $rows->execute($array);
        $allRows = $rows->fetchAll(PDO::FETCH_ASSOC);
        return $allRows ? $allRows : false;
    }

    public function executeNonSelect($query, $array = []) {
        $stmt = $this->link->prepare($query);
        return $stmt->execute($array);  // Returns true on success or false on failure
    }

    public function selectOne($query, $array = []) {
        $row = $this->link->prepare($query);
        $row->execute($array);
        $singleRow = $row->fetch(PDO::FETCH_ASSOC);
        return $singleRow ? $singleRow : false;
    }

    public function tokenCheck($token){
        $query = "SELECT * FROM account_token WHERE token = :token and status = 0";
        $params = [
            ':token' => $token
        ];
        return $this->selectOne($query,$params);
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function googlelogin($email)
    {
        $_SESSION['google_login'] = false;
        try {
            $query = $this->link->prepare('SELECT employee.name, role_id, employee.EMAIL, username.username, username.profile_picture, username.`password`, username.role, username.staff_id FROM username
                    INNER JOIN employee ON employee.staff_id = username.staff_id WHERE EMAIL = ? AND deleted = ?');
            $fin = $query->execute(array($email, '0'));

            if (isset($_SESSION['periodstatuschange'])) {
                unset($_SESSION['periodstatuschange']);
            }

            if (($row = $query->fetch())) {
                $_SESSION['logged_in'] = '1';
                $_SESSION['google_login'] = true;
                $_SESSION['user'] = $row['username'];
                $_SESSION['SESS_MEMBER_ID'] = $row['staff_id'];
                $_SESSION['profilePicture'] = $row['profile_picture'];
                $_SESSION['email'] = $row['EMAIL'];
                $_SESSION['SESS_FIRST_NAME'] = $row['name'];
                $_SESSION['SESS_LAST_NAME'] = $row['name'];
                $_SESSION['role_id'] = $row['role_id'];
                $_SESSION['emptrack'] = 0;
                $_SESSION['empDataTrack'] = 'next';
                $_SESSION['staff'] = 1;

                $this->businessInfo();

                $payp = $this->link->prepare('SELECT periodId, description, periodYear FROM payperiods WHERE active = ? ORDER BY periodId DESC LIMIT 1');
                $myperiod = $payp->execute(array(1));
                $final = $payp->fetch();
                $_SESSION['currentactiveperiod'] = $final['periodId'];
                $_SESSION['activeperiodDescription'] = $final['description'] . " " . $final['periodYear'];

                if (isset($_SESSION['periodstatuschange'])) {
                    unset($_SESSION['periodstatuschange']);
                }

                header('Location: home.php');
                exit();

            } else {
                header('Location: index.php?error=Email not Found');
                exit();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return json_encode($data);
    }

    public function login($username, $password)
    {
        $errmsg_arr = array();
        $errflag = false;

        $errors = array();      // array to hold validation errors
        $data = array();      // array to pass back data

        $uname = filter_var((filter_var($username)));
        $pass = filter_var($password);

        if ($uname == '') {
            $errmsg_arr[] = 'Username missing';
            $errflag = true;
        }
        if ($pass == '') {
            $errmsg_arr[] = 'Password missing';
            $errflag = true;
        }

        try {
            $query = $this->link->prepare('SELECT employee.name, username.profile_picture, role_id, employee.EMAIL, username.username, username.`password`, username.role, username.staff_id FROM username
                    INNER JOIN employee ON employee.staff_id = username.staff_id WHERE username = ? AND deleted = ?');
            $fin = $query->execute(array($uname, '0'));

            if (isset($_SESSION['periodstatuschange'])) {
                unset($_SESSION['periodstatuschange']);
            }

            if (($row = $query->fetch()) and (password_verify($pass, $row['password']))) {
                $_SESSION['logged_in'] = '1';
                $_SESSION['user'] = $row['username'];
                $_SESSION['SESS_MEMBER_ID'] = $row['staff_id'];
                $_SESSION['profilePicture'] = $row['profile_picture'];
                $_SESSION['email'] = $row['EMAIL'];
                $_SESSION['SESS_FIRST_NAME'] = $row['name'];
                $_SESSION['SESS_LAST_NAME'] = $row['name'];
                $_SESSION['role_id'] = $row['role_id'];
                $_SESSION['emptrack'] = 0;
                $_SESSION['empDataTrack'] = 'next';
                $_SESSION['staff'] = 1;

                $this->businessInfo();

                $payp = $this->link->prepare('SELECT periodId, description, periodYear FROM payperiods WHERE active = ? ORDER BY periodId DESC LIMIT 1');
                $myperiod = $payp->execute(array(1));
                $final = $payp->fetch();
                $_SESSION['currentactiveperiod'] = $final['periodId'];
                $_SESSION['activeperiodDescription'] = $final['description'] . " " . $final['periodYear'];

                if (isset($_SESSION['periodstatuschange'])) {
                    unset($_SESSION['periodstatuschange']);
                }

                $data['success'] = 'true';
                $data['message'] = 'Login successful';

            } else {
                $data['success'] = 'false';
                $data['message'] = 'Invalid Username and Password';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return json_encode($data);
    }
}
