"# pls-server" 


<!-- 
**custom project(manage_accounts.php)
**Delete employee acct(record in db manage_accounts.php)
**delete expense(record in db; create_expense.php)
**Edit expense(edit.expense.php)



================================================================================
DATABASE=>		username: root
			password: pcnp!p78

EMAIL=>			username: pcnpipls@gmail.com
			password: pcnp!p78
================================================================================


ADMINISTRATOR_ACCOUNT=> username: pcnpipls.admin
			Password: Infinity143$
		   Default Email: pcnpipls@gmail.com

FINANCE_ACCOUNT=>	username: pcnpipls.finance
			password: Ultim@te143$
		   Default Email: pcnpipls@gmail.com

TOPMANAGEMENT_ACCOUNT=> username: pcnpipls.TM
			password: Supr3me143$
		   Default Email: pcnpipls@gmail.com

AE_ACCOUNT(test)=>	username: test.AE
			password: Welcome01!
		   Default Email: pcnpipls@gmail.com

COMPANY_PASSWORD=>	10011001(for all users)


================================================================================
ADMINISTRATOR ADD ACCOUNT
================================================================================
Default password for new employee account: Welcome01!
			  Company pincode: 10011001

This default password and company pincode will be automatically sent to the email given by the employee 

--
-- Database: `project_liquidation`
--
CREATE DATABASE IF NOT EXISTS `project_liquidation` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `project_liquidation`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `assign_project_to_employee` (IN `i_empid` INT(5), IN `i_projid` INT(7))  BEGIN

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	ROLLBACK;
END;

START TRANSACTION;

INSERT INTO `pls_empproj` VALUES (i_empid, i_projid);

COMMIT;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_reimbursement` (IN `u_reimb_id` VARCHAR(20), IN `reimb_id` VARCHAR(20), IN `proj_id` INT(7), IN `i_date` DATE)  BEGIN

DECLARE proj INT;
DECLARE reimb INT;

SET proj = proj_id;

SELECT `created_pls_reimb`.`ReimbID` INTO reimb FROM `created_pls_reimb` WHERE `created_pls_reimb`.`ReimbID` = u_reimb_id;


IF (proj != 0) THEN

UPDATE `pls_reimb` SET `ReimbID` = u_reimb_id WHERE `ReimbID` = reimb_id;

END IF;


IF (reimb = u_reimb_id) THEN

UPDATE `pls_reimb` SET `ReimbID` = u_reimb_id WHERE `ReimbID` = reimb_id;

ELSE

INSERT INTO `created_pls_reimb` (`ReimbID`,`DateSubmitted`,`ProjectID`) VALUES (u_reimb_id,i_date,proj_id);

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_reimbursement` (IN `i_empid` INT(5), IN `i_projid` INT(7), IN `i_reimbid` INT(9), IN `i_expid` INT(11))  BEGIN

START TRANSACTION;

INSERT INTO deleted_pls_reimb SELECT * FROM pls_reimb WHERE EmployeeID = i_empid AND ProjectID = i_projid AND ReimbID = i_reimbid AND ExpenseID = i_expid;

DELETE FROM pls_reimb WHERE EmployeeID = i_empid AND ProjectID = i_projid AND ReimbID = i_reimbid AND ExpenseID = i_expid;

COMMIT;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `done` (IN `reimb` VARCHAR(20))  NO SQL
BEGIN

DECLARE Acctg INT(1);
DECLARE Mgmt INT(1);

SELECT DISTINCT `ApprovedAcctg` INTO Acctg FROM `pls_reimb` WHERE `ReimbID` = reimb;

SELECT DISTINCT `ApprovedMgmt` INTO Mgmt FROM `pls_reimb` WHERE `ReimbID` = reimb;

IF (Acctg = 1 AND Mgmt = 1) THEN

	UPDATE `created_pls_reimb` SET `Status`= '1' WHERE `ReimbID` = reimb;
    
END IF;
    
IF (Acctg = 0 OR Mgmt = 0) THEN

	UPDATE `created_pls_reimb` SET `Status`= '0' WHERE `ReimbID` = reimb;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_employee` (IN `id` INT(20), IN `i_last` VARCHAR(255), IN `i_first` VARCHAR(255), IN `i_mid` VARCHAR(255), IN `i_suffix` VARCHAR(255), IN `i_position` VARCHAR(255), IN `i_username` VARCHAR(255), IN `i_lvl` INT(1), IN `i_email` VARCHAR(255))  NO SQL
BEGIN


UPDATE 	`pls_employee`,
		`pls_empaccount`
SET
        `pls_employee`.`LastName` = i_last,
        `pls_employee`.`FirstName` = i_first,
        `pls_employee`.`MiddleName` = i_mid,
        `pls_employee`.`Suffix` = i_suffix,
        `pls_employee`.`Position` = i_position,
        `pls_employee`.`Email` = i_email,
        `pls_empaccount`.`AccountUser` = i_username,
        `pls_empaccount`.`usrlvl` = i_lvl
WHERE	`pls_employee`.`EmployeeID` = `pls_empaccount`.`EmployeeID` AND `pls_employee`.`EmployeeID` = id;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_employee_get_details` (IN `empid` INT(20))  NO SQL
BEGIN


SELECT 	`pls_employee`.`EmployeeID`,
        `pls_employee`.`LastName`,
        `pls_employee`.`FirstName`,
        `pls_employee`.`MiddleName`,
        `pls_employee`.`Suffix`,
        `pls_employee`.`Position`,
        `pls_employee`.`Email`,
        `pls_empaccount`.`AccountUser`,
        `pls_empaccount`.`usrlvl`
FROM	`pls_empaccount`,
		`pls_employee`
WHERE	`pls_employee`.`EmployeeID` = `pls_empaccount`.`EmployeeID` AND `pls_employee`.`EmployeeID` = empid;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_acct_approve` (IN `reimb` VARCHAR(20))  NO SQL
BEGIN

UPDATE `pls_reimb` SET `ApprovedAcctg`= '1' WHERE `ReimbID` = reimb;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_acct_disapprove` (IN `reimb` VARCHAR(20))  NO SQL
BEGIN

UPDATE `pls_reimb` SET `ApprovedAcctg`= '0' WHERE `ReimbID` = reimb;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_acct_edit_reimbursement` (IN `id` INT, IN `val` INT)  NO SQL
BEGIN

UPDATE `pls_expense` SET `ExpenseAmount` = val WHERE `ExpenseID` = id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_acct_get_created_reimbursement` ()  NO SQL
BEGIN

SELECT `created_pls_reimb`.`ReimbID`,`created_pls_reimb`.`DateSubmitted`,`pls_project`.`ProjectTitle`,`created_pls_reimb`.`Status` FROM `created_pls_reimb`,`pls_project` WHERE `pls_project`.`ProjectID` = `created_pls_reimb`.`ProjectID` ORDER BY `created_pls_reimb`.`DateSubmitted` DESC;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_acct_reimbursementform_expenses` (IN `reimb` VARCHAR(20))  NO SQL
BEGIN

SELECT DISTINCT `pls_expense`.`ExpenseID`,`pls_expense`.`ExpenseDesc`, `pls_expense`.`ExpenseAmount`, `pls_expensetype`.`TypeDesc` FROM `pls_expense`, `pls_expensetype`, `pls_reimb`, `created_pls_reimb` WHERE (`pls_expense`.`ExpenseType` = `pls_expensetype`.`TypeCode` AND `pls_reimb`.`ReimbID` = `created_pls_reimb`.`ReimbID`) AND `pls_reimb`.`ProjectID` = `created_pls_reimb`.`ProjectID` AND `pls_reimb`.`ExpenseID` = `pls_expense`.`ExpenseID` AND (`created_pls_reimb`.`ReimbID` = reimb) ORDER BY `pls_expensetype`.`TypeDesc`;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_mgmt_approve` (IN `reimb` VARCHAR(20))  NO SQL
BEGIN

UPDATE `pls_reimb` SET `ApprovedMgmt`= '1' WHERE `ReimbID` = reimb;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_mgmt_disapprove` (IN `reimb` VARCHAR(20))  NO SQL
BEGIN

UPDATE `pls_reimb` SET `ApprovedMgmt`= '0' WHERE `ReimbID` = reimb;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_mgmt_get_created_reimbursement` ()  NO SQL
BEGIN

SELECT DISTINCT `created_pls_reimb`.`ReimbID`,`created_pls_reimb`.`DateSubmitted`,`pls_project`.`ProjectTitle`,`created_pls_reimb`.`Status` FROM `created_pls_reimb`,`pls_project`,`pls_reimb` WHERE `pls_project`.`ProjectID` = `created_pls_reimb`.`ProjectID` AND `pls_reimb`.`ReimbID` = `created_pls_reimb`.`ReimbID` AND `pls_reimb`.`ApprovedAcctg` = '1' ORDER BY `created_pls_reimb`.`DateSubmitted` DESC;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `for_acct_reimbursementform_details` (IN `reimb` VARCHAR(20))  NO SQL
BEGIN

SELECT DISTINCT `created_pls_reimb`.`ReimbID`,`created_pls_reimb`.`DateSubmitted`,`created_pls_reimb`.`Status`,`pls_project`.`ProjectTitle`,`pls_reimb`.`ApprovedAcctg`,`pls_reimb`.`ApprovedMgmt`,`pls_employee`.`LastName`,`pls_employee`.`FirstName`,`pls_employee`.`MiddleName`,`pls_employee`.`Suffix` FROM `pls_employee`,`created_pls_reimb`,`pls_reimb`,`pls_project` WHERE `pls_reimb`.`ReimbID` = `created_pls_reimb`.`ReimbID` AND `pls_project`.`ProjectID` = `pls_reimb`.`ProjectID` AND `pls_employee`.`EmployeeID` = `pls_reimb`.`EmployeeID` AND `created_pls_reimb`.`ReimbID` = reimb;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_area_executive` ()  NO SQL
SELECT 	`pls_employee`.`EmployeeID`,
        `pls_employee`.`LastName`,
        `pls_employee`.`FirstName`,
        `pls_employee`.`MiddleName`,
        `pls_employee`.`Suffix`,
        `pls_employee`.`Email`,
        `pls_employee`.`Position`,
        `pls_empaccount`.`AccountUser`
FROM	`pls_empaccount`,
		`pls_employee`
WHERE	`pls_employee`.`EmployeeID` = `pls_empaccount`.`EmployeeID` AND
`pls_empaccount`.`usrlvl` = '1'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_created_reimbursement` (IN `emp_id` INT(7))  BEGIN

SELECT DISTINCT `created_pls_reimb`.`ReimbID`,`created_pls_reimb`.`DateSubmitted`,`pls_project`.`ProjectTitle`,`created_pls_reimb`.`Status` FROM `created_pls_reimb`,`pls_reimb`,`pls_project` WHERE `pls_project`.`ProjectID` = `created_pls_reimb`.`ProjectID` AND `created_pls_reimb`.`ProjectID` = `pls_reimb`.`ProjectID`  AND `created_pls_reimb`.`ReimbID` = `pls_reimb`.`ReimbID` AND `pls_reimb`.`EmployeeID` = emp_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_employee` ()  NO SQL
SELECT 	`pls_employee`.`EmployeeID`,
        `pls_employee`.`LastName`,
        `pls_employee`.`FirstName`,
        `pls_employee`.`MiddleName`,
        `pls_employee`.`Suffix`,
        `pls_employee`.`Position`,
         `pls_employee`.`Email`,
        `pls_empaccount`.`AccountUser`
FROM	`pls_empaccount`,
		`pls_employee`
WHERE	`pls_employee`.`EmployeeID` = `pls_empaccount`.`EmployeeID`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_expense_types` ()  BEGIN

SELECT * FROM pls_expensetype;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_projects` (IN `i_empid` INT(5))  SELECT `pls_project`.`ProjectID`, `pls_project`.`ProjectTitle` FROM `pls_project` INNER JOIN `pls_empproj` ON `pls_project`.`ProjectID` = `pls_empproj`.`ProjectID` WHERE `pls_empproj`.`EmployeeID` = i_empid$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_project_no_assigned` ()  NO SQL
SELECT	`pls_project`.`ProjectID`,
		`pls_project`.`ProjectTitle`,
        `pls_project`.`ProjectDescription`
FROM	`pls_project`
WHERE	`pls_project`.`ProjectID` NOT IN
		(SELECT `pls_empproj`.`ProjectID` FROM `pls_empproj`)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reimbursements` (IN `i_empid` INT(5), IN `i_projid` INT(7))  BEGIN

DECLARE reimb INT;

SET reimb = CONCAT(i_empid,i_projid);

SELECT `pls_expense`.`ExpenseID`, `pls_expense`.`ExpenseDesc`, `pls_expense`.`ExpenseType`, `pls_expense`.`ExpenseAmount` FROM `pls_expense`,`pls_reimb` WHERE `pls_reimb`.`ExpenseID` = `pls_expense`.`ExpenseID`AND `pls_reimb`.`ReimbID` = reimb;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_employee` (IN `i_last` VARCHAR(255), IN `i_first` VARCHAR(255), IN `i_mid` VARCHAR(255), IN `i_suffix` VARCHAR(5), IN `i_position` VARCHAR(255), IN `i_username` VARCHAR(255), IN `i_password` VARCHAR(255), IN `i_lvl` CHAR(1), IN `i_email` VARCHAR(255))  BEGIN

DECLARE lastEmpId INT UNSIGNED DEFAULT 0;

DECLARE EXIT HANDLER FOR 1062 
    BEGIN
        ROLLBACK;
    END;
    
START TRANSACTION;

INSERT INTO pls_employee 
(
    `LastName`, 
    `FirstName`, 
    `MiddleName`, 
    `Suffix`,
    `Email`,
    `Position`
) 
VALUES 
(
    i_last, 
    i_first, 
    i_mid, 
    i_suffix,
     i_email,
    i_position
);

SELECT Max(`EmployeeID`) INTO lastEmpId FROM pls_employee;

INSERT INTO pls_empaccount
VALUES (lastEmpId, i_username, i_password, lastEmpId,i_lvl);


COMMIT;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_expense` (IN `i_description` VARCHAR(255), IN `i_date` DATE, IN `i_amount` DECIMAL(10,2))  INSERT INTO pls_expense 
(
    `DatePrepared`, 
    `ExpenseDesc`, 
    `ExpenseAmount`
    ) 
VALUES 
(
    i_date, 
    i_description, 
    i_amount
    )$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_project` (IN `i_name` VARCHAR(255), IN `i_desc` VARCHAR(255))  BEGIN

INSERT INTO `pls_project` VALUES (null, i_name, i_desc, 0);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_reimb` (IN `resultInt` INT(11), IN `i_empid` INT(5), IN `i_projid` INT(7), IN `i_dateprepd` DATE, IN `i_reimbid` VARCHAR(20))  BEGIN

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	SELECT SQLEXCEPTION.message;
END;

INSERT INTO `pls_reimb` VALUES (i_reimbid, resultInt, i_empid, i_projid, i_dateprepd,0,0,0);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_reimbursement` (IN `i_empid` INT(5), IN `i_projid` INT(7), IN `i_dateprepd` DATE, IN `i_desc` VARCHAR(255), IN `i_amount` DECIMAL(10,2), IN `i_type` VARCHAR(255), IN `i_reimbid` VARCHAR(20))  BEGIN
DECLARE resultInt INT;

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	SELECT SQLEXCEPTION.message;
END;

SET resultInt = insert_expense_fn(i_empid, i_dateprepd, i_desc, i_amount, i_type);
    
CALL insert_reimb(resultInt, i_empid, i_projid, i_dateprepd, i_reimbid);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reimbursementform_expenses` (IN `emp_id` INT(7), IN `reimb_id` VARCHAR(20))  NO SQL
BEGIN

SELECT DISTINCT `pls_expense`.`ExpenseDesc`,
`pls_expense`.`ExpenseAmount`,
`pls_expensetype`.`TypeDesc` 
FROM 
`pls_expense`,
`pls_expensetype`,
`pls_reimb`,
`created_pls_reimb`
 WHERE 
(`pls_expense`.`ExpenseType` = `pls_expensetype`.`TypeCode` AND 
`pls_reimb`.`ReimbID` = `created_pls_reimb`.`ReimbID`) AND 
`pls_reimb`.`ProjectID` = `created_pls_reimb`.`ProjectID` AND 
`pls_reimb`.`ExpenseID` = `pls_expense`.`ExpenseID` AND
(`pls_expense`.`EmployeeID` = emp_id AND 
`created_pls_reimb`.`ReimbID` = reimb_id) ORDER BY `pls_expensetype`.`TypeDesc`;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reimbursementform_details` (IN `emp_id` INT(7), IN `reimb_id` VARCHAR(20))  NO SQL
BEGIN

SELECT DISTINCT `created_pls_reimb`.`ReimbID`,`created_pls_reimb`.`DateSubmitted`,`created_pls_reimb`.`Status`,`pls_project`.`ProjectTitle`,`pls_reimb`.`ApprovedAcctg`,`pls_reimb`.`ApprovedMgmt`,`pls_employee`.`LastName`,`pls_employee`.`FirstName`,`pls_employee`.`MiddleName`,`pls_employee`.`Suffix` FROM `pls_employee`,`created_pls_reimb`,`pls_reimb`,`pls_project` WHERE `pls_reimb`.`ReimbID` = `created_pls_reimb`.`ReimbID` AND `pls_project`.`ProjectID` = `pls_reimb`.`ProjectID` AND `pls_employee`.`EmployeeID` = `pls_reimb`.`EmployeeID` AND `pls_reimb`.`EmployeeID` = emp_id AND `created_pls_reimb`.`ReimbID` = reimb_id;

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `change_password` (`i_empid` INT(5), `i_oldpass` VARCHAR(255), `i_newpass` VARCHAR(255)) RETURNS INT(11) NO SQL
BEGIN

	DECLARE pass_to_comp VARCHAR(255);

	SELECT `AccountPass` INTO pass_to_comp FROM `pls_empaccount` WHERE `EmployeeID` = i_empid;
	
    IF TRUE THEN
    	UPDATE `pls_empaccount` SET `AccountPass` = i_newpass WHERE `EmployeeID` = i_empid;
        
        RETURN true;
    ELSE
    	RETURN false;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `forgot_password` (`i_empid` INT(20), `i_newpass` VARCHAR(255)) RETURNS INT(11) NO SQL
BEGIN

	DECLARE pass_to_comp VARCHAR(255);

	SELECT `AccountPass` INTO pass_to_comp FROM `pls_empaccount` WHERE `EmployeeID` = i_empid;
	
    IF TRUE THEN
    	UPDATE `pls_empaccount` SET `AccountPass` = i_newpass WHERE `EmployeeID` = i_empid;
        
        RETURN true;
    ELSE
    	RETURN false;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_latest_reimbursement` (`i_empid` INT(5), `i_projid` INT(7)) RETURNS INT(11) BEGIN
	DECLARE iShallReturn INT;
    
    SELECT MAX(`ReimbID`) INTO iShallReturn FROM `pls_reimb` WHERE `EmployeeID` = i_empid AND `ProjectID` = i_projid AND `Summarized` = 0;
    
    RETURN iShallReturn;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `insert_expense_fn` (`i_employeeid` INT(5), `i_date` DATE, `i_description` VARCHAR(255), `i_amount` DECIMAL(10,2), `i_type` VARCHAR(255)) RETURNS INT(11) BEGIN
DECLARE lastReturnID INT UNSIGNED;

INSERT INTO `pls_expense` 
(
    `ExpenseDesc`,
    `DatePrepared`,
    `ExpenseAmount`,
    `EmployeeID`,
    `ExpenseType`
    ) 
VALUES 
(
    i_description,
    i_date,
    i_amount,
    i_employeeid,
    i_type
    );
    
SELECT Max(`ExpenseID`) INTO lastReturnID 
FROM pls_expense;

RETURN lastreturnID;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `login` (`i_username` VARCHAR(255), `i_password` VARCHAR(255)) RETURNS VARCHAR(255) CHARSET latin1 BEGIN

DECLARE user_to_comp VARCHAR(255);

SELECT `AccountUser` INTO user_to_comp FROM `pls_empaccount` WHERE `AccountUser` = i_username;

IF BINARY(user_to_comp) = BINARY(i_username) THEN
	RETURN (SELECT `EmployeeID` FROM `pls_empaccount` WHERE `AccountUser` = i_username);
ELSE 
	RETURN '-1';
END IF;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `usrlvl` (`i_username` VARCHAR(255), `i_password` VARCHAR(255)) RETURNS INT(1) NO SQL
BEGIN

DECLARE user_to_comp VARCHAR(255);

SELECT `AccountUser` INTO user_to_comp FROM `pls_empaccount` WHERE `AccountUser` = i_username;

IF BINARY(user_to_comp) = BINARY(i_username) THEN
	RETURN (SELECT `usrlvl` FROM `pls_empaccount` WHERE `AccountUser` = i_username);
ELSE 
	RETURN '-1';
END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `created_pls_reimb`
--

CREATE TABLE `created_pls_reimb` (
  `ReimbID` varchar(20) NOT NULL,
  `DateSubmitted` date NOT NULL,
  `ProjectID` int(7) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_pls_reimb`
--

CREATE TABLE `deleted_pls_reimb` (
  `EmployeeID` int(5) NOT NULL,
  `ProjectID` int(7) NOT NULL,
  `ReimbID` int(20) NOT NULL,
  `ExpenseID` int(11) NOT NULL,
  `DatePrepared` datetime NOT NULL,
  `ApproverID` int(5) NOT NULL,
  `Approved` tinyint(1) NOT NULL,
  `Summarized` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pls_empaccount`
--

CREATE TABLE `pls_empaccount` (
  `AccountID` int(5) NOT NULL,
  `AccountUser` varchar(255) NOT NULL,
  `AccountPass` varchar(255) NOT NULL,
  `EmployeeID` int(5) NOT NULL,
  `usrlvl` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pls_empaccount`
--

INSERT INTO `pls_empaccount` (`AccountID`, `AccountUser`, `AccountPass`, `EmployeeID`, `usrlvl`) VALUES
(8, 'pcnpipls.finance', '$2a$10$21fa5a29da36a27d81722ueWy5nf7.a7EkJe7Hp16839JrouSICJW', 8, '2'),
(9, 'pcnpipls.TM', '$2a$10$21fa5a29da36a27d81722ueWy5nf7.a7EkJe7Hp16839JrouSICJW', 9, '3'),
(11, 'test.AE', '$2a$10$f82514eb6f32a04c68748OTqVheOmAjssLbtAeX9Cw0nkwywlAUbq', 11, '1'),
(16, 'pcnpipls.admin', '$2a$10$b24eda43ea2c3e1312e76etB0aKlJVg90K9WP5ENxJZLFzrgOnDsq', 16, '4');

-- --------------------------------------------------------

--
-- Table structure for table `pls_employee`
--

CREATE TABLE `pls_employee` (
  `EmployeeID` int(5) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleName` varchar(255) DEFAULT NULL,
  `Suffix` varchar(5) DEFAULT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pls_employee`
--

INSERT INTO `pls_employee` (`EmployeeID`, `LastName`, `FirstName`, `MiddleName`, `Suffix`, `Position`, `Email`) VALUES
(8, 'Finance', 'PCN', '', '', 'Accountant', 'pcnpipls@gmail.com'),
(9, 'TM', 'PCN', '', '', 'Top Management', 'pcnpipls@gmail.com'),
(11, 'AE', 'test', '', '', 'Area Executive', 'pcnpipls@gmail.com'),
(16, 'Admin', 'PCN', '', '', 'Administrator', 'pcnpipls@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pls_empproj`
--

CREATE TABLE `pls_empproj` (
  `EmployeeID` int(5) NOT NULL,
  `ProjectID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pls_empproj`
--

INSERT INTO `pls_empproj` (`EmployeeID`, `ProjectID`) VALUES
(7, 3),
(7, 4),
(11, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pls_expense`
--

CREATE TABLE `pls_expense` (
  `ExpenseID` int(9) NOT NULL,
  `DatePrepared` date NOT NULL,
  `ExpenseDesc` varchar(255) NOT NULL,
  `ExpenseAmount` decimal(10,2) NOT NULL,
  `EmployeeID` int(5) NOT NULL,
  `ExpenseType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pls_expensetype`
--

CREATE TABLE `pls_expensetype` (
  `TypeCode` varchar(4) NOT NULL,
  `TypeDesc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pls_expensetype`
--

INSERT INTO `pls_expensetype` (`TypeCode`, `TypeDesc`) VALUES
('C1', 'Communication'),
('F1', 'Food'),
('H1', 'Hotel'),
('M1', 'Manpower'),
('S1', 'Supplies'),
('T1', 'Transportation'),
('V1', 'Vehicle');

-- --------------------------------------------------------

--
-- Table structure for table `pls_project`
--

CREATE TABLE `pls_project` (
  `ProjectID` int(7) NOT NULL,
  `ProjectTitle` varchar(255) NOT NULL,
  `ProjectDescription` varchar(255) DEFAULT NULL,
  `Done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pls_project`
--

INSERT INTO `pls_project` (`ProjectID`, `ProjectTitle`, `ProjectDescription`, `Done`) VALUES
(3, 'PRE ORAL', 'ETO TANGINA', 0),
(4, 'MID-TERM', 'HOLY SHIT WANT KO NA MAGBAKASYON', 0),
(5, 'Tukmol Project Inc.', 'Katukmolan Project', 0),
(6, 'Katokmulan Proj.', 'Gayish Inc.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pls_reimb`
--

CREATE TABLE `pls_reimb` (
  `ReimbID` varchar(20) NOT NULL,
  `ExpenseID` int(11) NOT NULL,
  `EmployeeID` int(5) NOT NULL,
  `ProjectID` int(7) NOT NULL,
  `DatePrepared` date NOT NULL,
  `ApprovedAcctg` tinyint(1) NOT NULL,
  `ApprovedMgmt` tinyint(1) NOT NULL,
  `Summarized` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pls_summary`
--

CREATE TABLE `pls_summary` (
  `SummaryID` int(9) NOT NULL,
  `EmployeeID` int(5) NOT NULL,
  `ProjectID` int(7) NOT NULL,
  `ReimbID` int(20) NOT NULL,
  `VoucherID` int(10) NOT NULL,
  `ApproverID` int(5) NOT NULL,
  `Approved` enum('-1','0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pls_voucher`
--

CREATE TABLE `pls_voucher` (
  `VoucherID` int(10) NOT NULL,
  `VoucherDesc` varchar(1000) NOT NULL,
  `TotalAmount` double NOT NULL,
  `DatePrepared` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pls_zip_code`
--

CREATE TABLE `pls_zip_code` (
  `id` int(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `process_log`
--

CREATE TABLE `process_log` (
  `ReimbID` int(20) NOT NULL,
  `EmployeeID` int(5) NOT NULL,
  `Process` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `created_pls_reimb`
--
ALTER TABLE `created_pls_reimb`
  ADD PRIMARY KEY (`ReimbID`,`DateSubmitted`,`ProjectID`);

--
-- Indexes for table `deleted_pls_reimb`
--
ALTER TABLE `deleted_pls_reimb`
  ADD PRIMARY KEY (`EmployeeID`,`ProjectID`,`ReimbID`,`ExpenseID`);

--
-- Indexes for table `pls_empaccount`
--
ALTER TABLE `pls_empaccount`
  ADD PRIMARY KEY (`AccountID`),
  ADD UNIQUE KEY `AccountUser` (`AccountUser`);

--
-- Indexes for table `pls_employee`
--
ALTER TABLE `pls_employee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `pls_empproj`
--
ALTER TABLE `pls_empproj`
  ADD UNIQUE KEY `EmployeeID` (`EmployeeID`,`ProjectID`),
  ADD UNIQUE KEY `unique_index` (`EmployeeID`,`ProjectID`);

--
-- Indexes for table `pls_expense`
--
ALTER TABLE `pls_expense`
  ADD PRIMARY KEY (`ExpenseID`);

--
-- Indexes for table `pls_expensetype`
--
ALTER TABLE `pls_expensetype`
  ADD PRIMARY KEY (`TypeCode`);

--
-- Indexes for table `pls_project`
--
ALTER TABLE `pls_project`
  ADD PRIMARY KEY (`ProjectID`);

--
-- Indexes for table `pls_reimb`
--
ALTER TABLE `pls_reimb`
  ADD PRIMARY KEY (`ReimbID`,`ExpenseID`,`EmployeeID`,`ProjectID`),
  ADD UNIQUE KEY `ExpenseID_2` (`ExpenseID`,`ProjectID`),
  ADD KEY `ProjectID` (`ProjectID`),
  ADD KEY `ExpenseID` (`ExpenseID`),
  ADD KEY `ExpenseID_3` (`ExpenseID`,`EmployeeID`,`ProjectID`);

--
-- Indexes for table `pls_summary`
--
ALTER TABLE `pls_summary`
  ADD PRIMARY KEY (`SummaryID`);

--
-- Indexes for table `pls_voucher`
--
ALTER TABLE `pls_voucher`
  ADD PRIMARY KEY (`VoucherID`);

--
-- Indexes for table `pls_zip_code`
--
ALTER TABLE `pls_zip_code`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pls_empaccount`
--
ALTER TABLE `pls_empaccount`
  MODIFY `AccountID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `pls_employee`
--
ALTER TABLE `pls_employee`
  MODIFY `EmployeeID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `pls_expense`
--
ALTER TABLE `pls_expense`
  MODIFY `ExpenseID` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pls_project`
--
ALTER TABLE `pls_project`
  MODIFY `ProjectID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pls_summary`
--
ALTER TABLE `pls_summary`
  MODIFY `SummaryID` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pls_voucher`
--
ALTER TABLE `pls_voucher`
  MODIFY `VoucherID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pls_zip_code`
--
ALTER TABLE `pls_zip_code`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-->
