
#Go to the kea_masterclasses in your db program then right click on stored procedures and click
#'create stored procedure' Copy paste the code from below and save it. Now you can delete users

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser`(IN userId INT)
BEGIN
	DELETE FROM attendance
    WHERE user_id = userId;
    DELETE FROM users_interests
    WHERE users_id = userId;
	DELETE FROM users_emails
    WHERE user_id = userId;
    DELETE FROM users_phones
    WHERE users_id = userId;
    DELETE FROM users
    where id = userId;
END

DELIMITER ;