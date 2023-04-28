CREATE DATABASE "Quinielas"
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;


CREATE TABLE public.equipos
(
    id serial,
    nombre character varying(30),
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.equipos
    OWNER to postgres;


CREATE TABLE public.jornadas
(
    id serial,
    jornada integer,
    fecha date,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.jornadas
    OWNER to postgres;

CREATE TABLE public.partidos
(
    id serial,
    jornada integer,
    orden integer,
    fecha date,
    idlocal integer,
    idvisitante integer,
    goleslocal integer,
    golesvisitante integer,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.partidos
    OWNER to postgres;

ALTER SEQUENCE equipos_id_seq RESTART WITH 1;