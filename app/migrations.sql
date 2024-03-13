create table hours
(
    id    int auto_increment,
    title varchar(10) not null,
    constraint hours_pk
        primary key (id)
);

INSERT INTO hours (id, title) VALUES (1, '9:00');
INSERT INTO hours (id, title) VALUES (2, '10:00');
INSERT INTO hours (id, title) VALUES (3, '11:00');
INSERT INTO hours (id, title) VALUES (4, '12:00');
INSERT INTO hours (id, title) VALUES (5, '13:00');
INSERT INTO hours (id, title) VALUES (6, '14:00');
INSERT INTO hours (id, title) VALUES (7, '15:00');
INSERT INTO hours (id, title) VALUES (8, '16:00');
INSERT INTO hours (id, title) VALUES (9, '17:00');
INSERT INTO hours (id, title) VALUES (10, '18:00');

create table users
(
    id       int auto_increment,
    username varchar(40)  not null,
    password varchar(100) not null,
    name     varchar(50)  not null,
    constraint users_pk
        primary key (id),
    constraint users_username_unique
        unique (username)
);
INSERT INTO users (id, username, password, name) VALUES (1, 'mreza_golestan', '12345', 'محمدرضا گلستان');
INSERT INTO users (id, username, password, name) VALUES (2, 'akhgar', '12345', 'افشین اخگر');

create table reservations
(
    id      int auto_increment,
    hour_id int         not null,
    date    varchar(10) not null,
    user_id int         not null,

    constraint reservations_fk_hour_id
        primary key (id),
    constraint reservations_unique
        unique (date, hour_id),
    constraint reservations_hours_id_fk
        foreign key (hour_id) references hours (id),
    foreign key (user_id) references users (id)
);