CREATE TABLE todos (
    id SERIAL,
    description VARCHAR NOT NULL,
    created TIMESTAMP DEFAULT now() NOT NULL,
    finished TIMESTAMP
);
