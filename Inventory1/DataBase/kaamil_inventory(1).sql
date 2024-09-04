-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2023 at 06:15 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kaamil_inventory`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `accounts_sp` (IN `_account_no` INT, IN `_bank_name` VARCHAR(100), IN `_bal` FLOAT, IN `_user_id` INT, IN `_date` DATE)   BEGIN

IF EXISTS(SELECT * FROM accounts a WHERE a.account_no = _account_no AND A.bank_name = _bank_name)THEN
SELECT CONCAT('danger|',_account_no,' In This ',_bank_name,' Was Already Registered');

ELSE
INSERT INTO `accounts`(`account_no`, `bank_name`, `balance`, `user_id`, `RegDate`) 
VALUES (_account_no, _bank_name, _bal, _user_id, _date);
SELECT CONCAT('success|',_account_no,' In This ',_bank_name,' Registered');
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `chart_reports_sp` (IN `_action` TEXT, IN `_cust_id` VARCHAR(100), IN `_text` TEXT)   BEGIN
SET @no = 0;
IF(_action = 'todayorders')THEN
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,C.tell `Tell`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,o.total_price`Total`,o.RegDate`Date` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
WHERE o.order_id NOT IN(SELECT receipt.order_id FROM receipt) AND
( o.cust_id LIKE CONCAT('%',_cust_id,'%') OR c.cust_name LIKE CONCAT('%',_cust_id,'%') OR c.tell LIKE CONCAT('%',_cust_id,'%') )
AND o.status=1 AND o.RegDate=date(now());

ELSEIF(_action = 'Users')THEN
SELECT user_id `ID`, e.emp_name`Name`, username`Username`, password`Password`,gender`Gender`, IF(u.status = 1,'Active','In Active')`Status`, u.RegDate`Date` FROM users u JOIN employee e ON e.emp_id=u.emp_id WHERE u.user_id!=0;

ELSEIF(_action = 'store')THEN
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`Quantity`,st_out_qty(p.pro_id,p.status)`Out Quantity`,p.qty-st_out_qty(p.pro_id,p.status)`Balance Quantity`,p.RegDate`Date` FROM products p 
JOIN items i ON i.item_id=p.item_id 
JOIN store s ON s.store_id=p.store_id
WHERE s.store_id LIKE CONCAT('%',_cust_id,'%') AND i.item_id LIKE CONCAT('%',_text,'%') AND p.status=1 GROUP BY p.pro_id;

ELSEIF(_action = 'receipt')THEN
SELECT @no:=@no+1 `SNO`,c.cust_id`Customer ID`,c.cust_name `Name`,C.tell `Tell`,SUM(r.paid)`Total Paid` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( o.cust_id LIKE CONCAT('%',_cust_id,'%') OR c.cust_name LIKE CONCAT('%',_cust_id,'%') OR c.tell LIKE CONCAT('%',_cust_id,'%') OR o.RegDate LIKE CONCAT('%',_cust_id,'%') ) AND r.RegDate=date(now()) AND o.status=1 AND r.status=1 GROUP BY r.cust_id ORDER BY @no;

ELSEIF(_action = 'unpaid_orders')THEN
CALL get_chart_rep_sp('unpaid_orders',_text);

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `check_login_sp` (IN `_username` VARCHAR(20), IN `_password` VARCHAR(20))   BEGIN

/*IF EXISTS(SELECT * FROM users u WHERE u.status=1 AND u.username=_username AND u.password=_password)THEN
SELECT `user_id`, ifnull(e.emp_name,'Cabdicasiis Shiikh Nuur')`emp_name`, `username`, `password`, `gender`, `image`, u.status, u.type, u.RegDate FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE u.status=1 AND u.username=_username AND u.password=_password;

ELSEIF EXISTS(SELECT * FROM users u WHERE u.status=0 AND u.username=_username AND u.username=_password)THEN
SELECT 'Sorry! Waa lagaa xanibay system-ka La xiriir Qeebta kaa sareesa. Thanks!' AS error;

ELSE
SELECT 'Username or Password is incorrect. Try again' AS error;

END IF;*/

SELECT u.status INTO @status FROM users u WHERE u.username=_username AND u.password=_password;

IF(@status = 1)THEN
SELECT `user_id`, ifnull(e.emp_name,'Cabdicasiis Shiikh Nuur')`emp_name`, `username`, `password`, `gender`, `image`, u.status, u.type, u.RegDate FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE u.status=1 AND u.username=_username AND u.password=_password;

ELSEIF(@status = 0)THEN
SELECT 'Sorry! Waa lagaa xanibay system-ka La xiriir Qeybta kaa sareysa.' AS error;

ELSE
SELECT 'Username or Password is incorrect. Try again' AS error;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `customers_sp` (`_cust_name` VARCHAR(100), `_tell` VARCHAR(100), `_add` VARCHAR(100), `_bal` FLOAT, `_user_id` INT, `_date` DATE)   BEGIN

IF EXISTS(SELECT * FROM customers c WHERE c.cust_name = _cust_name)THEN
SELECT CONCAT('danger|',_cust_name,' Was Already Registered');
ELSEIF EXISTS(SELECT * FROM customers c WHERE c.tell = _tell)THEN
SELECT CONCAT('danger|',_tell,' Was Already Registered');

ELSE
INSERT INTO `customers`(`cust_name`, `tell`, `address`, `balance`, `user_id`, `RegDate`) 
VALUES (_cust_name, _tell, _add, _bal, _user_id, _date);
SELECT CONCAT('success|',_cust_name,' Registered');
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `customer_all_reports` (IN `_cust_id` TEXT)   BEGIN

SET @no =0;
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,CONCAT('$',o.price)`Price`,CONCAT('$',o.total_price)`Total`,CONCAT('$',ifnull(SUM(r.paid),0))`Paid`,CONCAT('$',ifnull(SUM(r.discount),0))`Discount`,CONCAT('$',IF(o.status=0,0,(o.total_price - (ifnull(SUM(r.paid),0)+ifnull(SUM(r.discount),0)) )))`Balnce`,IF(o.status=1,'Ordered','Canceled')`O-Status`, IF(r.status=1,'Recepted',if(r.status=0,'Canceled','Not Recepted'))`R-Status` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN receipt r ON r.order_id=o.order_id
WHERE (c.cust_id = _cust_id OR c.tell LIKE CONCAT('+25261',_cust_id)) GROUP BY o.order_id
UNION
SELECT '','','','','','','','','','Total Balance',CONCAT('$',c.balance),'','' FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN receipt r ON r.order_id=o.order_id
WHERE (c.cust_id = _cust_id OR c.tell LIKE CONCAT('+25261',_cust_id));


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cust_receipt_report_sp` (IN `_cust_id` VARCHAR(100), IN `_order_id` VARCHAR(100))   BEGIN
SET @NO = 0;
IF(_order_id = '')THEN
SELECT @NO:=@NO+1 `SNO`,o.order_id`Order NO`,c.cust_name`Name`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,r.current_amount`Total`,SUM(r.paid)`Paid`,SUM(r.discount)`Discount`,r.current_amount - (SUM(r.paid)+SUM(r.discount))`Balance` FROM customers c 
JOIN orders o ON o.cust_id=c.cust_id 
JOIN receipt r ON r.order_id=o.order_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
WHERE (r.cust_id = _cust_id OR r.send_number LIKE CONCAT('61',_cust_id)) AND r.status=1 GROUP BY o.order_id ORDER BY @NO;

ELSEIF(_cust_id = '')THEN
SELECT @NO:=@NO+1 `SNO`,o.order_id`Order NO`,c.cust_name`Name`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,r.current_amount`Total`,SUM(r.paid)`Paid`,SUM(r.discount)`Discount`,r.current_amount - (SUM(r.paid)+SUM(r.discount))`Balance` FROM customers c 
JOIN orders o ON o.cust_id=c.cust_id 
JOIN receipt r ON r.order_id=o.order_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
WHERE r.order_id = _order_id AND r.status=1 GROUP BY o.order_id;

ELSE
SELECT @NO:=@NO+1 `SNO`,o.order_id`Order NO`,c.cust_name`Name`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,r.current_amount`Total`,r.paid`Paid`,r.remained`Remained`,r.discount`Discount`,r.new_balance`Balance` FROM customers c 
JOIN orders o ON o.cust_id=c.cust_id 
JOIN receipt r ON r.order_id=o.order_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
WHERE (r.cust_id = _cust_id OR r.send_number LIKE CONCAT('61',_cust_id)) AND r.order_id = _order_id AND r.status=1;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `employee_sp` (IN `_ename` VARCHAR(100), IN `_tell` VARCHAR(100), IN `_add` VARCHAR(100), IN `_email` VARCHAR(100), IN `_jtitle` VARCHAR(100), IN `_sal` FLOAT, IN `_date` DATE)   BEGIN

IF(_jtitle = '')THEN
SELECT CONCAT('danger|',' Fadlan soo dooro Job title');

ELSE

IF EXISTS(SELECT * FROM employee e WHERE e.emp_name = _ename)THEN
SELECT CONCAT('danger|',_ename,' Was Already Registered');
ELSEIF EXISTS(SELECT * FROM employee e WHERE e.tell = _tell)THEN
SELECT CONCAT('danger|',_tell,' Was Already Registered');
ELSEIF EXISTS(SELECT * FROM employee e WHERE e.email = _email)THEN
SELECT CONCAT('danger|',_email,' Was Already Registered');

ELSE
INSERT INTO `employee`(`emp_name`, `tell`, `address`, `email`, `jobtitle`, `salary`, `RegDate`) 
VALUES (_ename,_tell,_add,_email,_jtitle,_sal,_date);
SELECT CONCAT('success|',_ename,' Registered');
END IF;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `expenses_report_sp` (IN `_expense` TEXT, IN `_month` TEXT, IN `_year` INT)   BEGIN

IF(_expense = '')THEN
SELECT e.exp_id`ID`,e.exp_name`Expense Name`,CONCAT('$',e.amount)`Amount`,e.tell`Tell`,e.description`Description`,monthname(e.RegDate)`Month`,e.user_id`User ID`, e.RegDate`Date` FROM expenses e 
WHERE month(e.RegDate) = _month AND year(e.RegDate) = _year;

ELSEIF(_month = '')THEN
SELECT e.exp_id`ID`,e.exp_name`Expense Name`,CONCAT('$',e.amount)`Amount`,e.tell`Tell`,e.description`Description`,monthname(e.RegDate)`Month`,e.user_id`User ID`, e.RegDate`Date` FROM expenses e 
WHERE e.exp_name = _expense AND year(e.RegDate) = _year;

ELSE
SELECT e.exp_id`ID`,e.exp_name`Expense Name`,CONCAT('$',e.amount)`Amount`,e.tell`Tell`,e.description`Description`,monthname(e.RegDate)`Month`,e.user_id`User ID`, e.RegDate`Date` FROM expenses e 
WHERE e.exp_name = _expense AND month(e.RegDate) = _month AND year(e.RegDate) = _year;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `expenses_sp` (IN `_exp_name` VARCHAR(100), IN `_amount` FLOAT, IN `_tell` INT, IN `_description` TEXT, IN `_user_id` INT, IN `_date` DATE)   BEGIN
SELECT MONTH(_date) INTO @mo;
SELECT YEAR(_date) INTO @ye;

SELECT MONTHNAME(_date) INTO @mon;

IF EXISTS(SELECT * FROM expenses e WHERE e.exp_name = _exp_name AND e.description = _description)THEN
SELECT CONCAT('danger|','Horay ayaa loo baxshay lacagta ',_description,' ee bisha ',@mon);

ELSE
IF(_description = '' OR _description = null)THEN
SELECT CONCAT('danger|','Fadlan Wax soo geli Description-ka');

ELSE
INSERT INTO `expenses`(`exp_name`, `amount`, `tell`, `description`, `user_id`, `RegDate`) 
VALUES (_exp_name, _amount, _tell, _description, _user_id, _date);
SELECT CONCAT('success|','$',_amount,' Ayaad bixisay lacagta ',_exp_name,' ',_description,' ee bisha ',@mon);
END IF;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_chart_rep_sp` (IN `_action` VARCHAR(100), IN `_text` VARCHAR(100))   BEGIN

SET @no = 0;
SELECT month(now()),year(now()) INTO @m,@y;

#ORDER CHART REPORT SP
IF(_action = 'total_orders')THEN
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,C.tell `Tell`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,o.total_price`Total`,o.RegDate`Date` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
WHERE ( o.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR c.tell LIKE CONCAT('%',_text,'%') OR o.RegDate LIKE CONCAT('%',_text,'%') )
AND o.status=1;

ELSEIF(_action = 'this_month_orders')THEN
SET @no = 0;
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,C.tell `Tell`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,o.total_price`Total`,o.RegDate`Date` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
WHERE ( o.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR c.tell LIKE CONCAT('%',_text,'%') OR o.RegDate LIKE CONCAT('%',_text,'%') )
AND o.status=1 AND o.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now());

ELSEIF(_action = 'unpaid_orders')THEN
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,C.tell `Tell`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,CONCAT('$',o.price)`Price`,CONCAT('$',o.total_price)`Total`,CONCAT('$',ifnull(r.paid,0))`Paid`,CONCAT('$',ifnull(r.discount,0))`Discount`,o.total_price`Balance` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN receipt r ON r.order_id=o.order_id
WHERE o.order_id NOT IN(SELECT receipt.order_id FROM receipt) AND ( o.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR c.tell LIKE CONCAT('%',_text,'%') OR o.RegDate LIKE CONCAT('%',_text,'%') )
AND o.status=1;

ELSEIF(_action = 'cancel_orders')THEN
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,C.tell `Tell`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,o.total_price`Total`,o.RegDate`Date` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
WHERE ( o.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR c.tell LIKE CONCAT('%',_text,'%') OR o.RegDate LIKE CONCAT('%',_text,'%') )
AND o.status=0;






#RECEIPT CHART REPORT SP
ELSEIF(_action = 'total_receipt')THEN
SELECT @no:=@no+1 `SNO`,c.cust_id`Customer ID`,c.cust_name `Name`,C.tell `Tell`,SUM(r.paid)`Total Paid` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( r.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR r.send_number LIKE CONCAT('%',_text,'%') OR r.RegDate LIKE CONCAT('%',_text,'%') )
AND o.status=1 AND r.status = 1 GROUP BY r.cust_id ORDER BY @no;

ELSEIF(_action = 'month_receipt')THEN
SELECT @no:=@no+1 `SNO`,c.cust_id`Customer ID`,c.cust_name `Name`,C.tell `Tell`,SUM(r.paid)`Total Paid` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( r.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR r.send_number LIKE CONCAT('%',_text,'%') OR r.RegDate LIKE CONCAT('%',_text,'%') ) AND r.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now()) AND r.status=1 GROUP BY r.cust_id ORDER BY @no;

ELSEIF(_action = 'today_receipt')THEN
SELECT @no:=@no+1 `SNO`,c.cust_id`Customer ID`,c.cust_name `Name`,C.tell `Tell`,SUM(r.paid)`Total Paid` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( r.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR r.send_number LIKE CONCAT('%',_text,'%') OR r.RegDate LIKE CONCAT('%',_text,'%') ) AND r.RegDate = date(now()) AND r.status=1 GROUP BY r.cust_id ORDER BY @no;

ELSEIF(_action = 'cancel_receipt')THEN
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,C.tell `Tell`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,o.total_price`Total`,r.RegDate`Date` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( c.cust_id LIKE CONCAT('%',_text,'%') OR c.cust_name LIKE CONCAT('%',_text,'%') OR r.send_number LIKE CONCAT('%',_text,'%') OR r.RegDate LIKE CONCAT('%',_text,'%') )
AND r.status=0;





#PURCHASE CHART REPORT SP
ELSEIF(_action = 'total_purchase')THEN
SELECT @no:=@no+1 `SNO`,p.purchase_id `Purchase No`,s.name `Name`,CONCAT(i.item_name,' ',i.Category)`Item`,pr.item_type`Item Type`,p.qty`Quantity`,p.price`Price`,p.total_price`Total`,p.RegDate`Date` FROM purchase p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN products pr ON pr.purchase_id=p.purchase_id
JOIN items i ON i.item_id=pr.item_id
WHERE ( p.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR p.RegDate LIKE CONCAT('%',_text,'%') )
AND p.status=1;

ELSEIF(_action = 'month_purchase')THEN
SELECT @no:=@no+1 `SNO`,p.purchase_id `Purchase No`,s.name `Name`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`Quantity`,p.price`Price`,p.total_price`Total`,p.RegDate`Date` FROM purchase p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN products pr ON pr.purchase_id=p.purchase_id
JOIN items i ON i.item_id=p.item_id
WHERE ( p.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR p.RegDate LIKE CONCAT('%',_text,'%') )
AND p.status=1 AND p.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now());

ELSEIF(_action = 'unpaid_purchase')THEN
SELECT @no:=@no+1 `SNO`,pu.purchase_id `Purchase No`,s.name `Name`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',pu.total_price)`Total`,CONCAT('$',ifnull(pa.paid,0))`Paid`,CONCAT('$',pu.total_price)`Balance`,pu.RegDate`Date` FROM purchase pu
JOIN supplier s ON s.supplier_id=pu.supplier_id
JOIN products p ON p.purchase_id=pu.purchase_id
JOIN items i ON i.item_id=pu.item_id
LEFT JOIN payments pa ON pa.purchase_id=pu.purchase_id
WHERE pu.purchase_id NOT IN(SELECT pa.purchase_id FROM payments pa) 
AND ( pu.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR pu.RegDate LIKE CONCAT('%',_text,'%') )
AND pu.status=1;
/*UNION
SELECT @no:=@no+1 `SNO`,pu.purchase_id `Purchase No`,s.name `Name`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',pa.total_price),CONCAT('$',SUM(pa.paid))`Paid`,CONCAT('$',pa.total_price - SUM(pa.paid))`Balance`,pu.RegDate`Date` FROM payments pa
JOIN supplier s ON s.supplier_id=pa.supplier_id
LEFT JOIN purchase pu ON pu.purchase_id=pa.purchase_id
JOIN products p ON p.purchase_id=pu.purchase_id
JOIN items i ON i.item_id=p.item_id
WHERE ( pu.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR pu.RegDate LIKE CONCAT('%',_text,'%') ) AND pa.status=1 AND get_bal('purchase',pa.purchase_id) != 0
GROUP BY pa.purchase_id;*/

ELSEIF(_action = 'cancel_purchase')THEN
SELECT @no:=@no+1 `SNO`,p.purchase_id `Purchase No`,s.name`Name`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`Quantity`,p.price`Price`,p.total_price`Total`,p.RegDate`Date` FROM purchase p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN products pr ON pr.purchase_id=p.purchase_id
JOIN items i ON i.item_id=p.item_id
WHERE ( p.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR p.RegDate LIKE CONCAT('%',_text,'%') )
AND p.status=0;




#PAYMENTS CHART REPORT SP
ELSEIF(_action = 'total_payments')THEN
IF(_text = '')THEN
SELECT @no:=@no+1 `SNO`,pu.purchase_id`Purchase No`,s.name`Name`,CONCAT(i.item_name,' ',i.Category)`Item`,pu.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',p.total_price)`Total Price`,CONCAT('$',SUM(p.paid))`Paid`,CONCAT('$',SUM(p.discount))`Discount`,CONCAT('$',p.total_price - (SUM(p.paid)+SUM(p.discount)))`Balance`,p.RegDate`Date` FROM payments p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN purchase pu ON pu.purchase_id=p.purchase_id
JOIN items i ON i.item_id=pu.item_id
WHERE pu.purchase_id LIKE '%' AND p.status=1
GROUP BY p.purchase_id;

ELSE
SELECT @no:=@no+1 `SNO`,pu.purchase_id`Purchase No`,s.name`Name`,CONCAT(i.item_name,' ',i.Category)`Item`,pu.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',p.total_price)`Total Price`,CONCAT('$',p.paid)`Paid`,CONCAT('$',p.discount)`Discount`,CONCAT('$',p.total_price - (p.paid+p.discount))`Balance`,p.RegDate`Date` FROM payments p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN purchase pu ON pu.purchase_id=p.purchase_id
JOIN items i ON i.item_id=pu.item_id
WHERE ( pu.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR p.RegDate LIKE CONCAT('%',_text,'%') ) AND p.status=1;
END IF;
#end total payments checking

ELSEIF(_action = 'month_payments')THEN
SELECT @no:=@no+1 `SNO`,pu.purchase_id`Purchase No`,s.name`Name`,CONCAT(i.item_name,' ',i.Category)`Item`,pu.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',p.total_price)`Total Price`,CONCAT('$',SUM(p.paid))`Paid`,CONCAT('$',SUM(p.discount))`Discount`,CONCAT('$',p.total_price - (SUM(p.paid)+SUM(p.discount)))`Balance`,p.RegDate`Date` FROM payments p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN purchase pu ON pu.purchase_id=p.purchase_id
JOIN items i ON i.item_id=pu.item_id
WHERE ( pu.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR p.RegDate LIKE CONCAT('%',_text,'%') ) AND p.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now()) AND p.status=1
GROUP BY p.purchase_id;

ELSEIF(_action = 'today_payments')THEN
SELECT @no:=@no+1 `SNO`,pu.purchase_id`Purchase No`,s.name`Name`,CONCAT(i.item_name,' ',i.Category)`Item`,pu.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',p.total_price)`Total Price`,CONCAT('$',SUM(p.paid))`Paid`,CONCAT('$',SUM(p.discount))`Discount`,CONCAT('$',p.total_price - (SUM(p.paid)+SUM(p.discount)))`Balance`,p.RegDate`Date` FROM payments p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN purchase pu ON pu.purchase_id=p.purchase_id
JOIN items i ON i.item_id=pu.item_id
WHERE ( pu.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR p.RegDate LIKE CONCAT('%',_text,'%') ) AND p.RegDate = date(now()) AND p.status=1
GROUP BY p.purchase_id;

ELSEIF(_action = 'cancel_payments')THEN
SELECT @no:=@no+1 `SNO`,pu.purchase_id`Purchase No`,s.name`Name`,CONCAT(i.item_name,' ',i.Category)`Item`,pu.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',p.total_price)`Total Price`,CONCAT('$',SUM(p.paid))`Paid`,CONCAT('$',SUM(p.discount))`Discount`,CONCAT('$',p.total_price - (SUM(p.paid)+SUM(p.discount)))`Balance`,p.RegDate`Date` FROM payments p
JOIN supplier s ON s.supplier_id=p.supplier_id
JOIN purchase pu ON pu.purchase_id=p.purchase_id
JOIN items i ON i.item_id=pu.item_id
WHERE ( pu.purchase_id LIKE CONCAT('%',_text,'%') OR s.name LIKE CONCAT('%',_text,'%') OR p.RegDate LIKE CONCAT('%',_text,'%') ) AND p.status=0
GROUP BY p.purchase_id;


END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_current_sp` (IN `_action` VARCHAR(100), IN `_id` INT)   BEGIN
SELECT r.new_balance,r.order_id INTO @new_bal,@ord FROM receipt r WHERE r.order_id=_id ORDER BY r.rec_id DESC LIMIT 1;
SELECT p.balance,p.purchase_id INTO @bal,@pur FROM payments p WHERE p.purchase_id=_id ORDER BY p.payment_id DESC LIMIT 1;

IF(_id = 0)THEN
SELECT 'Nothing to show','Nothing to show';

ELSE
IF(_action = 'receipt')THEN
SELECT o.cust_id,c.cust_name,IF(@ord=_id,@new_bal,o.total_price) FROM orders o 
JOIN customers c ON c.cust_id=o.cust_id WHERE o.order_id=_id AND o.status=1;

ELSEIF(_action = 'purchase')THEN
SELECT p.supplier_id,concat(s.name,' ',s.location),IF(@pur=_id,@bal,p.total_price) FROM purchase p
JOIN supplier s ON s.supplier_id=p.supplier_id
WHERE p.purchase_id=_id;


ELSEIF(_action = 'employee')THEN
SELECT e.salary INTO @em_sal FROM employee e WHERE e.emp_id=_id;
SELECT SUM(p.amount),p.type,p.date INTO @pa_am,@type,@date FROM pay_salary p WHERE p.emp_id=_id AND month(p.date)=month(now()) AND year(p.date)=year(now());

SELECT month(@date) INTO @dat;
SELECT month(now()) INTO @datt;

SELECT IF(@datt = @dat, @em_sal - @pa_am, @em_sal);


ELSEIF(_action = 'emp')THEN
SELECT e.salary INTO @em_sal FROM employee e WHERE e.emp_id=_id;
SELECT SUM(p.amount),p.type,p.date INTO @pa_am,@type,@date FROM pay_salary p WHERE p.emp_id=_id AND month(p.date)=month(now()) AND year(p.date)=year(now());

SELECT month(@date) INTO @dat;
SELECT month(now()) INTO @datt;

SELECT IF(@datt = @dat, @em_sal - @pa_am, @em_sal);

END IF;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_qty_pri_sp` (IN `_pro_id` INT, IN `_item_id` INT, IN `_store_id` INT)   BEGIN

SELECT SUM(st.out_qty) INTO @out_qty FROM store_out st WHERE st.pro_id=_pro_id AND st.status=1;
SELECT ifnull(@out_qty,0) into @r_out_qty;

IF(@r_out_qty = 0)THEN
SELECT p.qty,p.price FROM products p 
WHERE p.pro_id=_pro_id AND p.store_id=_store_id AND p.item_id=_item_id AND p.status=1;

ELSE
SELECT INSTR((p.qty - @r_out_qty),'.'),p.qty - @r_out_qty,p.price INTO @q,@p,@p1 FROM products p 
WHERE p.pro_id=_pro_id AND p.store_id=_store_id AND p.item_id=_item_id AND p.status=1;

SELECT SUBSTRING(@p,1,@q),@p1 FROM products p 
WHERE p.pro_id=_pro_id AND p.store_id=_store_id AND p.item_id=_item_id AND p.status=1;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_tables_info_sp` (IN `_tb_name` VARCHAR(50), IN `_id` INT)   BEGIN
IF (_tb_name = 'users')THEN
SELECT u.user_id, ifnull(e.emp_name,'Cabdicasiis Shiikh Nuur')`emp_name`, u.username, u.password, u.gender, u.status, u.type,u.sec_question,u.sec_answer,u.RegDate FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE u.user_id=_id;

ELSEIF (_tb_name = 'employee')THEN
SELECT * FROM `employee` WHERE emp_id=_id;

ELSEIF (_tb_name = 'customer')THEN
SELECT * FROM `customers` WHERE cust_id=_id;

ELSEIF (_tb_name = 'account')THEN
SELECT * FROM `accounts` WHERE acc_id=_id;

ELSEIF (_tb_name = 'expenses')THEN
SELECT * FROM `expenses` WHERE exp_id=_id;

ELSEIF (_tb_name = 'items')THEN
SELECT * FROM `items` WHERE item_id=_id;

ELSEIF (_tb_name = 'store')THEN
SELECT s.store_id,s.store_name,s.RegDate FROM store s WHERE store_id=_id;

ELSEIF (_tb_name = 'products')THEN
SELECT * FROM `products` WHERE pro_id=_id;

ELSEIF (_tb_name = 'orders')THEN
SELECT o.order_id,c.cust_name,p.pro_id,concat(i.item_name,' ',i.Category,' ',p.item_type),o.qty,o.price,o.total_price,o.user_id,o.status,o.RegDate FROM orders o JOIN products p ON p.pro_id=o.pro_id JOIN customers c ON c.cust_id=o.cust_id JOIN items i ON i.item_id=p.item_id WHERE o.order_id=_id;

ELSEIF (_tb_name = 'receipt')THEN
SELECT `rec_id`, r.order_id, c.cust_name, o.total_price, `paid`,  o.total_price - r.paid, `discount`, ( (o.total_price - r.paid) - `discount`), `account_id`, `send_number`, `ref_no`, r.user_id, r.status, r.RegDate FROM receipt r JOIN customers c ON c.cust_id=r.cust_id JOIN orders o ON o.order_id=r.order_id WHERE r.rec_id=_id;

ELSEIF (_tb_name = 'store_o')THEN
SELECT * FROM `store_out` WHERE store_out_id = _id;

ELSEIF (_tb_name = 'supplier')THEN
SELECT * FROM `supplier` WHERE supplier_id=_id;

ELSEIF (_tb_name = 'purchase')THEN
SELECT * FROM `purchase` WHERE purchase_id=_id;

ELSEIF (_tb_name = 'payments')THEN
SELECT * FROM `payments` WHERE payment_id=_id;

ELSEIF (_tb_name = 'pay_sal')THEN
SELECT * FROM `pay_Salary` WHERE pay_sal_id=_id; 

ELSEIF (_tb_name = 'menu')THEN
SELECT * FROM `menu` WHERE id=_id;

ELSEIF (_tb_name = 'sub_menu')THEN
SELECT * FROM `sub_menu` WHERE id=_id;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `items_sp` (IN `_item_id` INT, IN `_item_name` VARCHAR(100), IN `_category` VARCHAR(100), IN `_date` DATE, IN `_type` VARCHAR(50))   BEGIN
START TRANSACTION;
IF (_type = 'insert')THEN
IF EXISTS(SELECT * FROM items WHERE item_name=_item_name AND Category=_category)THEN
SELECT CONCAT('danger|',_item_name,' ',_category,' Was Already Registered');

ELSE
INSERT INTO items(`item_name`,`Category`,`Reg_date`)
VALUES(_item_name,_category,_date);

SELECT CONCAT('success|',_item_name,' ',_category,' Successfully Registered');
END IF;

ELSEIF (_type = 'update')THEN
UPDATE `items` SET `item_name`=_item_name, `category`=_category  WHERE `item_id`=_item_id;

END IF;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orders_sp` (IN `_cust_id` INT, IN `_pro_id` INT, IN `_qty` INT, IN `_price` FLOAT, IN `_total_price` FLOAT, IN `_user_id` INT, IN `_date` DATE)   BEGIN
START TRANSACTION;

IF (_pro_id = 0)THEN
SELECT CONCAT('danger|','Fadlan dooro product');

ELSEIF(_qty = 0)THEN
SELECT CONCAT('danger|','Fadlan soo geli quantity');

ELSEIF(_cust_id = 0)THEN
SELECT CONCAT('danger|','Fadlan soo geli customer');

ELSE
SELECT SUM(st.out_qty) INTO @out_qty FROM store_out st WHERE st.pro_id=_pro_id AND st.status=1;
SELECT (ifnull(@out_qty,0) + _qty) INTO @t_out_qty; 
SELECT p.qty INTO @in_qty FROM products p WHERE p.pro_id=_pro_id;
SELECT (@in_qty - @t_out_qty) INTO @pro_qty;

IF(@pro_qty < 0)THEN
SELECT CONCAT('danger|','Haraaga produt-gaan kuguma filna');

#PRODUCTS UPDATE
ELSEIF(@pro_qty = 0)THEN
UPDATE `products` SET `status`= 0 WHERE `pro_id`=_pro_id;

#ORDERS
SELECT c.cust_name INTO @cname FROM customers c WHERE c.cust_id=_cust_id;
SELECT i.item_name,p.item_type INTO @iname,@itype FROM items i JOIN products p ON p.item_id=i.item_id WHERE p.pro_id=_pro_id;

INSERT INTO `orders`(`cust_id`, `pro_id`, `qty`, `price`, `total_price`, `user_id`, `RegDate`)  
VALUES (_cust_id,_pro_id,_qty,_price,_total_price,_user_id,_date);
SELECT CONCAT('success|',@cname,' Waxa uu dalbaday ',@iname,' ',@itype,' Wuuna dhamaaday');
#END ORDERS
SET @order_id = last_insert_id();

#START STORE OUT
INSERT INTO `store_out`(`order_id`, `pro_id`, `out_qty`, `Reg_date`)
VALUES(@order_id,_pro_id,_qty,_date);
#END STORE OUT

ELSE
#ORDERS
SELECT c.cust_name INTO @cname FROM customers c WHERE c.cust_id=_cust_id;
SELECT i.item_name,p.item_type INTO @iname,@itype FROM items i JOIN products p ON p.item_id=i.item_id WHERE p.pro_id=_pro_id;

INSERT INTO `orders`(`cust_id`, `pro_id`, `qty`, `price`, `total_price`, `user_id`, `RegDate`)  
VALUES (_cust_id,_pro_id,_qty,_price,_total_price,_user_id,_date);
SELECT CONCAT('success|',@cname,' Waxa uu dalbaday ',@iname,' ',@itype);
#END ORDERS
SET @orders_id = last_insert_id();

#START STORE OUT
INSERT INTO `store_out`(`order_id`, `pro_id`, `out_qty`, `Reg_date`)
VALUES(@orders_id,_pro_id,_qty,_date);
#END STORE OUT
END IF;

END IF;
#1st IF

COMMIT;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `payments_report_sp` (IN `_supplier` TEXT, IN `_purchase` TEXT)   BEGIN
SET @no = 0;
IF(_purchase = '')THEN
SELECT @no:=@no+1`SNO`,p.purchase_id`Purchase ID`,s.name`Supplier`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`Quantity`,CONCAT('$',p.price)`Price`,CONCAT('$',ifnull(p.total_price,0))`Total Price`,CONCAT('$',ifnull(SUM(pa.paid),0))`Paid`,CONCAT('$',ifnull(SUM(pa.balance),0))`Balance`,p.RegDate FROM supplier s 
JOIN purchase p ON p.supplier_id=s.supplier_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN payments pa ON pa.purchase_id=p.purchase_id 
WHERE s.name LIKE CONCAT('%',_supplier,'%') GROUP BY p.purchase_id;

ELSE
SELECT @no:=@no+1`SNO`,p.purchase_id`Purchase ID`,s.name`Supplier`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`Quantity`,CONCAT('$',p.price)`Price`,CONCAT('$',ifnull(pa.total_price,p.total_price))`Total Price`,CONCAT('$',ifnull(pa.paid,0))`Paid`,CONCAT('$',ifnull(pa.balance,0))`Balance`,p.RegDate FROM supplier s 
JOIN purchase p ON p.supplier_id=s.supplier_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN payments pa ON pa.purchase_id=p.purchase_id 
WHERE p.purchase_id LIKE CONCAT('%',_purchase,'%');
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `payments_sp` (IN `_purchase_id` INT, IN `_supplier_id` INT, IN `_total_price` FLOAT, IN `_paid` FLOAT, IN `_discount` DOUBLE, IN `_balance` FLOAT, IN `_user_id` INT, IN `_sender` INT, IN `_receifer` INT, IN `_ref_no` VARCHAR(50), IN `_date` DATE)   BEGIN 


INSERT INTO `payments`(`purchase_id`, `supplier_id`, `total_price`, `paid`, `discount`, `balance`, `user_id`, `Sender`, `receifer`, `ref_no`, `RegDate`) 
VALUES (_purchase_id,_supplier_id,_total_price,_paid,_discount,_balance,_user_id,_Sender,_receifer,_ref_no,_date);
SELECT CONCAT('success|',' Successfully Registered');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pay_salary_sp` (IN `_emp_id` INT, IN `_salary` FLOAT, IN `_amount` FLOAT, IN `_type` VARCHAR(50), IN `_acc_id` INT, IN `_receifer` INT, IN `_user_id` INT, IN `_date` DATE)   BEGIN
IF(_amount = 0)THEN
SELECT CONCAT('danger|','Fadlan Soogeli amount-ga aad bixineyso');

ELSEIF(_type = '')THEN
SELECT CONCAT('danger|','Fadlan soo dooro nuuca lacagta(Type)');

ELSEIF(_emp_id = '')THEN
SELECT CONCAT('danger|','Fadlan soo dooro Employee');

ELSEIF(_acc_id = '')THEN
SELECT CONCAT('danger|','Fadlan soo dooro Account-ka diraha eh');

ELSEIF(_receifer = '')THEN
SELECT CONCAT('danger|','Fadlan soo geli Phone/Account-ka loo diraha eh');

ELSE
SELECT MONTH(now()) INTO @month;
SELECT YEAR(now()) INTO @year;
SELECT MONTH(_date) INTO @month1;
SELECT YEAR(_date) INTO @year1;
SELECT MONTHNAME(_date) INTO @monthN;

SELECT SUM(ps.amount) INTO @amount FROM pay_salary ps WHERE ps.emp_id=_emp_id AND month(ps.date)=@month1;

SELECT e.emp_name,e.salary INTO @en,@es FROM employee e WHERE e.emp_id=_emp_id;
SELECT p.type INTO @pty FROM pay_salary p WHERE p.emp_id=_emp_id ORDER BY p.pay_sal_id DESC LIMIT 1;

SELECT ( (@es - ifnull(@amount,0)) - _amount ) INTO @real;

IF(@real < 0)THEN
SELECT CONCAT('danger|','Lacagta bisha ',@monthN,' ee ',@en,' horay ayaa loo baxshay');

#nadiif
ELSEIF(_type = 'Salary')THEN
INSERT INTO `pay_salary`(`emp_id`, `salary`, `amount`, `type`, `acc_id`, `receifer`, `user_id`, `date`) 
VALUES (_emp_id, _salary, _amount, _type, _acc_id, _receifer, _user_id, _date); 
SELECT CONCAT('success|','Lacagta bisha ',@monthN,' ee ',@en,' Successfully Payed');

#Hormaris markaa rabto
ELSEIF(_type = 'Hormaris')THEN
INSERT INTO `pay_salary`(`emp_id`, `salary`, `amount`, `type`, `acc_id`, `receifer`, `user_id`, `date`) 
VALUES (_emp_id, _salary, _amount, _type, _acc_id, _receifer, _user_id, _date); 
SELECT CONCAT('success|','Lacagta bisha ',@monthN,' ee ',@en,' Waxa uu hormarsaday ',_amount);

#Hormaris 2aad markaa rabto
ELSEIF(@pty = 'Hormaris' AND _type = 'Hormaris')THEN
INSERT INTO `pay_salary`(`emp_id`, `salary`, `amount`, `type`, `acc_id`, `receifer`, `user_id`, `date`) 
VALUES (_emp_id, _salary, _amount, _type, _acc_id, _receifer, _user_id, _date);  
SELECT CONCAT('success|','Lacagta bisha ',@monthN,' ee ',@en,' Waxa uu hormarsaday ',_amount);

#Hormaris then salary
ELSEIF(@pty = 'Hormaris' AND _type = 'Salary')THEN
INSERT INTO `pay_salary`(`emp_id`, `salary`, `amount`, `type`, `acc_id`, `receifer`, `user_id`, `date`) 
VALUES (_emp_id, _salary, _amount, _type, _acc_id, _receifer, _user_id, _date);  
SELECT CONCAT('success|','Lacagta bisha ',@monthN,' ee ',@en,' Successfully Payed');
END IF;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `print_reports` (IN `_action` TEXT, IN `_id` TEXT, IN `_id1` TEXT, IN `_id2` TEXT, IN `_id3` TEXT, IN `_id4` TEXT)   BEGIN

SET @no =0;
#START CUSTOMER ALL REPORT
IF(_action = 'Customer History Report')THEN
CALL customer_all_reports(_id);
#END CUSTOMER ALL REPORT


#START SUPPLIER ALL REPORT
ELSEIF(_action = 'Supplier History Report')THEN
CALL supplier_all_report_sp(_id);
#END SUPPLIER ALL REPORT


#START CUSTOMER RECEIPT REPORT
ELSEIF(_action = 'Customers Receipt Report')THEN
CALL cust_receipt_report_sp(_id,_id1);
#END CUSTOMER RECEIPT REPORT


#START STORE REPORT
ELSEIF(_action = 'Store Report')THEN
CALL store_report_sp(_id,_id1);
#END STORE REPORT

#START STORE OUT REPORT
ELSEIF(_action = 'Store Out Report')THEN
CALL store_out_report_sp(_id,_id1,_id2,_id3);
#END STORE OUT REPORT


#START SALARY REPORT
ELSEIF(_action = 'Salary Report')THEN
CALL salary_report_sp(_id,_id1,_id2);
#END SALARY REPORT


#START Maximum Items Ordered Report
ELSEIF(_action = 'Maximum Items Ordered Report')THEN
IF(_id = '%')THEN
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,COUNT(o.pro_id)`Max Orders`,o.RegDate`Date` FROM orders o JOIN products p ON p.pro_id=o.pro_id JOIN store s ON s.store_id=p.store_id JOIN items i ON i.item_id=p.item_id WHERE o.status=1 AND year(o.RegDate) = _id1 GROUP BY o.pro_id ORDER BY COUNT(o.pro_id) DESC;
ELSE
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,COUNT(o.pro_id)`Max Orders`,o.RegDate`Date` FROM orders o JOIN products p ON p.pro_id=o.pro_id 
JOIN store s ON s.store_id=p.store_id JOIN items i ON i.item_id=p.item_id WHERE o.status=1 AND 
month(o.RegDate) = _id AND year(o.RegDate) = _id1 GROUP BY o.pro_id ORDER BY COUNT(o.pro_id) DESC;
END IF;
#END Maximum Items Ordered Report


#START EXPENSES REPORT
ELSEIF(_action = 'Expenses Report')THEN
CALL expenses_report_sp(_id,_id1,_id2);
#END EXPENSES REPORT

END IF;
#BIG IF
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `product_sp` (IN `_purchase_id` INT, IN `_store_id` INT(100), IN `_item_id` INT, IN `_item_type` VARCHAR(100), IN `_qty` INT, IN `_price` FLOAT, IN `_total` FLOAT, IN `_user_id` INT, IN `_date` DATE)   BEGIN
SELECT i.item_name INTO @item_name FROM items i WHERE i.item_id = _item_id;
SELECT s.store_name INTO @store FROM store s WHERE s.store_id = _store_id;

INSERT INTO `products`(`purchase_id`, `store_id`, `item_id`, `item_type`, `qty`, `price`, `total_price`, `user_id`, `RegDate`) 
VALUES (_purchase_id,_store_id,_item_id,_item_type,_qty,_price,_total,_user_id,_date);
SELECT CONCAT('success|',' Store-ka ',@store,' ',@item_name,' ',_item_type,' Registered');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchase_sp` (IN `_supplier_id` INT, IN `_store_id` INT, IN `_item_id` INT, IN `_item_type` VARCHAR(100), IN `_qty` INT, IN `_price` FLOAT, IN `_total_price` FLOAT, IN `_user_id` INT, IN `_date` DATE)   BEGIN
START TRANSACTION;

IF(_supplier_id = 0)THEN
SELECT CONCAT('danger|','Fadlan soo dooro Supplier');

ELSEIF(_store_id = 0)THEN
SELECT CONCAT('danger|','Fadlan soo dooro Store-ka loo gadaayo product-gaan');

ELSEIF(_item_id = 0)THEN
SELECT CONCAT('danger|','Fadlan soo dooro Item');

ELSE
INSERT INTO `purchase`(`supplier_id`, `item_id`, `item_type`, `qty`, `price`, `total_price`, `user_id`, `RegDate`) 
VALUES(_supplier_id,_item_id,_item_type,_qty,_price,_total_price,_user_id,_date);

SET @purchase_id = last_insert_id();

INSERT INTO `products`(`purchase_id`, `store_id`, `item_id`, `item_type`, `qty`, `price`, `total_price`, `user_id`, `RegDate`)
VALUES (@purchase_id,_store_id,_item_id,_item_type,_qty,_price,_total_price,_user_id,_date);

SELECT concat('success|',' Successfully Registered');
END IF;

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `receipts_sp` (IN `_cust_id` INT, IN `_order_id` INT, IN `_current_ammount` FLOAT, IN `_paid` FLOAT, IN `_remained` FLOAT, IN `_discount` FLOAT, IN `_new_balance` FLOAT, IN `_account_id` INT, IN `_send_num` INT, IN `_user_id` INT, IN `_date` DATE)   BEGIN

SELECT c.cust_name INTO @cust FROM customers c WHERE c.cust_id=_cust_id;
SELECT ref_no() INTO @ref_no;

IF (_discount = '')THEN
INSERT INTO `receipt`(`cust_id`, `order_id`, `current_amount`, `paid`, `remained`, `discount`, `new_balance`, `account_id`, `send_number`, `ref_no`, `user_id`, `RegDate`)
VALUES (_cust_id,_order_id,_current_ammount,_paid,_remained,_discount,_remained,_account_id,_send_num,@ref_no,_user_id,_date);
SELECT CONCAT('success|',@cust,' Waxa laga qabtay $',_paid,' new balance waa $',_remained);

ELSE
INSERT INTO `receipt`(`cust_id`, `order_id`, `current_amount`, `paid`, `remained`, `discount`, `new_balance`, `account_id`, `send_number`, `ref_no`, `user_id`, `RegDate`)
VALUES (_cust_id,_order_id,_current_ammount,_paid,_remained,_discount,_new_balance,_account_id,_send_num,@ref_no,_user_id,_date);
SELECT CONCAT('success|',@cust,' Waxa laga qabtay $',_paid,' new balance waa $',_new_balance);
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `receipt_chart_rep_sp` (IN `_action` TEXT, IN `_cust_id` TEXT)   BEGIN

SET @no = 0;
IF(_action = 'total_receipt')THEN
SELECT @no:=@no+1 `SNO`,c.cust_id`ID`,c.cust_name `Name`,C.tell `Tell`,SUM(r.paid)`Total Paid` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( o.cust_id LIKE CONCAT('%',_cust_id,'%') OR c.cust_name LIKE CONCAT('%',_cust_id,'%') OR c.tell LIKE CONCAT('%',_cust_id,'%') OR o.RegDate LIKE CONCAT('%',_cust_id,'%') )
AND o.status=1 GROUP BY r.cust_id ORDER BY @no;

ELSEIF(_action = 'month_receipt')THEN
SELECT month(now()),year(now()) INTO @m,@y;
SELECT @no:=@no+1 `SNO`,c.cust_id`ID`,c.cust_name `Name`,C.tell `Tell`,SUM(r.paid)`Total Paid` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( o.cust_id LIKE CONCAT('%',_cust_id,'%') OR c.cust_name LIKE CONCAT('%',_cust_id,'%') OR c.tell LIKE CONCAT('%',_cust_id,'%') OR o.RegDate LIKE CONCAT('%',_cust_id,'%') ) AND r.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now()) GROUP BY r.cust_id ORDER BY @no;

ELSEIF(_action = 'cancel_receipt')THEN
SELECT @no:=@no+1 `SNO`,o.order_id `Order No`,c.cust_name `Name`,C.tell `Tell`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,o.total_price`Total`,o.RegDate`Date` FROM orders o
JOIN customers c ON c.cust_id=o.cust_id
JOIN products p ON p.pro_id=o.pro_id
JOIN items i ON i.item_id=p.item_id
JOIN receipt r ON r.order_id=o.order_id
WHERE ( o.cust_id LIKE CONCAT('%',_cust_id,'%') OR c.cust_name LIKE CONCAT('%',_cust_id,'%') OR c.tell LIKE CONCAT('%',_cust_id,'%') OR o.RegDate LIKE CONCAT('%',_cust_id,'%') )
AND o.status=0;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `salary_report_sp` (IN `_emp_id` TEXT, IN `_month` TEXT, IN `_year` INT(4))   BEGIN
SET @no = 0;
IF(_month = '')THEN
SELECT @no:=@no+1`SNO`,p.pay_sal_id`ID`,e.emp_name`Name`,CONCAT('$',e.salary)`Salary`,CONCAT('$',SUM(p.amount))`Amount`,CONCAT('$',e.salary-SUM(p.amount))`Balance`,monthname(p.date)`Month`,p.date`Date` FROM pay_salary p 
JOIN employee e ON e.emp_id=p.emp_id
WHERE p.emp_id = _emp_id AND year(p.date) = year(now()) GROUP BY p.date,e.emp_id;

ELSEIF(_emp_id = '')THEN
SELECT @no:=@no+1`SNO`,p.pay_sal_id`ID`,e.emp_name`Name`,CONCAT('$',e.salary)`Salary`,CONCAT('$',SUM(p.amount))`Amount`,CONCAT('$',e.salary-SUM(p.amount))`Balance`,monthname(p.date)`Month`,p.date`Date` FROM pay_salary p 
JOIN employee e ON e.emp_id=p.emp_id
WHERE month(p.date) = _month AND year(p.date) = _year GROUP BY p.date,e.emp_id;

ELSE
SELECT @no:=@no+1`SNO`,p.pay_sal_id`ID`,e.emp_name`Name`,CONCAT('$',p.salary)`Salary`,CONCAT('$',p.amount)`Amount`,CONCAT('$',p.salary-p.amount)`Balance`,p.type`Type`,monthname(p.date)`Month`,p.date`Date` FROM pay_salary p 
JOIN employee e ON e.emp_id=p.emp_id
WHERE p.emp_id = _emp_id AND  month(p.date) = _month AND year(p.date) = _year;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `store_out_report_sp` (IN `_store_id` TEXT, IN `_item_id` TEXT, IN `_month` TEXT, IN `_year` INT)   BEGIN

SET @no = 0;

IF(_month = '' AND _item_id = '')THEN
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`In Quantity`,st_out_qty(p.pro_id,p.status)`Out Quantity`,CONCAT('$',p.total_price)`Total Cost`,CONCAT('$',ifnull(SUM(r.paid),0))`Total Income`, CONCAT('$',ifnull(SUM(r.paid),0) - p.total_price)`Profit`,p.RegDate`Date`
FROM orders o
JOIN products p ON p.pro_id=o.pro_id
JOIN store s ON s.store_id=p.store_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN receipt r ON r.order_id=o.order_id
WHERE s.store_id = _store_id AND year(p.RegDate) = _year AND p.status=0 AND o.status=1 GROUP BY p.pro_id;

ELSEIF(_item_id = '')THEN
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`In Quantity`,st_out_qty(p.pro_id,p.status)`Out Quantity`,CONCAT('$',p.total_price)`Total Cost`,CONCAT('$',ifnull(SUM(r.paid),0))`Total Income`, CONCAT('$',ifnull(SUM(r.paid),0) - p.total_price)`Profit`,p.RegDate`Date`
FROM orders o
JOIN products p ON p.pro_id=o.pro_id
JOIN store s ON s.store_id=p.store_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN receipt r ON r.order_id=o.order_id
WHERE s.store_id = _store_id AND year(p.RegDate) = _year AND p.status=0 AND month(p.RegDate) = _month AND o.status=1 GROUP BY p.pro_id;

ELSEIF(_month = '')THEN
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`In Quantity`,st_out_qty(p.pro_id,p.status)`Out Quantity`,CONCAT('$',p.total_price)`Total Cost`,CONCAT('$',ifnull(SUM(r.paid),0))`Total Income`, CONCAT('$',ifnull(SUM(r.paid),0) - p.total_price)`Profit`,p.RegDate`Date`
FROM orders o
JOIN products p ON p.pro_id=o.pro_id
JOIN store s ON s.store_id=p.store_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN receipt r ON r.order_id=o.order_id
WHERE s.store_id = _store_id AND year(p.RegDate) = _year AND p.status=0 AND p.item_id = _item_id AND o.status=1 GROUP BY p.pro_id;

ELSE
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`In Quantity`,st_out_qty(p.pro_id,p.status)`Out Quantity`,CONCAT('$',p.total_price)`Total Cost`,CONCAT('$',ifnull(SUM(r.paid),0))`Total Income`, CONCAT('$',ifnull(SUM(r.paid),0) - p.total_price)`Profit`,p.RegDate`Date`
FROM orders o
JOIN products p ON p.pro_id=o.pro_id
JOIN store s ON s.store_id=p.store_id
JOIN items i ON i.item_id=p.item_id
LEFT JOIN receipt r ON r.order_id=o.order_id
WHERE s.store_id = _store_id AND  p.item_id = _item_id AND p.status=0 AND year(p.RegDate) = _year AND month(p.RegDate) = _month AND o.status=1 GROUP BY p.pro_id;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `store_out_sp` (IN `_order_id` INT, IN `_pro_id` INT, IN `_out_qty` INT, IN `_date` DATE)   BEGIN

SELECT p.purchase_id,p.pro_id INTO @pur,@pro_id FROM products p WHERE p.pro_id=_pro_id AND p.status=0; 

IF(_pro_id = @pro_id AND @pur = 0)THEN
SELECT CONCAT('danger|','Horay ayuu udhamaday Product ID ',_pro_id,' thanks!!');

ELSEIF(_pro_id = @pro_id AND @pur != 0)THEN
SELECT CONCAT('danger|','Product ID ',_pro_id,' waala cancelay thanks!!');

ELSE
INSERT INTO `store_out`(`order_id`, `pro_id`, `out_qty`, `Reg_date`)
VALUES(_order_id,_pro_id,_out_qty,_date);
SELECT CONCAT('success|','Successfully Registered');
END IF; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `store_report_sp` (IN `_store_id` VARCHAR(100), IN `_item_id` VARCHAR(100))   BEGIN
/*
SET @no = 0;
SELECT @no:=@no+1 `SNO`,p.pro_id,s.store_name,CONCAT(i.item_name,' ',i.Category)`item`,p.item_type,p.qty,st_out_qty(p.pro_id,p.status)`out_qty`,p.qty-st_out_qty(p.pro_id,p.status)`balance_qty` FROM products p 
JOIN items i ON i.item_id=p.item_id 
JOIN store s ON s.store_id=p.store_id
WHERE s.store_id = _store_id AND  p.item_id = _item_id AND p.status=1 GROUP BY p.pro_id;
*/


SET @no = 0;
IF(_item_id = '')THEN
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`Quantity`,st_out_qty(p.pro_id,p.status)`Out Quantity`,p.qty-st_out_qty(p.pro_id,p.status)`Balance Quantity`,p.RegDate`Date` FROM products p 
JOIN items i ON i.item_id=p.item_id 
JOIN store s ON s.store_id=p.store_id
WHERE s.store_id = _store_id AND p.status=1 GROUP BY p.pro_id;

ELSE
SELECT @no:=@no+1 `SNO`,p.pro_id`Pro ID`,s.store_name`Store`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,p.qty`Quantity`,st_out_qty(p.pro_id,p.status)`Out Quantity`,p.qty-st_out_qty(p.pro_id,p.status)`Balance Quantity`,p.RegDate`Date` FROM products p 
JOIN items i ON i.item_id=p.item_id 
JOIN store s ON s.store_id=p.store_id
WHERE s.store_id = _store_id AND  p.item_id = _item_id AND p.status=1 GROUP BY p.pro_id;
END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `store_sp` (IN `_store_name` VARCHAR(100), IN `_user_id` INT, IN `_date` DATE)   BEGIN

IF EXISTS(SELECT * FROM store s WHERE s.store_name =_store_name)THEN
SELECT CONCAT('danger|',_store_name,' Was Already Registered');

ELSE
INSERT INTO `store`(`store_name`, `user_id`, `RegDate`) 
VALUES (_store_name,_user_id,_date);
SELECT CONCAT('success|',_store_name,' Registered');
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sub_menu_sp` (IN `_action` TEXT)   BEGIN 

#SELECT m.text INTO @menu_id FROM menu m;
#SELECT s.menu_id INTO @smenu_id FROM sub_menu s;

IF(_action = 'Adminstrator')THEN
SELECT s.text`stext`, s.url`surl` FROM sub_menu s WHERE s.menu_id = 1; 

ELSEIF(_action = 'Purchase')THEN
SELECT s.text`stext`, s.url`surl` FROM sub_menu s WHERE s.menu_id = 2;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `supplier_all_report_sp` (IN `_supplier_id` INT)   BEGIN

SET @no =0;
SELECT @no:=@no+1 `SNO`,s.name`Name`,CONCAT(i.item_name,' ',i.Category)`Item`,pu.item_type`Item Type`,pu.qty`Quantity`,CONCAT('$',pu.price)`Price`,CONCAT('$',pu.total_price)`Total Price`,ifnull(CONCAT('$',SUM(pa.paid)),CONCAT('$',0))`Paid`,ifnull(CONCAT('$',SUM(pa.discount)),CONCAT('$',0))`Discount`,ifnull(CONCAT('$',pu.total_price-(SUM(pa.paid)+SUM(pa.discount))),CONCAT('$',pu.total_price))`Balance`,IF(pu.status=1,'Purchased','Canceled')`PU-Status`,IF(pa.status=1,'Payed',IF(pa.status=0,'Canceled','Not Payed'))`PA-Status` FROM supplier s
JOIN purchase pu ON pu.supplier_id=s.supplier_id
LEFT JOIN payments pa ON pa.purchase_id=pu.purchase_id
JOIN items i ON i.item_id=pu.item_id
WHERE s.supplier_id = _supplier_id
GROUP BY pu.purchase_id
UNION
SELECT '','','','','','','','','Total Balance',CONCAT('$',s.balance),'','' FROM supplier s
JOIN purchase pu ON pu.supplier_id=s.supplier_id
LEFT JOIN payments pa ON pa.purchase_id=pu.purchase_id
JOIN items i ON i.item_id=pu.item_id
WHERE s.supplier_id = _supplier_id
GROUP BY pu.purchase_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `supplier_sp` (IN `_name` VARCHAR(100), IN `_location` VARCHAR(100), IN `_user_id` INT, IN `_date` DATE)   BEGIN

IF EXISTS(SELECT * FROM supplier WHERE name=_name)THEN
SELECT concat('danger|',_name,' Was Already Registered');

ELSE
INSERT IGNORE INTO supplier (name,location,user_id,RegDate)
VALUES(_name,_location,_user_id,_date);

SELECT concat('success|',_name,' ',_location,' Successfully Registered');
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_orders_sp` (IN `_order_id` INT, IN `_pro_id` INT, IN `_qty` INT, IN `_price` FLOAT, IN `_totatl_price` FLOAT, IN `_status` INT)   BEGIN
#SELECT ord.status,ord.total_price INTO @old_st,@old_total FROM orders ord WHERE ord.order_id=_order_id;

SELECT SUM(o.qty) INTO @out_qty FROM orders o WHERE o.pro_id=_pro_id;
SELECT od.qty INTO @click_one_qty FROM orders od WHERE od.order_id=_order_id;
SELECT (ifnull(@out_qty,0) + _qty) INTO @t_out_qty;
SELECT (@t_out_qty - @click_one_qty) INTO @tt_out_qty;
SELECT p.qty INTO @in_qty FROM products p WHERE p.pro_id=_pro_id;
SELECT (@in_qty - @tt_out_qty) INTO @pro_qty;


#UPDATE ORDERS
IF(@pro_qty < 0 AND _status = 1)THEN
SET @no = 'No';

ELSEIF(@pro_qty < 0 AND _status = 0)THEN
SET @no = 'No';

ELSE
UPDATE `orders` SET `pro_id`=_pro_id,`qty`=_qty,`price`=_price,`total_price`=_totatl_price,`status`=_status
WHERE `order_id`=_order_id;

#Hadii qty-ga lo badsho i.w.m
/* IF(@old_st = 1 AND _status = 1)THEN
UPDATE customers c SET c.balance=( (c.balance + _total_price) - @old_total) WHERE c.cust_id=_cust_id;
END IF;
*/
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_payments_sp` (IN `_payment_id` INT, IN `_purchase_id` INT, IN `_supplier_id` INT, IN `_total_price` FLOAT, IN `_paid` INT, IN `_discount` DOUBLE, IN `_balance` FLOAT, IN `_sender` INT, IN `_receifer` INT, IN `_ref_no` VARCHAR(50), IN `_status` INT)   BEGIN

UPDATE `payments` SET `purchase_id`=_purchase_id,`supplier_id`=_supplier_id,`total_price`=_total_price,`paid`=_paid,`discount`=_discount,`balance`=_balance,`Sender`=_sender,`receifer`=_receifer,`status`=_status,`ref_no`=_ref_no WHERE `payment_id`=_payment_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_purchase_sp` (IN `_purchase_id` INT, IN `_supplier_id` INT, IN `_item_id` INT, IN `_item_type` VARCHAR(100), IN `_qty` INT, IN `_price` FLOAT, IN `_total` FLOAT, IN `_status` INT)   BEGIN

UPDATE `purchase` SET `supplier_id`=_supplier_id,`item_id`=_item_id,`item_type`=_item_type,`qty`=_qty,`price`=_price,`total_price`=_total,`status`=_status WHERE `purchase_id`=_purchase_id;

UPDATE products p SET p.item_id=_item_id ,p.item_type=_item_type ,p.qty=_qty ,p.price=_price ,p.total_price=_total, p.status=_status WHERE p.purchase_id=_purchase_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_receipt_sp` (IN `_receipt_id` INT, IN `_order_id` INT, IN `_paid` FLOAT, IN `_discount` FLOAT, IN `_account_id` INT, IN `_send_num` INT, IN `_status` INT)   BEGIN
START TRANSACTION;
SELECT r.current_amount INTO @total FROM receipt r WHERE r.rec_id=_receipt_id;

SELECT (@total - _paid) INTO @new_re;
SELECT (@new_re - _discount) INTO @new_bal;

UPDATE `receipt` SET `order_id`=_order_id,`paid`=_paid,`remained`=@new_re,`discount`=_discount,`new_balance`=@new_bal,`account_id`=_account_id,`send_number`=_send_num,`status`=_status WHERE `rec_id`=_receipt_id;

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_users_sp` (IN `_user_id` INT, IN `_username` VARCHAR(50), IN `_password` VARCHAR(50), IN `_gender` VARCHAR(50), IN `_image` VARCHAR(50), IN `_status` INT, IN `_type` VARCHAR(20), IN `_sec_question` TEXT, IN `_sec_answer` VARCHAR(50))   BEGIN

SELECT image INTO @img FROM users WHERE user_id=_user_id;

IF(_type = 'Developer')THEN
SELECT CONCAT('danger|',' You can`t take this type Developer');

ELSE
IF(_user_id = 0)THEN
SELECT CONCAT('danger|',' You can`t Update this User');

ELSE
IF (_image = 'images/')THEN
UPDATE `users` SET `username`=_username,`password`=_password,`gender`=_gender,`image`=@img,`status`=_status,`type`=_type,`sec_question`=_sec_question,`sec_answer`=_sec_answer WHERE user_id=_user_id;
SELECT CONCAT('success|',' Updated Successfully');
ELSE
UPDATE `users` SET `username`=_username,`password`=_password,`gender`=_gender,`image`=_image,`status`=_status,`type`=_type,`sec_question`=_sec_question,`sec_answer`=_sec_answer  WHERE user_id=_user_id;
SELECT CONCAT('success|',' Updated Successfully');
END IF;

END IF;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_sp` (IN `_emp_id` INT, IN `_user` VARCHAR(20), IN `_pass` VARCHAR(20), IN `_gender` VARCHAR(20), IN `_img` VARCHAR(30), IN `_type` VARCHAR(30), IN `_sec_question` TEXT, IN `_sec_answer` VARCHAR(50), IN `_date` DATE)   BEGIN

START TRANSACTION;
IF(_type = 'Developer')THEN
SELECT CONCAT('danger|',' You can`t take this type Developer');

ELSE
IF (_emp_id = '')THEN
SELECT CONCAT('danger|',' Choose Employee');

ELSEIF(_sec_question = '')THEN
SELECT CONCAT('danger|',' Fadlan dooro Secret Question');

ELSE
SELECT e.emp_name INTO @emp_name FROM employee e WHERE e.emp_id = _emp_id;

IF EXISTS(SELECT * FROM users u WHERE u.emp_id=_emp_id)THEN
SELECT CONCAT('danger|',@emp_name,' Was Already Registered');

ELSE 
INSERT INTO `users`(`emp_id`, `username`, `password`, `gender`, `image`, `type`, `sec_question`, `sec_answer`, `RegDate`) 
VALUES(_emp_id,_user,_pass,_gender,_img,_type,_sec_question,_sec_answer,_date);

SELECT CONCAT('success|',@emp_name,' Registered');
END IF;
END IF;

END IF;
COMMIT;

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `chart_count` (`_action` TEXT) RETURNS TEXT CHARSET utf8mb4  BEGIN

IF(_action = 'todayorders')THEN
SELECT COUNT(*) INTO @result FROM orders o
WHERE o.order_id NOT IN(SELECT receipt.order_id FROM receipt)
AND o.status=1 AND o.RegDate=date(now());

ELSEIF(_action = 'users')THEN
SELECT COUNT(*) INTO @result FROM users WHERE users.user_id != 0;

ELSEIF(_action = 'receipt')THEN
SELECT CONCAT('$',ifnull(sum(r.paid),0))`count` INTO @result FROM receipt r WHERE r.status=1 AND r.RegDate=date(now());


ELSEIF(_action = 'store')THEN
SELECT COUNT(*) INTO @result FROM products p 
JOIN items i ON i.item_id=p.item_id 
JOIN store s ON s.store_id=p.store_id
WHERE s.store_id LIKE '%' AND p.status=1;

ELSEIF(_action = 'total_orders')THEN
SELECT COUNT(*) INTO @result FROM orders o
WHERE o.status=1;

ELSEIF(_action = 'this_month_orders')THEN
SELECT month(now()),year(now()) INTO @m,@y;
SELECT COUNT(*) INTO @result FROM orders o
WHERE o.status=1 AND o.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now());

ELSEIF(_action = 'unpaid_orders')THEN
SELECT COUNT(*) INTO @result FROM `unpaid_orders_view`;

ELSEIF(_action = 'cancel_orders')THEN
SELECT COUNT(*) INTO @result FROM orders o
WHERE o.status=0;

ELSEIF(_action = 'total_purchase')THEN
SELECT COUNT(*) INTO @result FROM purchase p 
WHERE p.status=1;

ELSEIF(_action = 'month_purchase')THEN
SELECT month(now()),year(now()) INTO @m,@y;
SELECT COUNT(*) INTO @result FROM purchase p
WHERE p.status=1 AND p.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now());

ELSEIF(_action = 'unpaid_purchase')THEN
SELECT COUNT(*) INTO @result FROM unpaid_purchase_view;

ELSEIF(_action = 'cancel_purchase')THEN
SELECT COUNT(*) INTO @result FROM purchase p
WHERE p.status=0;


END IF;

RETURN @result;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_bal` (`_action` TEXT, `_id` TEXT) RETURNS TEXT CHARSET utf8mb4  BEGIN
/*SELECT r.cust_id,r.order_id,r.current_amount,SUM(r.paid)`Paid`,SUM(r.discount)`Discount`,r.current_amount - (SUM(r.paid)+SUM(r.discount))`Balance` FROM receipt r WHERE r.order_id=4_order_id
GROUP BY r.order_id;*/

IF(_action = 'order')THEN
SELECT ifnull( r.current_amount - (SUM(r.paid)+SUM(r.discount)),r.current_amount ) INTO @val FROM receipt r WHERE r.order_id=_id AND r.status=1
GROUP BY r.order_id;

ELSEIF(_action = 'purchase')THEN
SELECT (pa.total_price - SUM(pa.paid)) INTO @val FROM payments pa
WHERE pa.purchase_id=_id
GROUP BY pa.purchase_id;
END IF;

RETURN @val;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `payments_refno` () RETURNS INT(11)  BEGIN

SET @refno = 1;

SELECT p.ref_no+1 INTO @refno FROM payments p ORDER BY p.ref_no DESC LIMIT 1;

RETURN @refno;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `receipt_chart_count` (`_action` TEXT) RETURNS TEXT CHARSET utf8mb4  BEGIN

IF(_action = 'total_receipt')THEN
SELECT CONCAT(SUM(r.paid)) INTO @result FROM receipt r
WHERE r.status=1;

ELSEIF(_action = 'month_receipt')THEN
SELECT month(now()),year(now()) INTO @m,@y;
SELECT CONCAT(SUM(r.paid)) INTO @result FROM receipt r
WHERE r.status=1 AND r.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now());

ELSEIF(_action = 'today_receipt')THEN
SELECT CONCAT(SUM(r.paid)) INTO @result FROM receipt r
WHERE r.status=1 AND r.RegDate = date(now());

ELSEIF(_action = 'cancel_receipt')THEN
SELECT CONCAT(SUM(r.paid)) INTO @result FROM receipt r
WHERE r.status=0;

ELSEIF(_action = 'total_payments')THEN
SELECT CONCAT(SUM(p.paid)) INTO @result FROM payments p
WHERE p.status=1;

ELSEIF(_action = 'today_payments')THEN
SELECT CONCAT(SUM(p.paid)) INTO @result FROM payments p
WHERE p.status=1 AND p.RegDate = date(now());

ELSEIF(_action = 'month_payments')THEN
SELECT month(now()),year(now()) INTO @m,@y;
SELECT CONCAT(SUM(p.paid)) INTO @result FROM payments p
WHERE p.status=1 AND p.RegDate BETWEEN CONCAT(@y,'-',@m,'-',1) AND last_day(now());

ELSEIF(_action = 'cancel_payments')THEN
SELECT CONCAT(SUM(p.paid)) INTO @result FROM payments p
WHERE p.status=0;

END IF;

RETURN CONCAT('$',ifnull(@result,0));
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ref_no` () RETURNS INT(11)  BEGIN

SET @ref_no = 1;

SELECT r.ref_no+1 INTO @ref_no FROM receipt r ORDER BY r.ref_no DESC LIMIT 1;

RETURN @ref_no;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `st_out_qty` (`_pro_id` INT, `_status` INT) RETURNS INT(11)  BEGIN

SELECT SUM(st.out_qty) INTO @st FROM products p 
LEFT JOIN store_out st ON st.pro_id=p.pro_id 
WHERE p.status=_status AND st.status=1 AND p.pro_id=_pro_id;

RETURN ifnull(@st,0);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` int(11) NOT NULL,
  `account_no` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `account_no`, `bank_name`, `balance`, `user_id`, `RegDate`) VALUES
(1, '252627', 'IBS Bank', 0, 1, '2022-06-29'),
(2, '252628', 'IBS Bank', 0, 1, '0000-00-00'),
(3, '252789', 'Salaam Soomaali Bank', 0, 1, '2022-07-06'),
(4, '252627', 'Salaam Soomaali Bank', 0, 1, '2022-07-06'),
(5, '252789', 'IBS Bank', 0, 1, '2022-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `chart`
--

CREATE TABLE `chart` (
  `id` int(11) NOT NULL,
  `action` text NOT NULL,
  `text` text NOT NULL,
  `icon` text NOT NULL,
  `color` text NOT NULL,
  `order_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chart`
--

INSERT INTO `chart` (`id`, `action`, `text`, `icon`, `color`, `order_by`) VALUES
(1, 'todayorders', 'New Orders', 'fa fa-shopping-bag', 'bg-info', 1),
(2, 'Users', 'User Registrations', 'fa fa-users', 'bg-lime', 4),
(3, 'receipt', 'Today Receipt', 'ion ion-cash', 'bg-success', 2),
(4, 'store', 'Total Items', 'fa fa-store', 'bg-teal', 3),
(5, 'unpaid_orders', 'Total Unpaid Orders', 'fa fa-shopping-bag', 'bg-lime', 5);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(11) NOT NULL,
  `cust_name` varchar(100) DEFAULT NULL,
  `tell` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `balance` float DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `cust_name`, `tell`, `address`, `balance`, `user_id`, `RegDate`) VALUES
(1, 'Raage Cali', '+252617900990', 'Juungale', 3580, 1, '2022-06-29'),
(2, 'Cali Geedi Faarax', '+252617898909', 'Jardiinka', 77, 1, '2022-06-29'),
(3, 'Xassan Maxamed', '+252618123450', 'Kaaraan', 576, 1, '2022-07-08'),
(4, 'Joker', '+252613353556', 'Jardiinka', 1148, 1, '2022-07-08'),
(5, 'Cali Xussen', '+252617488879', 'Kaaraan', 1150, 1, '2022-07-19'),
(6, 'Seedow Nuur', '+252617890979', 'Gubadleey', 0, 1, '2022-07-29'),
(7, 'Axmed Cali', '+252618987654', 'Kaaraan', 0, 1, '2022-07-29'),
(8, 'Deeq Xasan', '+252615790989', 'Kaaraan', 10, 0, '2022-09-03');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(100) DEFAULT NULL,
  `tell` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jobtitle` varchar(100) DEFAULT NULL,
  `salary` float DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_name`, `tell`, `address`, `email`, `jobtitle`, `salary`, `status`, `RegDate`) VALUES
(0, 'Cabdicasiis Shiikh Nuur', '+252619630031', 'Yaaqshiid', 'dayib@gmail.com', '', 100, 1, '2022-09-02'),
(1, 'Cali Xussen Maxamuud', '+252617488879', 'Fagax', 'cali2022@gmail.com', 'Manager', 780, 1, '2022-06-22'),
(2, 'Cabdullahi Yasiin Cabdi', '+252613353556', 'Jardiinka', 'cyc114@gmail.com', 'Manager', 790, 1, '2022-06-22'),
(3, 'Xassan Shiikh Nuur', '+252615574216', 'Juungale', 'xassanshiikh@gmail.com', 'Cashier', 700, 1, '2022-06-29'),
(4, 'Japir Ali Abdi', '+252612042527', 'Karan', 'japir2022@gmail.com', 'Marketing', 760, 1, '2022-07-18'),
(5, 'Liibaan Osman Nur', '+252615614248', 'Fagax', 'liban@gmail.com', 'Marketing', 750, 1, '2022-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `exp_id` int(11) NOT NULL,
  `exp_name` varchar(100) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `tell` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`exp_id`, `exp_name`, `amount`, `tell`, `description`, `user_id`, `RegDate`) VALUES
(1, 'Koronto', 20, 618988978, 'Becco', 1, '2022-07-03'),
(2, 'Biyo', 14, 617353890, 'Biyo', 1, '2022-07-03'),
(3, 'Other', 20, 617676754, 'Unknown Waxaa amray Eng Cali', 1, '2022-07-18'),
(4, 'Other', 4, 615346383, 'Caawimaad Waxa amray Eng Joker', 1, '2022-07-18'),
(5, 'Koronto', 18, 615435678, 'Mogadisho', 2, '2022-09-03'),
(6, 'Koronto', 20.5, 617655443, 'Becco', 0, '2022-09-05');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `Reg_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `Category`, `Reg_date`) VALUES
(1, 'HP', 'Laptop', '2022-07-06'),
(2, 'HP', 'Desktop', '2022-07-16'),
(3, 'Dell', 'Desktop', '2022-07-16'),
(4, 'Dell', 'Laptop', '2022-07-18'),
(5, 'Toshiba', 'Laptop', '2022-07-18'),
(6, 'iPhone 13', 'Mobile', '2022-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `text`, `icon`, `order_by`) VALUES
(1, 'Adminstrator', 'fas fa-users', 2),
(2, 'Purchase', 'fas fa-cart-plus', 3),
(3, 'Store', 'fas fa-store', 4),
(4, 'Transactions', 'fas fa-briefcase', 5),
(5, 'Reports', 'fas fa-list', 6),
(6, 'Developer', 'fab fa-dochub', 1),
(7, 'Charts', 'fas fa-th-large', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `pro_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `cust_id`, `pro_id`, `qty`, `price`, `total_price`, `user_id`, `status`, `RegDate`) VALUES
(3, 4, 1, 1, 579, 579, 1, 1, '2022-07-22'),
(4, 4, 2, 2, 360, 720, 1, 1, '2022-07-22'),
(5, 5, 1, 2, 578, 1156, 1, 1, '2022-07-24'),
(6, 3, 2, 1, 357, 357, 1, 1, '2022-07-24'),
(7, 3, 1, 1, 576, 576, 1, 1, '2022-07-25'),
(8, 1, 1, 1, 580, 580, 1, 1, '2022-07-25'),
(9, 2, 1, 1, 577, 577, 1, 1, '2022-07-25'),
(10, 2, 2, 1, 355, 355, 1, 1, '2022-06-25'),
(11, 5, 2, 1, 356, 356, 1, 1, '2022-07-25'),
(12, 4, 1, 2, 574, 1148, 1, 1, '2022-07-25'),
(13, 5, 3, 1, 410, 410, 1, 0, '2022-07-25'),
(14, 3, 3, 1, 408, 408, 1, 1, '2022-07-26'),
(15, 4, 3, 1, 404, 404, 1, 1, '2022-07-27'),
(16, 6, 3, 6, 405, 2430, 1, 1, '2022-07-29'),
(17, 7, 4, 3, 372, 1116, 2, 1, '2022-08-14'),
(18, 7, 4, 2, 376, 752, 2, 1, '2022-08-14'),
(19, 1, 4, 5, 377, 1885, 1, 1, '2022-08-15'),
(20, 5, 7, 1, 760, 760, 0, 1, '2022-08-27'),
(21, 8, 9, 1, 1500, 1500, 0, 1, '2022-09-03'),
(22, 5, 1, 2, 575, 1150, 0, 1, '2022-09-10'),
(24, 8, 7, 1, 775, 775, 0, 1, '2023-01-01'),
(25, 8, 5, 1, 580, 580, 0, 1, '2023-01-01');

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `after_del_order_st_out_del` AFTER DELETE ON `orders` FOR EACH ROW DELETE FROM store_out WHERE order_id=old.order_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_order_cust_balance0` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
#Hadii waxba lasoo gelin
IF(old.status = 0 AND new.status = 0)THEN
SET @no = 'no';

ELSE
#IF ORDER CANCEL
IF(new.status = 0)THEN
#SELECT r.paid INTO @paid FROM receipt r WHERE r.order_id=old.order_id;
UPDATE customers c SET c.balance=( (c.balance - new.total_price) )  WHERE c.cust_id=new.cust_id;
END IF;

#IF ORDER WAS CANCEL THEN ORDERED
IF(old.status = 0 AND new.status = 1)THEN
/* SELECT SUM(r.paid + r.discount) INTO @t_rec FROM receipt r WHERE r.cust_id=new.cust_id AND r.status=1;
SELECT ord.total_price INTO @t_ord FROM orders ord WHERE ord.cust_id=new.cust_id AND ord.status=1;
SELECT ( @t_ord - ifnull(@t_rec,0) ) INTO @real_; */ 

UPDATE customers c SET c.balance = (c.balance + new.total_price) WHERE c.cust_id=new.cust_id;
END IF;

#Hadii qty-ga lo badsho i.w.m
IF(old.status = 1 AND new.status = 1)THEN
UPDATE customers c SET c.balance=(c.balance + new.total_price - old.total_price ) WHERE c.cust_id=new.cust_id;
END IF;

END IF;


END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_order_st_out_&_pro_update` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN

SELECT SUM(o.qty) INTO @out_qty FROM orders o WHERE o.pro_id=new.pro_id AND o.status=1;
SELECT old.qty INTO @click_one_qty FROM orders od WHERE od.order_id=old.order_id;
SELECT (ifnull(@out_qty,0) + new.qty) INTO @t_out_qty;
SELECT (@t_out_qty - @click_one_qty) INTO @tt_out_qty;
SELECT p.qty INTO @in_qty FROM products p WHERE p.pro_id=new.pro_id;
SELECT (@in_qty - @tt_out_qty) INTO @pro_qty;

#UPDATE PRODUCTS
#if new.status=0 then not update
IF(@pro_qty < 0 AND new.status = 0)THEN
SET @no = 'No';

#if order cancel then product exists
ELSEIF(@pro_qty = 0 AND new.status = 0)THEN
UPDATE products p SET p.status=1 WHERE p.pro_id=new.pro_id;

#if order cancel then product exists
ELSEIF(@pro_qty < @in_qty AND new.status = 0)THEN
UPDATE products p SET p.status=1 WHERE p.pro_id=new.pro_id;

#if qty +lagu sameyo @in_qty isku mid naqdan then product end
ELSEIF(@pro_qty = 0 AND new.status = 1)THEN
UPDATE products p SET p.status=0 WHERE p.pro_id=new.pro_id;

#if qty +lagu sameyo @in_qty-na lagarin then product not end
ELSEIF(@pro_qty < @in_qty AND new.status = 1)THEN
UPDATE products p SET p.status=1 WHERE p.pro_id=new.pro_id;
END IF;
#END UPDATE PRODUCTS



#UPDATE STORE OUT
IF(new.status = 0)THEN
UPDATE store_out s SET s.pro_id=new.pro_id, s.out_qty=new.qty, s.status=0 WHERE s.order_id=new.order_id;

ELSEIF(new.status = 1)THEN
UPDATE store_out s SET s.pro_id=new.pro_id, s.out_qty=new.qty, s.status=1 WHERE s.order_id=new.order_id;
END IF;
#END UPDATE STORE OUT

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cust_balance_after_insert_order` AFTER INSERT ON `orders` FOR EACH ROW UPDATE customers c SET c.balance= (c.balance + new.total_price) WHERE c.cust_id=new.cust_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_chart`
--

CREATE TABLE `order_chart` (
  `id` int(11) NOT NULL,
  `action` text NOT NULL,
  `text` text NOT NULL,
  `icon` text NOT NULL,
  `color` text NOT NULL,
  `order_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_chart`
--

INSERT INTO `order_chart` (`id`, `action`, `text`, `icon`, `color`, `order_by`) VALUES
(1, 'total_orders', 'Total Orders', 'ion ion-bag', 'bg-info', 1),
(2, 'this_month_orders', 'Month Orders', 'ion ion-bag', 'bg-success', 2),
(3, 'unpaid_orders', 'Total Unpaid Orders', 'ion ion-bag', 'bg-warning', 2),
(4, 'cancel_orders', 'Cancel Orders', 'ion ion-bag', 'bg-danger', 4);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `paid` float NOT NULL,
  `discount` double NOT NULL,
  `balance` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Sender` int(11) NOT NULL,
  `receifer` int(11) NOT NULL,
  `ref_no` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `purchase_id`, `supplier_id`, `total_price`, `paid`, `discount`, `balance`, `user_id`, `Sender`, `receifer`, `ref_no`, `status`, `RegDate`) VALUES
(1, 1, 1, 17100, 15000, 0, 2100, 1, 1, 234545, '974782', 1, '2022-07-22'),
(2, 1, 1, 2100, 1000, 0, 1100, 1, 4, 234545, '190190', 1, '2022-06-22'),
(3, 1, 1, 1100, 1100, 0, 0, 1, 1, 234545, '820290', 1, '2022-07-31'),
(4, 2, 2, 3500, 500, 0, 3000, 1, 5, 234890, '792345', 1, '2022-07-31'),
(5, 5, 3, 8550, 8500, 50, 0, 1, 1, 278989, '959342', 1, '2022-08-15'),
(6, 2, 2, 3000, 3000, 0, 0, 1, 1, 278989, '948392', 1, '2022-08-16'),
(7, 9, 4, 14000, 13500, 500, 0, 0, 2, 245678, '290987', 1, '2022-09-03');

--
-- Triggers `payments`
--
DELIMITER $$
CREATE TRIGGER `after_payment_insert_supp_bal` AFTER INSERT ON `payments` FOR EACH ROW BEGIN

SELECT (new.paid + new.discount) INTO @new_bal;

UPDATE supplier s SET s.balance=(s.balance - @new_bal) WHERE s.supplier_id=new.supplier_id;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_payments_supp_bal` AFTER UPDATE ON `payments` FOR EACH ROW BEGIN
#Hadii waxba lasoo gelin
IF(old.status = 0 AND new.status = 0)THEN
SET @no = 'no';

ELSE
#if payment cancel
IF(new.status = 0)THEN
UPDATE supplier s SET s.balance=(s.balance + old.paid + old.discount) WHERE s.supplier_id=new.supplier_id;
END IF;

#IF WAS CANCELED THEN PAYMENT
IF(old.status = 0 AND new.status = 1)THEN
UPDATE supplier s SET s.balance=(s.balance - old.paid - old.discount) WHERE s.supplier_id=new.supplier_id;
END IF;

#Hadii qty-ga lo badsho i.w.m
IF(old.status = 1 AND new.status = 1)THEN
UPDATE supplier s SET s.balance=(s.balance + new.balance - old.balance) WHERE s.supplier_id=new.supplier_id;
END IF;

END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pay_salary`
--

CREATE TABLE `pay_salary` (
  `pay_sal_id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `salary` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `receifer` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pay_salary`
--

INSERT INTO `pay_salary` (`pay_sal_id`, `emp_id`, `salary`, `amount`, `type`, `acc_id`, `receifer`, `user_id`, `date`) VALUES
(1, 1, 780, 200, 'Hormaris', 1, 617488879, 0, '2022-08-03'),
(2, 1, 580, 580, 'Salary', 1, 617488879, 0, '2022-08-03'),
(3, 1, 780, 250, 'Hormaris', 1, 617488879, 0, '2022-09-03'),
(4, 1, 530, 530, 'Salary', 1, 617488879, 0, '2022-09-03'),
(5, 2, 790, 300, 'Hormaris', 4, 613353556, 0, '2022-09-03'),
(6, 2, 490, 490, 'Salary', 4, 613353556, 0, '2022-09-03');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `store_id` int(100) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `purchase_id`, `store_id`, `item_id`, `item_type`, `qty`, `price`, `total_price`, `user_id`, `status`, `RegDate`) VALUES
(1, 1, 1, 1, 'Core i7 Ram 16GB HDD 1TB', 30, 570, 17100, 1, 1, '2022-07-19'),
(2, 2, 1, 5, 'Core i5 Ram 4GB HDD 1TB', 10, 350, 3500, 1, 1, '2022-07-19'),
(3, 3, 1, 1, 'Core i5 Ram 4GB HDD 1TB', 8, 400, 3200, 1, 0, '2022-07-25'),
(4, 4, 2, 4, 'Core i5 Ram 4GB HDD 500GB', 10, 370, 3700, 1, 0, '2022-08-29'),
(5, 5, 2, 1, 'Core i3 Ram 8GB SSD 512GB', 15, 570, 8550, 1, 1, '2022-08-16'),
(6, 6, 2, 1, 'Core i7 Ram 16GB SSD 512GB', 10, 700, 7000, 1, 1, '2022-08-16'),
(7, 7, 3, 3, 'Core i7 Ram 8GB SSD 1TB', 7, 750, 5250, 1, 1, '2022-08-22'),
(8, 8, 3, 2, 'Core i5 Ram 16GB SSD 2TB', 5, 750, 3750, 0, 1, '2022-08-28'),
(9, 9, 3, 6, 'Ram 16GB Storage 256GB Silver', 10, 1400, 14000, 0, 1, '2022-09-03'),
(10, 10, 3, 6, 'Ram 16GB Storage 256GB Silver', 20, 900, 18000, 0, 1, '2022-09-12');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_type` varchar(100) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `supplier_id`, `item_id`, `item_type`, `qty`, `price`, `total_price`, `user_id`, `status`, `RegDate`) VALUES
(1, 1, 1, 'Core i7 Ram 16GB HDD 1TB', 30, 570, 17100, 1, 1, '2022-06-19'),
(2, 2, 5, 'Core i5 Ram 4GB HDD 1TB', 10, 350, 3500, 1, 1, '2022-07-19'),
(3, 1, 1, 'Core i5 Ram 4GB HDD 1TB', 8, 400, 3200, 1, 1, '2022-07-25'),
(4, 2, 4, 'Core i5 Ram 4GB HDD 500GB', 10, 370, 3700, 1, 1, '2022-07-29'),
(5, 3, 1, 'Core i3 Ram 8GB SSD 512GB', 15, 570, 8550, 1, 1, '2022-08-16'),
(6, 3, 1, 'Core i7 Ram 16GB SSD 512GB', 10, 700, 7000, 1, 1, '2022-08-16'),
(7, 2, 3, 'Core i7 Ram 8GB SSD 1TB', 7, 750, 5250, 1, 1, '2022-08-22'),
(8, 2, 2, 'Core i5 Ram 16GB SSD 2TB', 5, 750, 3750, 0, 1, '2022-08-28'),
(9, 4, 6, 'Ram 16GB Storage 256GB Silver', 10, 1400, 14000, 0, 1, '2022-09-03'),
(10, 3, 6, 'Ram 16GB Storage 256GB Silver', 20, 900, 18000, 0, 1, '2022-09-12');

--
-- Triggers `purchase`
--
DELIMITER $$
CREATE TRIGGER `after_purchase_insert_supp_balance` AFTER INSERT ON `purchase` FOR EACH ROW UPDATE supplier s SET s.balance = (s.balance + new.total_price) WHERE s.supplier_id = new.supplier_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_purchase_supp_bal` AFTER UPDATE ON `purchase` FOR EACH ROW BEGIN
#Hadii waxba lasoo gelin
IF(old.status = 0 AND new.status = 0)THEN
SET @no = 'no';

ELSE
#IF PURCHASE CANCEL
IF(new.status = 0)THEN
#SELECT r.paid INTO @paid FROM receipt r WHERE r.order_id=old.order_id;
UPDATE supplier s SET s.balance=( (s.balance - new.total_price) )  WHERE s.supplier_id=new.supplier_id;
END IF;

#IF PURCHASE WAS CANCEL THEN PURCHASED
IF(old.status = 0 AND new.status = 1)THEN
UPDATE supplier s SET s.balance = (s.balance + new.total_price) WHERE s.supplier_id=new.supplier_id;
END IF;

#Hadii qty-ga lo badsho i.w.m
IF(old.status = 1 AND new.status = 1)THEN
UPDATE supplier s SET s.balance=(s.balance + new.total_price - old.total_price ) WHERE s.supplier_id=new.supplier_id;
END IF;

END IF;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_chart`
--

CREATE TABLE `purchase_chart` (
  `id` int(11) NOT NULL,
  `action` text NOT NULL,
  `text` text NOT NULL,
  `icon` text NOT NULL,
  `color` text NOT NULL,
  `order_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_chart`
--

INSERT INTO `purchase_chart` (`id`, `action`, `text`, `icon`, `color`, `order_by`) VALUES
(1, 'total_purchase', 'Total Purchase', 'fas fa-cart-plus', 'bg-info', 1),
(2, 'month_purchase', 'Month Purchase', 'fas fa-cart-plus', 'bg-success', 2),
(3, 'unpaid_purchase', 'Total Unpaid Purchase', 'fas fa-cart-plus', 'bg-warning', 3),
(4, 'cancel_purchase', 'Cancel Purchase', 'fas fa-cart-plus', 'bg-danger', 4),
(5, 'total_payments', 'Total Payments', 'fab fa-amazon-pay', 'bg-info', 7),
(6, 'month_payments', 'Month Payments', 'fab fa-amazon-pay', 'bg-success', 6),
(7, 'cancel_payments', 'Cancel Payments', 'fab fa-amazon-pay', 'bg-danger', 8),
(8, 'today_payments', 'Today Payments', 'fab fa-amazon-pay', 'bg-primary', 5);

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `rec_id` int(11) NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `current_amount` float DEFAULT NULL,
  `paid` double DEFAULT NULL,
  `remained` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `new_balance` float DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `send_number` int(9) DEFAULT NULL,
  `ref_no` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`rec_id`, `cust_id`, `order_id`, `current_amount`, `paid`, `remained`, `discount`, `new_balance`, `account_id`, `send_number`, `ref_no`, `user_id`, `status`, `RegDate`) VALUES
(2, 4, 3, 579, 500, 79, 9, 70, 619630031, 613353556, 1, 1, 1, '2022-07-22'),
(3, 4, 3, 70, 70, 0, 0, 0, 619630031, 613353556, 2, 1, 1, '2022-07-22'),
(4, 4, 4, 720, 550, 170, 0, 170, 619630031, 613353556, 3, 1, 1, '2022-06-23'),
(5, 4, 4, 170, 70, 100, 10, 90, 619630031, 613353556, 4, 1, 1, '2022-07-23'),
(6, 5, 5, 1156, 1000, 156, 0, 156, 619630031, 617488879, 5, 1, 1, '2022-07-24'),
(7, 5, 5, 156, 150, 6, 6, 0, 619630031, 617488879, 6, 1, 1, '2022-07-24'),
(8, 3, 6, 357, 357, 0, 0, 0, 619630031, 618123450, 7, 1, 1, '2022-07-25'),
(9, 5, 11, 356, 356, 0, 0, 0, 619630031, 617488879, 8, 1, 1, '2022-07-25'),
(10, 3, 14, 408, 408, 0, 0, 0, 619630031, 617467654, 9, 1, 1, '2022-07-29'),
(11, 4, 15, 404, 404, 0, 0, 0, 619630031, 617409876, 10, 1, 1, '2022-07-29'),
(12, 6, 16, 2430, 2430, 0, 0, 0, 619630031, 617412345, 11, 1, 1, '2022-07-29'),
(13, 2, 10, 355, 255, 100, 0, 100, 619630031, 618765432, 12, 1, 1, '2022-07-31'),
(14, 4, 4, 90, 90, 0, 0, 0, 619630031, 613353556, 13, 1, 1, '2022-07-31'),
(15, 2, 9, 577, 500, 77, 0, 77, 619630031, 616789000, 14, 1, 1, '2022-07-31'),
(16, 2, 10, 100, 100, 0, 0, 0, 619630031, 614253637, 15, 1, 1, '2022-07-31'),
(17, 7, 18, 752, 752, 0, 0, 0, 619630031, 618987654, 16, 2, 1, '2022-08-14'),
(18, 1, 19, 1885, 1885, 0, 0, 0, 619630031, 618987654, 17, 1, 1, '2022-08-15'),
(19, 7, 17, 1116, 1114, 2, 2, 0, 619630031, 618987654, 18, 1, 1, '2022-08-15'),
(20, 5, 20, 760, 758, 2, 2, 0, 619630031, 617488879, 19, 0, 1, '2022-08-27'),
(21, 8, 21, 1500, 1500, 0, 0, 0, 252627, 615434356, 20, 0, 1, '2022-09-03'),
(22, 8, 24, 775, 775, 0, 0, 0, 252627, 617676767, 21, 0, 1, '2023-01-01'),
(23, 8, 25, 580, 570, 10, 0, 10, 252628, 617878787, 22, 0, 1, '2023-01-01');

--
-- Triggers `receipt`
--
DELIMITER $$
CREATE TRIGGER `after_update_receipt_update_cust_bal` AFTER UPDATE ON `receipt` FOR EACH ROW BEGIN
#Hadii waxba lasoo gelin
IF(old.status = 0 AND new.status = 0)THEN
SET @no = 'no';

ELSE
#if receipt cancel
IF(new.status = 0)THEN
UPDATE customers c SET c.balance=(c.balance + old.paid + old.discount) WHERE c.cust_id=new.cust_id;
END IF;

#IF WAS CANCELED THEN RECEIPT
IF(old.status = 0 AND new.status = 1)THEN
UPDATE customers c SET c.balance=(c.balance - old.paid - old.discount) WHERE c.cust_id=new.cust_id;
END IF;

#Hadii qty-ga lo badsho i.w.m
IF(old.status = 1 AND new.status = 1)THEN
UPDATE customers c SET c.balance=(c.balance + new.new_balance - old.new_balance) WHERE c.cust_id=new.cust_id;
END IF;

END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cust_balance_after_insert_receipt` AFTER INSERT ON `receipt` FOR EACH ROW BEGIN

SELECT (new.paid + new.discount) INTO @new_bal;

UPDATE customers c SET c.balance=(c.balance - @new_bal) WHERE c.cust_id=new.cust_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_chart`
--

CREATE TABLE `receipt_chart` (
  `id` int(11) NOT NULL,
  `action` text NOT NULL,
  `text` text NOT NULL,
  `icon` text NOT NULL,
  `color` text NOT NULL,
  `order_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receipt_chart`
--

INSERT INTO `receipt_chart` (`id`, `action`, `text`, `icon`, `color`, `order_by`) VALUES
(1, 'total_receipt', 'Total Receipt', 'ion ion-cash', 'bg-info', 3),
(2, 'month_receipt', 'Month Receipt', 'ion ion-cash', 'bg-success', 2),
(3, 'cancel_receipt', 'Cancel Receipt', 'ion ion-cash', 'bg-danger', 4),
(4, 'today_receipt', 'Today Receipt', 'ion ion-cash', 'bg-primary', 1);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `RegDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `user_id`, `RegDate`) VALUES
(1, 'Store 1', 1, '2022-07-06'),
(2, 'Store 2', 1, '2022-07-06'),
(3, 'Store 3', 1, '2022-07-25');

-- --------------------------------------------------------

--
-- Table structure for table `store_out`
--

CREATE TABLE `store_out` (
  `store_out_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `out_qty` int(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `Reg_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_out`
--

INSERT INTO `store_out` (`store_out_id`, `order_id`, `pro_id`, `out_qty`, `status`, `Reg_date`) VALUES
(3, 3, 1, 1, 1, '2022-07-22'),
(4, 4, 2, 2, 1, '2022-07-22'),
(5, 5, 1, 2, 1, '2022-07-24'),
(6, 6, 2, 1, 1, '2022-07-24'),
(7, 7, 1, 1, 1, '2022-07-25'),
(8, 8, 1, 1, 1, '2022-07-25'),
(9, 9, 1, 1, 1, '2022-07-25'),
(10, 10, 2, 1, 1, '2022-07-25'),
(11, 11, 2, 1, 1, '2022-07-25'),
(12, 12, 1, 2, 1, '2022-07-25'),
(13, 13, 3, 1, 0, '2022-07-25'),
(14, 14, 3, 1, 1, '2022-07-26'),
(15, 15, 3, 1, 1, '2022-07-27'),
(16, 16, 3, 6, 1, '2022-07-29'),
(22, 17, 4, 3, 1, '2022-08-14'),
(23, 18, 4, 2, 1, '2022-08-14'),
(24, 19, 4, 5, 1, '2022-08-15'),
(25, 20, 7, 1, 1, '2022-08-27'),
(26, 21, 9, 1, 1, '2022-09-03'),
(27, 22, 1, 2, 1, '2022-09-10'),
(29, 24, 7, 1, 1, '2023-01-01'),
(30, 25, 5, 1, 1, '2023-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `order_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`id`, `text`, `url`, `menu_id`, `order_by`) VALUES
(1, 'New Account', 'acc_view.php', 1, 1),
(2, 'New User', 'users_view.php', 1, 2),
(3, 'New Employee', 'employees_view.php', 1, 3),
(4, 'New Salary', 'pay_sal_view.php', 1, 4),
(5, 'New Supplier', 'supplier_view.php', 2, 5),
(6, 'New Purchase', 'purchase_view.php', 2, 6),
(7, 'New Payment', 'payments_view.php', 2, 7),
(8, 'New Store', 'store_view.php', 3, 8),
(9, 'New Item', 'item_view.php', 3, 9),
(10, 'New Products', 'products_view.php', 3, 10),
(11, 'Product Out View', 'store_out_view.php', 3, 11),
(12, 'New Customer', 'cust_view.php', 4, 12),
(13, 'New Order', 'orders_view.php', 4, 13),
(14, 'New Receipt', 'receipt_view.php', 4, 14),
(15, 'New Expense', 'expenses_view.php', 4, 15),
(16, 'Customer Report', 'customer_all_report.php', 5, 16),
(17, 'Store Report', 'store_report.php', 5, 18),
(18, 'Order Chart', 'total_orders_chart.php', 7, 20),
(19, 'Receipt Chart', 'total_receipt_chart.php', 7, 21),
(20, 'Receipt Report', 'cust_receipt_report.php', 5, 17),
(21, 'Store Out Report', 'store_out_rep.php', 5, 19),
(22, 'Maximum Items Report', 'max_items.php', 5, 24),
(23, 'Purchase Chart ', 'total_purchase_chart.php', 7, 22),
(24, 'Salary Report', 'salary_report.php', 5, 25),
(25, 'Payments Chart', 'total_payments_chart.php', 7, 23),
(26, 'Expenses Report', 'expenses_report.php', 5, 26),
(27, 'New Menu', 'menu.php', 6, 27),
(28, 'New SubMenu', 'sub_menu.php', 6, 28),
(29, 'User Privilege', 'user_privilege.php', 1, 29),
(30, 'Supplier Report', 'supplier_all_report.php', 5, 30);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `balance` double DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `location`, `balance`, `user_id`, `RegDate`) VALUES
(1, 'Hormuud', 'Bakaaro', 3200, 1, '2022-07-16'),
(2, 'Somtel', 'N4', 12700, 1, '2022-07-16'),
(3, 'Somnet', 'Suuqbacaad', 25000, 1, '2022-08-16'),
(4, 'Nokia', 'Hoolwadaag', 580, 0, '2022-09-03');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `theme_type` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `unpaid_orders_view`
-- (See below for the actual view)
--
CREATE TABLE `unpaid_orders_view` (
`Order No` int(11)
,`Name` varchar(100)
,`Tell` varchar(100)
,`Item` varchar(201)
,`Item Type` varchar(100)
,`Quantity` int(11)
,`Price` float
,`Total` float
,`Paid` double
,`Discount` double
,`Balance` float
,`Date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `unpaid_purchase_view`
-- (See below for the actual view)
--
CREATE TABLE `unpaid_purchase_view` (
`Purchase No` int(11)
,`Name` varchar(100)
,`Item` varchar(201)
,`Item Type` varchar(100)
,`Quantity` int(11)
,`Price` varchar(13)
,`Total` varchar(13)
,`Paid` varchar(13)
,`Balance` varchar(13)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `type` text NOT NULL,
  `sec_question` text NOT NULL,
  `sec_answer` varchar(50) NOT NULL,
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `emp_id`, `username`, `password`, `gender`, `image`, `status`, `type`, `sec_question`, `sec_answer`, `RegDate`) VALUES
(0, 0, 'dayib', '123', 'Male', 'images/mee.jpg', 1, 'Developer', 'Sheeg goobta aad ku dhalatay?', 'Sanco', '2022-06-30'),
(1, 1, 'cali', '123', 'Male', 'images/1ali.jpg', 1, 'Admin', 'Waa maxay naa niistaada?', 'Suxeyfa', '2022-06-30'),
(2, 2, 'joker', '123', 'Male', 'images/1cyc.jpg', 1, 'Admin', 'Waa maxay naa niistaada?', 'Joker', '2022-06-30'),
(3, 3, 'xasan', '1234', 'Male', 'images/', 1, 'Cashier', 'Waa maxay dabeecadada?', 'Xanaaq', '2022-07-01'),
(4, 4, 'japir', '123', 'Male', 'images/', 1, 'Cashier', 'Maxaad u nooshahay?', 'Inaan Allaah Caabudo', '2022-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`user_id`, `menu_id`) VALUES
(0, 0),
(1, 1),
(3, 4),
(3, 5),
(3, 7),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `user_id` int(11) NOT NULL,
  `sub_menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`user_id`, `sub_menu_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 29),
(1, 31),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 18),
(3, 19),
(3, 20),
(3, 26),
(4, 13),
(4, 14);

-- --------------------------------------------------------

--
-- Structure for view `unpaid_orders_view`
--
DROP TABLE IF EXISTS `unpaid_orders_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unpaid_orders_view`  AS SELECT `o`.`order_id` AS `Order No`, `c`.`cust_name` AS `Name`, `c`.`tell` AS `Tell`, concat(`i`.`item_name`,' ',`i`.`Category`) AS `Item`, `p`.`item_type` AS `Item Type`, `o`.`qty` AS `Quantity`, `o`.`price` AS `Price`, `o`.`total_price` AS `Total`, ifnull(`r`.`paid`,0) AS `Paid`, ifnull(`r`.`discount`,0) AS `Discount`, `o`.`total_price` AS `Balance`, `o`.`RegDate` AS `Date` FROM ((((`orders` `o` join `customers` `c` on(`c`.`cust_id` = `o`.`cust_id`)) join `products` `p` on(`p`.`pro_id` = `o`.`pro_id`)) join `items` `i` on(`i`.`item_id` = `p`.`item_id`)) left join `receipt` `r` on(`r`.`order_id` = `o`.`order_id`)) WHERE !(`o`.`order_id` in (select `receipt`.`order_id` from `receipt`)) AND (`o`.`cust_id` like concat('%','%','%') OR `c`.`cust_name` like concat('%','%','%') OR `c`.`tell` like concat('%','%','%') OR `o`.`RegDate` like concat('%','%','%')) AND `o`.`status` = 11  ;

-- --------------------------------------------------------

--
-- Structure for view `unpaid_purchase_view`
--
DROP TABLE IF EXISTS `unpaid_purchase_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unpaid_purchase_view`  AS SELECT `pu`.`purchase_id` AS `Purchase No`, `s`.`name` AS `Name`, concat(`i`.`item_name`,' ',`i`.`Category`) AS `Item`, `p`.`item_type` AS `Item Type`, `pu`.`qty` AS `Quantity`, concat('$',`pu`.`price`) AS `Price`, concat('$',`pu`.`total_price`) AS `Total`, concat('$',ifnull(`pa`.`paid`,0)) AS `Paid`, concat('$',`pu`.`total_price`) AS `Balance` FROM ((((`purchase` `pu` join `supplier` `s` on(`s`.`supplier_id` = `pu`.`supplier_id`)) join `products` `p` on(`p`.`purchase_id` = `pu`.`purchase_id`)) join `items` `i` on(`i`.`item_id` = `pu`.`item_id`)) left join `payments` `pa` on(`pa`.`purchase_id` = `pu`.`purchase_id`)) WHERE !(`pu`.`purchase_id` in (select `pa`.`purchase_id` from `payments` `pa`)) AND (`pu`.`purchase_id` like concat('%','%','%') OR `s`.`name` like concat('%','%','%') OR `pu`.`RegDate` like concat('%','%','%')) AND `pu`.`status` = 11  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`),
  ADD UNIQUE KEY `account_no` (`account_no`,`bank_name`);

--
-- Indexes for table `chart`
--
ALTER TABLE `chart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `text` (`text`) USING HASH;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_chart`
--
ALTER TABLE `order_chart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `ref_no` (`ref_no`);

--
-- Indexes for table `pay_salary`
--
ALTER TABLE `pay_salary`
  ADD PRIMARY KEY (`pay_sal_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_chart`
--
ALTER TABLE `purchase_chart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`rec_id`),
  ADD UNIQUE KEY `ref_no` (`ref_no`);

--
-- Indexes for table `receipt_chart`
--
ALTER TABLE `receipt_chart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `store_out`
--
ALTER TABLE `store_out`
  ADD PRIMARY KEY (`store_out_id`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD UNIQUE KEY `user_id` (`user_id`,`menu_id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD UNIQUE KEY `user_id` (`user_id`,`sub_menu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chart`
--
ALTER TABLE `chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `exp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_chart`
--
ALTER TABLE `order_chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pay_salary`
--
ALTER TABLE `pay_salary`
  MODIFY `pay_sal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_chart`
--
ALTER TABLE `purchase_chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `receipt_chart`
--
ALTER TABLE `receipt_chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_out`
--
ALTER TABLE `store_out`
  MODIFY `store_out_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
