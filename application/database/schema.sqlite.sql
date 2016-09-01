DROP TABLE review;
CREATE TABLE review
(
  id            INTEGER     NOT NULL PRIMARY KEY AUTOINCREMENT,
  name          VARCHAR(50) NOT NULL,
  email         VARCHAR(50) NOT NULL,
  file_name     VARCHAR(7)                       DEFAULT NULL,
  creation_date timestamp   NOT NULL,
  show          TINYINT     NOT NULL             DEFAULT 0,
  edited        TINYINT     NOT NULL             DEFAULT 0,
  text          TEXT
);
