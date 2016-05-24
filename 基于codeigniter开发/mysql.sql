create database note_pages;

use note_pages;

drop table if exists apiInfo;

create table apiInfo (
   ownerId varchar(100),
   consumerName varchar(100),
   consumerKey varchar(100),
   consumerSecret varchar(100)
);

insert into apiInfo (ownerId,consumerName,consumerKey,consumerSecret) values(
   '姚锦铭',
   'note-pages',
   '?',
   '?'
);
