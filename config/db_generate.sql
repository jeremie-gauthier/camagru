-- TESTS

INSERT INTO users(pseudo, email, password) VALUES ("jergauth", "jergauth@student.42.fr", "abcd"), ("fviret", "fviret@student.42.fr", "abcd");
INSERT INTO pictures(diUsers, encoding, legend) VALUES (1, "AAAA", "Photo de vacances"), (2, "BBBB", NULL), (1, "AABB", NULL);
INSERT INTO likes(diUsers, diPictures) VALUES (1, 1), (2, 1), (1, 2);
INSERT INTO comments(diUsers, diPictures, comment) VALUES (2, 1, "Super photo"), (1, 1, "Merci !");
