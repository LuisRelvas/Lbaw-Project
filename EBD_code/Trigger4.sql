CREATE FUNCTION verify_self_follow() RETURNS TRIGGER AS

$BODY$  

BEGIN

IF NEW.user_id1 = NEW.user_id2 THEN

RAISE EXCEPTION 'An User cannot be his follower';

END IF;

RETURN NEW;

END 

$BODY$ 

LANGUAGE plpgsql; 

CREATE TRIGGER verify_self_follow

BEFORE INSERT OR UPDATE ON follows

FOR EACH ROW

EXECUTE PROCEDURE verify_self_follow();
