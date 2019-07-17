DROP TABLE IF EXISTS OrderedProduct;
DROP TABLE IF EXISTS Cart;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS Address;
DROP TABLE IF EXISTS ProductCategory;
DROP TABLE IF EXISTS User;

CREATE TABLE User(
userID int primary key auto_increment,
firstName varchar(64),
lastName varchar(64),
userName varchar(32) not null unique,
email varchar(255) not null unique,
contentType varchar(255) not null,
image mediumblob,
password char(32) not null,
isAdmin boolean not null default false,
isBanned boolean not null default false,
creationDate date
);

CREATE TABLE ProductCategory(
catID int primary key auto_increment,
description varchar(255),
catName varchar(255) unique 
);


CREATE TABLE Address(
addID int primary key auto_increment,
addy varchar(255),
city varchar(64),
province varchar(64),
country varchar(64),
postalCode char(6)
);

CREATE TABLE Products(
prodID int primary key auto_increment,
name varchar(40) not null unique,
description varchar(255),
price decimal(10,2) not null,
contentType varchar(255) not null,
image mediumblob,
catID int,
foreign key(catID) references ProductCategory(catID) on delete set null
);

CREATE TABLE Review(
revID int primary key auto_increment,
description varchar(255),
rating int not null check(rating<=5 and rating >=0),
revDate date,
userID int,
prodID int,
foreign key(userID) references User(userID) on delete cascade,
foreign key(prodID) references Products(prodID) on delete cascade
);

CREATE TABLE Orders(
orderID int primary key auto_increment,
placed date,
cost decimal(10,2),
userID int,
addID int,
foreign key(userID) references User(userID),
foreign key(addID) references Address(addID)
);

CREATE TABLE OrderedProduct(
prodID int,
orderID int,
amount int not null,
price decimal(10,2) not null,
primary key(prodID, orderID),
foreign key(prodID) references Products(prodID),
foreign key(orderID) references Orders(orderID)
);

CREATE TABLE Cart(
prodID int,
userID int,
amount int not null,
price decimal(10,2),
primary key(prodID,userID),
foreign key(prodID) references Products(prodID),
foreign key(userID) references User(userID)
);

INSERT INTO ProductCategory(description,catName) VALUES ("The all in one kit. Comes with planter, seeds, and a water tray","Pets");

SET @lastid = LAST_INSERT_ID();

INSERT INTO Products(name,description,price,catID) VALUES("Bob Ross","There is nothing wrong being friends with a plant.",20.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Donald Trump","To buy this you may need a small loan of a million dollars.",1000000.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Morty","Ohh Geez Rick I don't know.",15.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Rick","C'mon, Morty, lets go.",15.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Shrek","Get out of my swamp.",69.69,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Hello Kitty","Buy me meow.",17.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Groot","I am Groot!",19.00,@lastid);

INSERT INTO ProductCategory(description,catName) VALUES ("You kinda need these.","Seeds");

SET @lastid = LAST_INSERT_ID();

INSERT INTO Products(name,description,price,catID) VALUES("Normal Seeds","Just normal seeds.",4.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Super Seeds","These seeds grow fast!",5.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Bad Seeds","They are cheap.",1.49,@lastid);

INSERT INTO ProductCategory(description,catName) VALUES ("From A-Z anything you may need for your chia pet.","Extras");

SET @lastid = LAST_INSERT_ID();

INSERT INTO Products(name,description,price,catID) VALUES("Grow Spray","Speed up how fast your plants grow.",12.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Plant Killer","Is your friends pet growing faster? Kill it with this!",8.00,@lastid);
INSERT INTO Products(name,description,price,catID) VALUES("Water Tray","Save your window sill with this handy tray.",0.99,@lastid);