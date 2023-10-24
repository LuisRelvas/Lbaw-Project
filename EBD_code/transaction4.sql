-- Start a transaction with BEGIN
BEGIN;

SAVEPOINT my_savepoint;

DO $$
DECLARE
    inserted_user_id INT;
    inserted_comments_id INT;
BEGIN
    -- Insert the data into the 'likes_on_comments' table and capture the values into variables
    INSERT INTO likes_on_comments(user_id, comments_id)
    VALUES ($user_id, $comments_id)
    RETURNING user_id, comments_id INTO inserted_user_id, inserted_comments_id;

    -- Insert data into the 'notification' table with the captured values
    INSERT INTO notification (received_user, emits_user, date)
    VALUES (
        (SELECT author_id FROM comment WHERE id = inserted_comments_id),
        inserted_user_id,
        current_date
    );

    -- Insert data into the 'comment_notification' table
    INSERT INTO comment_notification (id, comment_id, notification_type)
    VALUES (currval('notification_id_seq'), inserted_comments_id, 'liked_comment');

END $$;
ROLLBACK TO my_savepoint;

DO $$
DECLARE
    inserted_user_id INT;
    inserted_comments_id INT;
BEGIN
    -- Insert the data into the 'likes_on_comments' table and capture the values into variables
    INSERT INTO likes_on_comments(user_id, comments_id)
    VALUES ($user_id, $comments_id)
    RETURNING user_id, comments_id INTO inserted_user_id, inserted_comments_id;

    -- Insert data into the 'notification' table with the captured values
    INSERT INTO notification (received_user, emits_user, date)
    VALUES (
        (SELECT author_id FROM comment WHERE id = inserted_comments_id),
        inserted_user_id,
        current_date
    );

    -- Insert data into the 'comment_notification' table
    INSERT INTO comment_notification (id, comment_id, notification_type)
    VALUES (currval('notification_id_seq'), inserted_comments_id, 'liked_comment');

END $$;

-- Commit the transaction
COMMIT;
