--rozszerzenie pgcrypto

CREATE EXTENSION IF NOT EXISTS pgcrypto;

--register_user

CREATE OR REPLACE FUNCTION register_user(
    _email VARCHAR,
    _username VARCHAR,
    _password VARCHAR
) RETURNS INTEGER AS $$
DECLARE
    _hashed_password VARCHAR;
    _id_user INTEGER;
BEGIN
    IF EXISTS (SELECT 1 FROM users WHERE email = _email) THEN
        RAISE EXCEPTION 'EMAIL_TAKEN';
    END IF;

    _hashed_password := crypt(_password, gen_salt('bf'));

    INSERT INTO users (email, username, password)
    VALUES (_email, _username, _hashed_password)
    RETURNING id_user INTO _id_user;

    INSERT INTO activity (id_user) VALUES (_id_user);

    RETURN _id_user;
END;
$$ LANGUAGE plpgsql;

--login_user

CREATE OR REPLACE FUNCTION login_user(
    _email VARCHAR,
    _password VARCHAR
) RETURNS TABLE(id_user INT, username VARCHAR, id_activity INT) AS $$
DECLARE
    _hashed VARCHAR;
BEGIN
    SELECT u.id_user, u.username, u.password
    INTO id_user, username, _hashed
    FROM users u
    WHERE u.email = _email;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'EMAIL_NOT_FOUND';
    END IF;

    IF NOT crypt(_password, _hashed) = _hashed THEN
        RAISE EXCEPTION 'INVALID_PASSWORD';
    END IF;

    INSERT INTO activity (id_user) VALUES (id_user)
    RETURNING activity.id_activity INTO login_user.id_activity;

    RETURN NEXT;
    RETURN;
END;
$$ LANGUAGE plpgsql;

--logout_user

CREATE OR REPLACE FUNCTION logout_user(
    _id_activity INT
) RETURNS VOID AS $$
BEGIN
    UPDATE activity
    SET logout = NOW()
    WHERE id_activity = _id_activity;
END;
$$ LANGUAGE plpgsql;

--update_user_interests

CREATE OR REPLACE PROCEDURE update_user_interests(
    _id_user INT,
    _interests INT[]
)
LANGUAGE plpgsql
AS $$
BEGIN
    DELETE FROM user_interests WHERE id_user = _id_user;

    IF array_length(_interests, 1) IS NOT NULL THEN
        INSERT INTO user_interests (id_user, id_interest)
        SELECT _id_user, unnest(_interests);
    END IF;
END;
$$;