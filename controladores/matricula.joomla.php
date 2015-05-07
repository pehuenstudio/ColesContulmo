<?php
$name = $_POST["nombre1_alumno"];
$username = $_POST["run_alumno"];
$email = $_POST["email_alumno"];
$password = $_POST["run_alumno"];
$gender = "";
registerUser($name, $username, $email, $password, $gender);
function registerUser($name, $username, $email, $password, $gender)
{
    define('_JEXEC', 1);
    define('DS', DIRECTORY_SEPARATOR);

    error_reporting(E_ALL | E_NOTICE);
    ini_set('display_errors', 1);

    define('JPATH_BASE', $_SERVER["DOCUMENT_ROOT"]);
    require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
    require JPATH_LIBRARIES.DS.'import.php';
    require JPATH_LIBRARIES.DS.'cms.php';

    JLoader::import('joomla.user.authentication');
    JLoader::import('joomla.application.component.helper');


    $mainframe = JFactory::getApplication('site');
    $mainframe->initialise();
    $user = clone(JFactory::getUser());
    //$pathway =  $mainframe->getPathway();
    $config =  JFactory::getConfig();
    $authorize =  JFactory::getACL();
    $document =  JFactory::getDocument();

    $response = array();
    $usersConfig = JComponentHelper::getParams( 'com_users' );
    //svar_dump($usersConfig);
    if($usersConfig->get('allowUserRegistration') == '1')
    {
        // Initialize new usertype setting
        jimport('joomla.user.user');
        jimport('joomla.application.component.helper');

        $useractivation = $usersConfig->get('useractivation');

        $db = JFactory::getDBO();
        // Default group, 2=registered
        $defaultUserGroup = 2;

        $acl = JFactory::getACL();

        jimport('joomla.user.helper');
        $salt     = JUserHelper::genRandomPassword(32);
        $password_clear = $password;

        $crypted  = JUserHelper::getCryptedPassword($password_clear, $salt);
        $password = $crypted.':'.$salt;
        $instance = JUser::getInstance();
        //$instance->set('id'         , 0);
        $instance->set('name'           , $name);
        $instance->set('username'       , $username);
        $instance->set('password' , $password);
        // $instance->set('password_clear' , $password_clear);
        $instance->set('email'          , $email);
        $instance->set('block', 1);
        //$instance->set('usertype'       , 'deprecated');
        $instance->set('groups'     , array("1","2"));
        // Here is possible set user profile details
        //$instance->set('profile'    , array('gender' =>  $gender));
        jimport( 'joomla.application.application' );
        // Email with activation link
        if($useractivation == 1)
        {
            $instance->set('block'    , 1);
            $instance->set('activation'    , JApplicationHelper::getHash(JUserHelper::genRandomPassword()));
        }

        if (!$instance->save())
        {
            // Email already used!!!
            // Your code here...
            echo "no se creo";
        }
        else
        {
            $db->setQuery("update z_users set email='$email' where username='$username'");
            $db->query();

            $db->setQuery("SELECT id FROM z_users WHERE email='$email'");
            $db->query();
            $newUserID = $db->loadResult();

            $user = JFactory::getUser($newUserID);

            // Everything OK!
            if ($user->id != 0)
            {
                echo "useractivation".$useractivation ;
                // Auto registration
                if($useractivation == 0)
                {

                    $emailSubject = 'Email Subject for registration successfully';
                    $emailBody = 'Email body for registration successfully';
                    $return = JFactory::getMailer()->sendMail('sender email', 'sender name', $user->email, $emailSubject, $emailBody);

                    // Your code here...
                }
                else if($useractivation == 1)
                {
                    //echo "mail :".$user->email;
                    $emailSubject = 'Email Subject for activate the account';

                    //http://test.cl/index.php/component/users/?task=registration.activate&token=
                    $user_activation_url = JURI::base().'index.php/component/users/?task=registration.activate&token=' . $user->activation;  // Append this URL in your email body
                    $emailBody = 'Email body for for activate the account<br/>'.$user_activation_url;
                    $headers  = 'From: [your_gmail_account_username]@gmail.com' . "\r\n" .
                        'MIME-Version: 1.0' . "\r\n" .
                        'Content-type: text/html; charset=utf-8';
                    $return = JFactory::getMailer()->sendMail('sender email', 'sender name', $user->email, $emailSubject, $emailBody);

                    // Your code here...
                }
            }
        }

    } else {
        // Registration CLOSED!
        // Your code here...
        echo "Registration CLOSED!";
    }
}


?>