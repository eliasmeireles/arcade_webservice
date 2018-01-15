DROP SCHEMA IF EXISTS arcade_data_players;

CREATE SCHEMA arcade_data_players;

USE arcade_data_players;

DROP TABLE IF EXISTS player;

CREATE TABLE player (
  id     BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
  nome   VARCHAR(155)                      NOT NULL,
  pontos BIGINT                            NOT NULL,
  data   DATE                              NOT NULL
);


DROP TABLE IF EXISTS player_old;

CREATE TABLE player_old (
  id     BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
  nome   VARCHAR(155)                      NOT NULL,
  pontos BIGINT                            NOT NULL,
  data   DATE                              NOT NULL
);

DROP TABLE IF EXISTS user_root;

CREATE TABLE user_root (
  id    BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
  email VARCHAR(200)                      NOT NULL UNIQUE,
  senha CHAR(60)                          NOT NULL
);

DROP TABLE IF EXISTS application_permition;

CREATE TABLE application_permition(
  id CHAR(36) UNIQUE     NOT NULL,
  permition_token CHAR(36) UNIQUE     NOT NULL
);

INSERT INTO application_permition VALUES('bwfa80c9-9284-173d-94db-759a9030905c', 'ftfa80c9-9284-473d-94db-759a9030905c');

CREATE DEFINER =`root`@`localhost` TRIGGER `arcade_data_players`.`player_BEFORE_DELETE`
  BEFORE DELETE
  ON `player`
  FOR EACH ROW
  BEGIN
    INSERT INTO player_old (id, nome, pontos, data)
    VALUES (old.id, old.nome, old.pontos, old.data);
  END