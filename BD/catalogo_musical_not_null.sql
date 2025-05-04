
drop database if exists blog_musical;
create database blog_musical;
use blog_musical;

create table roles(
    id int not null primary key auto_increment,
    nombre varchar(255) not null
);

create table usuarios(
    id int not null primary key auto_increment,
    nombre varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    rol_id int not null,
    fecha_creacion datetime not null default current_timestamp(),
    foreign key (rol_id) references roles(id)
    on delete restrict on update cascade
);

create table artistas(
    id int not null primary key auto_increment,
    nombre varchar(255) not null,
    imagen varchar(255) not null,
    descripcion text not null,
    fecha_creacion datetime not null default current_timestamp(),
    usuario_id int not null,
    foreign key (usuario_id) references usuarios(id)
    on delete restrict on update cascade
);

create table albumes(
    id int not null primary key auto_increment,
    titulo varchar(255) not null,
    descripcion text not null,
    imagen varchar(255) not null,
    fecha_lanzamiento datetime not null,
    artista_id int not null,
    fecha_creacion datetime not null default current_timestamp(),
    foreign key (artista_id) references artistas(id)
    on delete restrict on update cascade
);

create table canciones(
    id int not null primary key auto_increment,
    titulo varchar(255) not null,
    imagen varchar(255) not null,
    duracion time not null,
    archivo_audio varchar(255) not null,
    album_id int not null,
    artista_id int not null,
    fecha_creacion datetime not null default current_timestamp(),
    foreign key (album_id) references albumes(id)
        on delete restrict on update cascade,
    foreign key (artista_id) references artistas(id)
        on delete restrict on update cascade
);





insert into roles values (1,'Administrador');
insert into roles values (2,'Registrado');

create view view_usuarios as
select u.id, u.nombre, u.email, u.password, r.nombre as rol, u.fecha_creacion
from usuarios u, roles r
where u.rol_id = r.id;


create view view_artistas as
select a.id, a.nombre, a.imagen, a.descripcion, a.usuario_id, u.nombre as creador, a.fecha_creacion
from artistas a, usuarios u
where a.usuario_id = u.id;

create view view_albumes as
select al.id, al.titulo, al.descripcion, al.imagen, al.fecha_lanzamiento, al.artista_id, ar.nombre as artista, al.fecha_creacion
from albumes al, artistas ar
where al.artista_id = ar.id;

CREATE OR REPLACE VIEW view_canciones AS
SELECT
  c.id,
  c.titulo,
  c.imagen,
  c.duracion,
  c.archivo_audio,
  c.album_id,
  al.titulo AS album,
  ar.nombre AS artista,
  ar.id AS artista_id     
FROM canciones c
JOIN albumes al ON c.album_id = al.id
JOIN artistas ar ON al.artista_id = ar.id;



