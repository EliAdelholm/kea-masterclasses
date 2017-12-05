-- Update User
UPDATE kea_masterclasses.users 
	SET name ="A", password = "A" , notification =1, image ='assets/img/userimage-5a1fd2b3a61c.', description = "bla bla bla" 
	WHERE id =1;

-- Delete User
START TRANSACTION;
	
	DELETE FROM attendance
	WHERE user_id = 3;

	DELETE FROM users_emails
	WHERE user_id = 3;
    
	DELETE FROM users_interests
	WHERE users_id = 3;
    
	DELETE FROM users_phones
	WHERE users_id = 3;    

	DELETE FROM users
	WHERE id = 3;
    
COMMIT;

-- Register attendance
INSERT INTO kea_masterclasses.attendance (event_id, user_id) VALUES (1, 2);

-- Unregister attendance
DELETE FROM kea_masterclasses.attendance WHERE event_id=2 and user_id=1;

-- Add rating
update attendance set rating=3 WHERE event_id=1 and  user_id=1; 

-- Get number of attendees for event
SELECT event_id, COUNT(user_id) AS registered_users
FROM  attendance
GROUP BY event_id;

